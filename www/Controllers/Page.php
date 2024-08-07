<?php

namespace App\Controllers;
use App\Core\Form;
use App\Core\View;
use App\Models\Media;
use App\Models\User;
use App\Controllers\Error;
use App\Controllers\SEO;
use App\Models\Status;
use App\Models\PageHistory;
use App\Models\Page as PageModel;

class Page {

    public function allPages(): void
    {
        $errors = [];
        $success = [];
        $pageModel = new PageModel();
        $allPages = $pageModel->getAllData(null, null, 'array'); 
        $statusModel = new Status();
        $userModel = new User();
        
        if (isset($_GET['action']) && isset($_GET['id'])) {
            $currentPage = $pageModel->populate($_GET['id']);
            if ($currentPage) {
                if ($_GET['action'] === 'delete') {
                    $deletedStatus = $statusModel->getByName('Supprimé');
                    $currentPage->setStatus($deletedStatus);
                    if ($currentPage->save()) {
                        header('Location: /dashboard/pages?message=delete-success');
                    }
                } else if ($_GET['action'] === 'permanent-delete') {
                    if ($pageModel->delete(['id' => (int)$_GET['id']])) {
                        header('Location: /dashboard/pages?message=permanent-delete-success');
                    }
                } else if ($_GET['action'] === 'restore') {
                    $status = $statusModel->getByName('Brouillon');
                    $currentPage->setStatus($status);
                    if ($currentPage->save()) {
                        header('Location: /dashboard/pages?message=restore-success');
                        $success[] = 'Page restaurée avec succès.';
                    }
                } else {
                    $errors[] = 'Action invalide.';
                }
            } else {
                $errors[] = 'Page introuvable.';
            }
        }

        foreach ($allPages as &$page) {
            $pageModels = $pageModel->populate($page['id']);
            $userId = $page['user_id'];
            $statusId = $page['status_id'];
            $page['user_name'] ='';
            $page['status_name'] ='';
            if ($userId || $statusId) {
                $user = $userModel->populate($userId);
                $status = $statusModel->populate($statusId);
                if ($user) {
                    $page['user_name'] = $user->getUserName();
                }
                if ($status){
                    $page['status_name'] = $status->getName();
                }
            }
            $page['seo_status'] = $pageModels->getSeoStatus();
        }
        $view = new View('Page/pages-list', 'back');
        $view->assign('pages', $allPages);
        $view->assign('errors', $errors);
        $view->assign('successes', $success);
        $view->render();
    }


    public function addPage(): void
    {
        $page = new PageModel();
        $media = new Media();
        $medias = $media->getAllData(null, null, 'object');
        $seoStatus = '';
        $seoAdvices = '';
        $seoAnalysis = '';
        
        if (count($medias) > 0) {
            $mediasList = array();
            foreach ($medias as $media) {
                $mediasList[] = ['title' => $media->getTitle(), 'value' => $media->getUrl()];
            }
        }
        
        $form = new Form('AddPage');
        $errors = [];
        $success = [];
        
        if (isset($_SESSION['user_id'])){
            $userId = $_SESSION['user_id'];
        } else {
            $userId = null;
        }
        $historyEntry = new PageHistory();
        
        if (isset($_GET['id']) && $_GET['id']) {
            $pageId = $_GET['id'];
            $selectedPage = $page->populate($pageId, 'array');
            $objectPage = $page->populate($pageId, 'object');
            if ($selectedPage) {
                $form->setField($selectedPage);
                $seoAnalysis = $objectPage->getSeoAnalysis();
                $seoStatus = $objectPage->getSeoStatus();
                $seoAdvices = $this->getSeoAdvices($seoAnalysis);
            } else {
                $errors[] = 'Page introuvable.';
            }
        }

        $seoScore = '';
        $seoSuggestions = '';

        if( $form->isSubmitted() && $form->isValid() )
        {  
            if(isset($_GET['id']) && $_GET['id']){

                if ($objectPage->getTitle() !== $_POST['title'] ||
                $objectPage->getContent() !== $_POST['content'] |
                $objectPage->getSlug() !== $_POST['slug']) {
                    $historyEntry->setPageId($pageId);
                    $historyEntry->setTitle($objectPage->getTitle());
                    $historyEntry->setContent($objectPage->getContent());
                    $historyEntry->save();
                }
                  
                $page->setId($objectPage->getId());

                if ($_POST['slug'] !== $objectPage->getSlug()) {
                    $slug = $_POST['slug'];
                    $slug = trim(strtolower($slug));
                    $slug = str_replace(' ', '-', $slug);
                    $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
                    $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
                    $slug = str_replace($search, $replace, $slug);
                    $pattern = '/[^a-zA-Z0-9\/-]/'; 
                    $slug = preg_replace('[' . $pattern . ']', '', $slug);
                    if (!empty($slug)){
                        if($page->isUnique(['slug'=>$slug])>0) {
                            $errors[] = 'Le slug existe déjà pour un autre projet';
                        } else {
                            $page->setSlug($_POST['slug']);
                        }
                    } else {
                        $name = trim(strtolower($_POST['title']));
                        $name = str_replace(' ', '-', $name);
                        $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
                        $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
                        $name = str_replace($search, $replace, $name);
                        $pattern = '/[^a-zA-Z0-9\/-]/'; 
                        $name = preg_replace('[' . $pattern . ']', '', $name);
                        if ($page->isUnique(['slug'=>$name.'-%'], 'ILIKE')>0){
                            $existingPages = $page->getAllData(['slug'=>$name.'-%'], null, 'array', 'ILIKE');
                            $count = count($existingPages);
                            $page->setSlug($_POST['title'] . '-' . ($count + 1));    
                        } else {
                            $page->setSlug($_POST['title']);
                        }
                    }
                } else {
                    $page->setSlug($objectPage->getSlug());
                }

                if (isset($_POST['history'])){
                    $selectedHistoryId = $_POST['history'];
                    $selectedHistoryEntry = $historyEntry->getOneBy(['id' => $selectedHistoryId], 'object');
                    if ($selectedHistoryEntry) {
                        $page->setId($selectedPage->getId());
                        $page->setTitle($selectedHistoryEntry->getTitle());
                        $page->setContent($selectedHistoryEntry->getContent());
                        $page->setSlug($selectedHistoryEntry->getSlug());
                        $page->setUser($userId);
                        $success[] = 'La page a été restaurée avec succès';
                    } else {
                        $errors[] = 'Historique introuvable';
                    }
                } 
            } else {
                if (!empty($slug)){
                    $slug = $_POST['slug'];
                    $slug = $_POST['slug'];
                    $slug = trim(strtolower($slug));
                    $slug = str_replace(' ', '-', $slug);
                    $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
                    $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
                    $slug = str_replace($search, $replace, $slug);
                    $pattern = '/[^a-zA-Z0-9\/-]/'; 
                    $slug = preg_replace('[' . $pattern . ']', '', $slug);
                    if($page->isUnique(['slug'=>$slug])>0) {
                        $errors[] = 'Le slug existe déjà pour un autre projet';
                    } else {
                        $page->setSlug($_POST['slug']);
                    }
                } else {
                    $name = trim(strtolower($_POST['title']));
                    $name = str_replace(' ', '-', $name);
                    $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
                    $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
                    $name = str_replace($search, $replace, $name);
                    $pattern = '/[^a-zA-Z0-9\/-]/'; 
                    $name = preg_replace('[' . $pattern . ']', '', $name);
                    if ($page->isUnique(['slug'=>$name.'-%'], 'ILIKE')>0){
                        $existingPages = $page->getAllData(['slug'=>$name.'-%'], null, 'array', 'ILIKE');
                        $count = count($existingPages);
                        $page->setSlug($_POST['title'] . '-' . ($count + 1));    
                    } else {
                        $page->setSlug($_POST['title']);
                    }
                }
            }
            $page->setTitle($_POST['title']);
            $page->setContent(($_POST['content']));
            $page->setUser($userId);
            $page->setSeoTitle(isset($_POST['seo_title']) && !empty($_POST['seo_title']) ? $_POST['seo_title'] : $_POST['title']);
            $page->setSeoDescription($_POST['seo_description']);
            $page->setSeoKeyword($_POST['seo_keyword']);
            $statusModel = new Status();
            if (isset($_POST['submit-draft'])) {
                $statusId = $statusModel->getByName('Brouillon');
                $page->setStatus($statusId);
                if ($page->save()){
                    $success[] = 'Votre projet a été enregistré en brouillon';
                } else {
                    $errors[] = 'Une erreur est survenue lors de l\'enregistrement de la page.';
                }
            } else {
                $statusId = $statusModel->getByName('Publié');
                $page->setStatus($statusId);
                if ($page->save()){
                    header('Location: /dashboard/pages?message=success');
                    exit;
                } else {
                    $errors[] = 'Une erreur est survenue lors de l\'enregistrement de la page.';
                }
            }
        }
        $view = new View('Page/add-page', 'back');
        $view->assign('seoScore', $seoScore);
        $view->assign('seoSuggestions', $seoSuggestions);
        $view->assign('form', $form->build());
        $view->assign('seoAnalysis', $seoAnalysis);
        $view->assign('seoStatus', $seoStatus);
        $view->assign('seoAdvices', $seoAdvices);
        $view->assign('mediasList', $mediasList ?? []);
        $view->assign('errors', $errors);
        $view->assign('successes', $success);
        $view->render();
    }


    private function getSeoAdvices(array $seoAnalysis): array
    {
        $advices = [];

        if (!$seoAnalysis['external_links']) {
            $advices[] = 'Il n’y a pas de lien externe dans cette page. Ajoutez-en !';
        }

        if (!$seoAnalysis['images']) {
            $advices[] = 'Il n’y a pas d’image dans cette page. Ajoutez-en !';
        }

        if (!$seoAnalysis['internal_links']) {
            $advices[] = 'Il n’y a aucun lien interne dans cette page, assurez-vous d’en ajouter !';
        }

        if (!$seoAnalysis['keyword_presence']) {
            $advices[] = 'Aucune requête cible n’a été définie pour cette page. Renseignez une requête afin de calculer votre score SEO.';
        }

        if (!$seoAnalysis['meta_description_length']) {
            $advices[] = 'Aucune méta description n’a été renseignée. Les moteurs de recherches afficheront du contenu de la page à la place. Assurez-vous d\'en écrire une !';
        }

        if (!$seoAnalysis['content_length']) {
            $advices[] = 'Le texte contient moins de 300 mots. Ajoutez plus de contenu.';
        }

        if (!$seoAnalysis['seo_title_length']) {
            $advices[] = 'La longueur du titre SEO n\'est pas optimale. Assurez-vous qu\'il soit entre 50 et 60 caractères.';
        }

        return $advices;
    }
}