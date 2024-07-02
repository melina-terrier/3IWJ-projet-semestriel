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
                        $success[] = 'Page supprimée avec succès.';
                    }
                } else if ($_GET['action'] === 'permanent-delete') {
                    if ($pageModel->delete(['id' => (int)$_GET['id']])) {
                        $success[] = 'Page définitivement supprimée.';
                    }
                } else if ($_GET['action'] === 'restore') {
                    $status = $statusModel->getByName('Brouillon');
                    $currentPage->setStatus($status);
                    if ($currentPage->save()) {
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
        
        $formattedDate = date('Y-m-d H:i:s', time());
        if (isset($_SESSION['user_id'])){
            $userId = $_SESSION['user_id'];
        } else {
            $userId = null;
        }
        $historyEntry = new PageHistory();
        
        if (isset($_GET['id']) && $_GET['id']) {
            $pageId = $_GET['id'];
            $selectedPage = $page->populate($pageId, 'array');
            if ($selectedPage) {
                $form->setField($selectedPage);
                $seoAnalysis = $selectedPage->getSeoAnalysis();
                $seoStatus = $selectedPage->getSeoStatus();
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

                if ($selectedPage->getTitle() !== $_POST['title'] ||
                $selectedPage->getContent() !== $_POST['content'] |
                $selectedPage->getSlug() !== $_POST['slug']) {
                    $historyEntry->setPageId($pageId);
                    $historyEntry->setTitle($selectedPage->getTitle());
                    $historyEntry->setContent($selectedPage->getContent());
                    $historyEntry->setSlug($selectedPage->getSlug());
                    $historyEntry->setCreationDate($formattedDate);
                    $historyEntry->save();
                }
                  
                $page->setId($selectedPage->getId());
                $page->setModificationDate($formattedDate);
                $page->setCreationDate($selectedPage->getCreationDate());

                if ($_POST['slug'] !== $selectedPage->getSlug()) {
                    $slug = $_POST['slug'];
                    if (!empty($slug) && !$page->isUnique(['slug'=>$_POST['slug']])) {
                        $errors[] = 'Le slug existe déjà pour un autre projet';
                    } else {
                        if (empty($slug)){
                            if (!$page->isUnique(['title'=>$_POST['title']])){
                                $existingPages = $page->getAllData(['title'=>$_POST['title']]);
                                $count = count($existingPages);
                                $page->setSlug($_POST['title'] . '-' . ($count + 1));    
                            } else {
                                $page->setSlug($_POST['title']);
                            }
                        } else {
                            $page->setSlug($_POST['slug']);
                        }
                    }
                } else {
                    $page->setSlug($selectedPage->getSlug());
                }

                if (isset($_POST['history'])){
                    $selectedHistoryId = $_POST['history'];
                    $selectedHistoryEntry = $historyEntry->getOneBy(['id' => $selectedHistoryId], 'object');
                    if ($selectedHistoryEntry) {
                        $page->setId($selectedPage->getId());
                        $page->setTitle($selectedHistoryEntry->getTitle());
                        $page->setContent($selectedHistoryEntry->getContent());
                        $page->setSlug($selectedHistoryEntry->getSlug());
                        $page->setCreationDate($selectedHistoryEntry->getCreationDate());
                        $page->setModificationDate(date('Y-m-d H:i:s')); 
                        $page->setUser($userId);
                        $success[] = 'La page a été restaurée avec succès';
                    } else {
                        $errors[] = 'Historique introuvable';
                    }
                } 
            } else {
                $page->setCreationDate($formattedDate);
                $page->setModificationDate($formattedDate);
                $slug = $_POST['slug'];
                if (!empty($slug) && !$page->isUnique(['slug'=>$_POST['slug']])) {
                    $errors[] = 'Le slug existe déjà pour un autre projet';
                } else {
                    if (empty($slug)){
                        if (!$page->isUnique(['title'=>$_POST['title']])){
                            $existingPages = $page->getAllData(['title'=>$_POST['title']]);
                            $count = count($existingPages);
                            $page->setSlug($_POST['title'] . '-' . ($count + 1));    
                        } else {
                            $page->setSlug($_POST['title']);
                        }
                    } else {
                        $page->setSlug($_POST['slug']);
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
                $page->setPublicationDate($formattedDate);
                $page->setStatus($statusId);
                if ($page->save()){
                    header('Location: /dashboard/page?message=success');
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