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
        
        $page = new PageModel();

        if (isset($_GET['id'])) {
            $retrievedPost = $page->getOneBy(['id' => $_GET['id']], 'object');
            if (!empty($retrievedPost)) {
                $page = $retrievedPost;
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (!empty($_POST['id'])) {
                $page->setId(intval($_POST['id']));
            }
            
            $_POST['pageSlug'] = str_replace(' ', '', strtolower($_POST['pageSlug']));

            $page->setSlug($_POST['pageSlug']);

            $formattedDate = date('Y-m-d H:i:s');
            $page2 = $page->getOneBy(['slug' => $_POST['pageSlug']], 'object');

            if(!$page2 || $page2->getId() == $page->getId()){
                $page->setTitle($_POST['title']);
                $page->setContent(strip_tags(stripslashes($_POST['content']), $allowedTags));
                $page->setStatus("Publié");
                $page->setCreationDate($formattedDate);
                $page->setModificationDate($formattedDate);
        
               
                $missingFields = $page->validate();

                if (count($missingFields) === 0) {
                    $pageId = $page->save();
                    $savedPage = $page->getOneBy(['id' => $pageId], 'object');
                    $page = $savedPage;
                    $info = "Page sauvegardée";
                }
            }else{
                $errorSlug = "Slug déjà existant, veuillez en choisir un autre";
            }
        }

        
        // if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //     $page = new PageModel();
        //     $pageSlug = strtolower(str_replace(' ', '-', $_POST['title']));
            
        //     $page->setTitle($_POST['title']);
        //     $page->setContent(strip_tags(stripslashes($_POST['content']), $allowedTags));
        //     $page->setCreationDate($formattedDate);
        //     $page->setModificationDate($formattedDate);
        //     $page->setSlug($pageSlug);
        //     $page->setStatus('Publié');
        //     $page->save();
        //     $success[] = "Votre catgégorie a été créée";
        // }
        $view = new View("Page/add-page", "back");
        $view->assign("mediasList", $mediasList ?? []);
        $view->assign("page", $page);
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