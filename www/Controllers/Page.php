<?php

namespace App\Controllers;

use App\Core\Form;
use App\Core\View;
use App\Core\PageBuilder;
use App\Models\Media;
use App\Controllers\Error;
use App\Models\User;
use App\Models\Status as StatusModel;
use App\Models\Page as PageModel;

class Page
{

    public function allPages(): void
    {
    $pageModel = new PageModel();
    $pages = $pageModel->getAllData("object"); 
    $statusModel = new StatusModel();
    $statuses = $statusModel->getAllData("object");
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
    $view = new View("Page/pages-list", "back");
    $view->assign("pages", $pages);
    $view->assign("statuses", $statuses);
    $view->render();
    }


    public function addPage(): void
    {

        $allowedTags = '<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
        $allowedTags .= '<li><ol><ul><span><div><br><ins><del><table><tr><td><th><tbody><thead><tfoot>';
        $allowedTags .= '<a><hr><iframe><video><source><embed><object><param>';

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
        
        if( $form->isSubmitted() && $form->isValid() )
        {   
            $statusModel = new StatusModel();
            $statuses = $statusModel->getAllData("object");
            $statusId = $statusModel->getOneBy(["status"=>"published"], 'object');
            $status = $statusId->getId();

            $page = new PageModel();

            $page->setTitle($_POST['title']);
            $page->setContent(strip_tags(stripslashes($_POST['content']), $allowedTags));
        
            $slug = $_POST['slug'];
            if (empty($slug)) {
                $slug = strtolower(preg_replace('/\s+/', '-', $_POST['title']));
                $page->setSlug($slug);
            } else {
                $page->setSlug($_POST['slug']);
            }
            $page->setUser($userId);
            $page->setCreationDate($formattedDate);
            $page->setPublicationDate($formattedDate);
            $page->setModificationDate($formattedDate);
            $page->setStatus($status);
            $page->save();

            $success[] = "Votre page a été publiée";
        }

        $view = new View("Page/add-page", "back");
        $view->assign("form", $form->build());
        $view->assign("mediasList", $mediasList ?? []);
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
        $view->render();
    }


 public function editPage(): void
    {
        $page = new pageModel();
        $form = new Form("AddPage");
        // if (isset($_GET['id']) && $_GET['id']) {
        //     $pageId = $_GET['id'];
        //     $currentPage = $page->getOneBy(['id' => $pageId], 'object');
        //     if ($currentPage) {
        //         $errors = [];
        //         $success = [];
        //         $form->setField('title', $currentPage->getTitle());
        //         $form->setField('content', $currentPage->getContent());
        //         $form->setField('slug', $currentPage->getSlug());
        //         $userSerialized = $_SESSION['user'];
        //         $user = unserialize($userSerialized);
        //         $userId = $user->getId();
        //         $formattedDate = date('Y-m-d H:i:s');

        //         if( $form->isSubmitted() && $form->isValid() )
        //         {
        //             $slug = $_POST['slug'];
        //             if (empty($slug)) {
        //                 $slug = strtolower(preg_replace('/\s+/', '-', $_POST['name']));
        //                 $page->setSlug($slug);
        //             } else {
        //                 $page->setSlug($_POST['slug']);
        //             }
        //             $page->setTitle($_POST['title']);
        //             $page->setContent($_POST['content']);
        //             $page->setCreationDate($currentPage->getCreationDate());
        //             $page->setModificationDate($formattedDate);
        //             $page->setUserId($userId);
        //             $page->save();
        //             $success[] = "La page ".$_POST['title']."a été mise à jour";
        //         }
        //         
        //         $view->assign("errorsForm", $errors);
        //         $view->assign("successForm", $success);
        //         $view->render();
        //     }
        // }
        $view = new View("Page/edit-page", "back");
        $view->assign("form", $form->build());
    }

    public function showPage($slug){
        $db = new PageModel();
        $statusModel = new StatusModel();
        $status = $statusModel->getOneBy(["status" => "published"], 'object');
        $publishedStatusId = $status->getId();

        $slugTrim = str_replace('/', '', $slug);
        $arraySlug = ["slug" => $slugTrim];
        $page = $db->getOneBy($arraySlug);

        if (!empty($page) && $page["status_id"] === $publishedStatusId) {
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