<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Form;
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

            // $status = getDataId("published");

            $tag->setName($_POST['name']);
            $tag->setSlug($_POST['slug']);
            $tag->setDescription($_POST['description']);
            $tag->setCreationDate($formattedDate);
            $tag->setModificationDate($formattedDate);
            $tag->setUserId($userId);
            $tag->setStatus(1);
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

        if (isset($_GET['id'])) {
            $existingTag = $tag->getOneBy(['id' => $_GET['id']], 'object');
            if ($existingTag) {
                $name = $tag->getName();
                print_r($tag->getName());
                // $form->setValue('name', $existingTag->getName());
                // $form->setValue('slug', $existingTag->getSlug());
                // $form->setValue('description', $existingTag->getDescription());
            }
        }

        if( $form->isSubmitted() && $form->isValid() )
        {
            // $status = getDataId("published");
            $tag->setName($_POST['name']);
            $tag->setSlug($_POST['slug']);
            $tag->setDescription($_POST['description']);
            $tag->setCreationDate($formattedDate);
            $tag->setModificationDate($formattedDate);
            $tag->setUserId($userId);
            $tag->setStatus(1);
            $tag->save();
            $success[] = "La catégorie".$_POST['name']."a été créée";
        }
          
        $view = new View("Tag/tag", "back");
        $view->assign("form", $form->build());
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
        $view->render();
    
    }

}