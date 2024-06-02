<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Form;
use App\Core\SQL;
use App\Models\User;
use App\Models\Tag as  TagModel;

class Tag{

    public function allTags(): void
    {
        $tag = new TagModel();
        $tags = $tag->getAllData("object");


        $form = new Form("AddTag");
        $errors = [];
        $success = [];

        $userSerialized = $_SESSION['user'];
        $user = unserialize($userSerialized);
        $userId = $user->getId();

        $formattedDate = date('Y-m-d H:i:s');

        if( $form->isSubmitted() && $form->isValid() )
        {

            $status = getDataId("published");

            $tag->setName($_POST['name']);
            $tag->setSlug($_POST['slug']);
            $tag->setDescription($_POST['description']);
            $tag->setCreationDate($formattedDate);
            $tag->setModificationDate($formattedDate);
            $tag->setUserId($userId);
            $tag->setStatus($status);
            $tag->save();
            $success[] = "La catégorie".$_POST['name']."a été créée";
        }


        if (isset($_GET['action']) && isset($_GET['id'])) {
            if ($_GET['action'] === "delete") {
                $tagToDelete = $tag->getOneBy(['id' => $_GET['id']], 'object');
                $tagToDelete->setStatus(2);
                $tagToDelete->save();
                $success[] = "La catégorie a été supprimée";
            } else if ($_GET['action'] === "permanent-delete") {
                $tag->delete(['id' => (int)$_GET['id']]);
            }
        }

          
        $view = new View("Tag/tags-list", "back");
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
        $view->assign("tags", $tags);
        $view->render();
    
    }


    public function addTag(): void
    {
        $tag = new TagModel();
        $form = new Form("AddTag");
        $errors = [];
        $success = [];

        $userSerialized = $_SESSION['user'];
        $user = unserialize($userSerialized);
        $userId = $user->getId();

        $formattedDate = date('Y-m-d H:i:s');

        if( $form->isSubmitted() && $form->isValid() )
        {
            $sql = new SQL();
            $status = $sql->getDataId("published");

            $slug = $_POST['slug'];
            if (empty($slug)) {
                $slug = strtolower(preg_replace('/\s+/', '-', $_POST['name']));
                $tag->setSlug($slug);
            } else {
                $tag->setSlug($_POST['slug']);
            }

            $tag->setName($_POST['name']);
           
            $tag->setDescription($_POST['description']);
            $tag->setCreationDate($formattedDate);
            $tag->setModificationDate($formattedDate);
            $tag->setUserId($userId);
            $tag->setStatus($status);
            $tag->save();

            $success[] = "La catégorie".$_POST['name']."a été créée";

            header("Location: /dashboard/tags?message=success");
            exit; 
        }
          
        $view = new View("Tag/tag", "back");
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
        $view->render();
    
    }
}