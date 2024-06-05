<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Form;
use App\Core\SQL;
use App\Models\User;
use App\Models\Project;
use App\Models\Tag as  TagModel;

class Tag{

    public function allTags(): void
    {
        $tag = new TagModel();
        $tags = $tag->getAllData("object");
        $errors = [];
        $success = [];
        if (isset($_GET['action']) && isset($_GET['id'])) {
            if ($_GET['action'] === "delete") {
                $tag->delete(['id' => (int)$_GET['id']]);
                header('Location: /dashboard/tags?message=delete-success');
                exit;
            }
        }
        $view = new View("Tag/tags-list", "back");
        $view->assign("errors", $errors);
        $view->assign("success", $success);
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


    public function editTag(): void
    {
        $tag = new TagModel();
        if (isset($_GET['id']) && $_GET['id']) {
            $tagId = $_GET['id'];
            $currentTag = $tag->getOneBy(['id' => $tagId], 'object');
            if ($currentTag) {
                $form = new Form("EditTag");
                $errors = [];
                $success = [];

                $form->setField('name', $currentTag->getName());
                $form->setField('description', $currentTag->getDescription());
                $form->setField('slug', $currentTag->getSlug());
                
                $userSerialized = $_SESSION['user'];
                $user = unserialize($userSerialized);
                $userId = $user->getId();
                $formattedDate = date('Y-m-d H:i:s');

                if( $form->isSubmitted() && $form->isValid() )
                {
                    $slug = $_POST['slug'];
                    if (empty($slug)) {
                        $slug = strtolower(preg_replace('/\s+/', '-', $_POST['name']));
                        $tag->setSlug($slug);
                    } else {
                        $tag->setSlug($_POST['slug']);
                    }
                    $tag->setName($_POST['name']);
                    $tag->setDescription($_POST['description']);
                    $tag->setCreationDate($currentTag->getCreationDate());
                    $tag->setModificationDate($formattedDate);
                    $tag->setUserId($userId);
                    $tag->save();
                    $success[] = "La catégorie".$_POST['name']."a été mise à jour";
                    header("Location: /dashboard/tags?message=update-success");
                    exit; 
                }
                $view = new View("Tag/tag", "back");
                $view->assign("form", $form->build());
                $view->assign("errorsForm", $errors);
                $view->assign("successForm", $success);
                $view->render();
            } else {

            }
        }
    }
}