<?php

namespace App\Controllers;

use App\Core\Form;
use App\Core\View;
use App\Core\PageBuilder;
use App\Models\Media;
use App\Controllers\Error;
use App\Models\User as UserModel;
use App\Models\Status as StatusModel;
use App\Models\Page as PageModel;

class Page
{

    public function allPages(): void
    {
        $errors = [];
        $success = [];
        $pageModel = new PageModel();
        $allPages = $pageModel->getAllData("array"); 
        $statusModel = new StatusModel();
        $userModel = new UserModel();

    
        if (isset($_GET['action']) && isset($_GET['id'])) {
            $currentPage = $pageModel->getOneBy(['id' => $_GET['id']], 'object');
            if ($_GET['action'] === "delete") {
                $status = $statusModel->getOneBy(["status"=>"deleted"], 'object');
                $statusId = $status->getId();
                $currentPage->setStatus($statusId);
                $currentPage->save();
                header('Location: /dashboard/pages?message=delete-success');
                exit;
            } else if ($_GET['action'] === "permanent-delete") {
                $pageModel->delete(['id' => (int)$_GET['id']]);
                header('Location: /dashboard/pages?message=permanent-delete-success');
                exit;
            } else if ($_GET['action'] === "restore") {
                $status = $statusModel->getOneBy(["status"=>"draft"], 'object');
                $statusId = $status->getId();
                $currentPage->setStatus($statusId);
                $currentPage->save();
                header('Location: /dashboard/pages?message=restore-success');
                exit;
            }
        }

        foreach ($allPages as &$page) {
            $userId = $page['user_id'];
            $statusId = $page['status_id'];
            $page['user_name'] ='';
            $page['status_name'] ='';
            if ($userId || $statusId) {
                $user = $userModel->getOneBy(['id' => $userId], 'object');
                $status = $statusModel->getOneBy(['id' => $statusId], 'object');
                if ($user || $status) {
                    $page['user_name'] = $user->getUserName();
                    $page['status_name'] = $status->getName();
              }
            }
          }
        $view = new View("Page/pages-list", "back");
        $view->assign("pages", $allPages);
        $view->assign("errors", $errors);
        $view->assign("successes", $success);
        $view->render();
    }


    public function addPage(): void
    {
        $allowedTags = '<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
        $allowedTags .= '<li><ol><ul><span><div><br><ins><del><table><tr><td><th><tbody><thead><tfoot>';
        $allowedTags .= '<a><hr><iframe><video><source><embed><object><param>';

        $page = new PageModel();
        $media = new Media();
        $medias = $media->getAllData("object");
        if (count($medias) > 0) {
            $mediasList = array();
            foreach ($medias as $media) {
                $mediasList[] = ['title' => $media->getTitle(), 'value' => $media->getUrl()];
            }
        }
        
        $form = new Form("AddPage");
        $errors = [];
        $success = [];

        $formattedDate = date('Y-m-d H:i:s');
        $userSerialized = $_SESSION['user'];
        $user = unserialize($userSerialized);
        $userId = $user->getId();

        if (isset($_GET['id']) && $_GET['id']) {
            $pageId = $_GET['id'];
            $selectedPage = $page->getOneBy(["id"=>$pageId], 'object');
            if ($selectedPage) {
                $form->setField('title', $selectedPage->getTitle());
                $form->setField('content', $selectedPage->getContent());
                $form->setField('slug', $selectedPage->getSlug());
                $errorsUpdate = [];
                $successUpdate = [];
            } else {
                echo "Page non trouvée.";
            }
        }
        
        if( $form->isSubmitted() && $form->isValid() )
        {   
            if(isset($_GET['id']) && $_GET['id']){
                $page->setId($selectedPage->getId());
                $page->setModificationDate($formattedDate);
                $page->setCreationDate($selectedPage->getCreationDate());

                if ($_POST['slug'] !== $selectedPage->getSlug()) {
                    $slug = $_POST['slug'];
                    if (!empty($slug) && !empty($page->getOneBy(["slug"=>$_POST['slug']]))) {
                        $errors[] = "Le slug existe déjà pour un autre projet";
                    } else {
                        if (empty($slug)){
                            $existingName = $page->getOneBy(["title"=>$_POST['title']]);
                            if (!empty($existingName)){
                                $existingPages = $page->getAllDataWithWhere(["title"=>$_POST['title']]);
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
            } else {
                $page->setCreationDate($formattedDate);
                $page->setModificationDate($formattedDate);
                $slug = $_POST['slug'];
                if (!empty($slug) && !empty($page->getOneBy(["slug"=>$_POST['slug']]))) {
                    $errors[] = "Le slug existe déjà pour un autre projet";
                } else {
                    if (empty($slug)){
                        $existingName = $page->getOneBy(["title"=>$_POST['title']]);
                        if (!empty($existingName)){
                            $existingPages = $page->getAllDataWithWhere(["title"=>$_POST['title']]);
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
            $page->setContent(strip_tags(stripslashes($_POST['content']), $allowedTags));
            $page->setUser($userId);
            $statusModel = new StatusModel();
            if (isset($_POST['submit-draft'])) {
                $statusId = $statusModel->getOneBy(["status"=>"draft"], 'object');
                $status = $statusId->getId();
                $page->setStatus($status);
                $success[] = "Votre projet a été enregistré en brouillon";
            } else {
                $statusId = $statusModel->getOneBy(["status"=>"published"], 'object');
                $status = $statusId->getId();
                $page->setPublicationDate($formattedDate);
                $page->setStatus($status);
                $success[] = "Votre projet a été publié";  
            }
            $page->save();
        }
        $view = new View("Page/add-page", "back");
        $view->assign("form", $form->build());
        $view->assign("mediasList", $mediasList ?? []);
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
        $view->render();
    }

    public function showPage($slug){
        $db = new PageModel();
        $statusModel = new StatusModel();
        $status = $statusModel->getOneBy(["status" => "published"], 'object');
        $publishedStatusId = $status->getId();

        $slugTrim = str_replace('/', '', $slug);
        $arraySlug = ["slug" => $slugTrim];
        $page = $db->getOneBy($arraySlug);

        if (!empty($page) && $page["status_id"] === $publishedStatusId || (isset($_GET['preview']) && $_GET['preview'] == true)) {
            $content = $page["content"];
            $title = $page["title"];
    
            $requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $routeFound = false;
            if ($slug === $requestUrl) {
                $routeFound = true;
            }
            if ($routeFound) {
                $view = new View("Main/page", "front");
                $view->assign("content", $content);
                $view->assign("title", $title);
                $view->render(); 
            }
        } else {
            header("Status 404 Not Found", true, 404);
            $error = new Error();
            $error->page404();
        }

    }
}