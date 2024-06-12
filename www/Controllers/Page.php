<?php

namespace App\Controllers;

use App\Core\SQL;
use App\Core\Form;
use App\Core\View;
use App\Core\PageBuilder;
use App\Models\Media;
use App\Models\User;
use App\Models\Page as PageModel;

class Page
{

    public function allPages(): void
    {
        $page = new PageModel();
        $pages = $page->getAllData("object");

        $view = new View("Page/pages-list", "back");
        $view->assign("pages", $pages);
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
            $sql = new SQL();
            $status = $sql->getDataId("published");
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

    // public function addPage(): void
    // {
    //     $form = new Form("AddPage");

    //     if( $form->isSubmitted() && $form->isValid() )
    //     {
            
    //     }

    //     $view = new View("Page/add-page", "back");
    //     $view->assign("form", $form->build());
    //     $view->render();
    // }

}