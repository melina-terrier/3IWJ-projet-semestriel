<?php
namespace App\Controllers;
use App\Core\View;
use App\Core\Form;
use App\Models\User;
use App\Models\Project;
use App\Models\Project_Tags;
use App\Models\Tag as TagModel;

class Tag{

    public function allTags(): void
    {
        $tag = new TagModel();
        $tags = $tag->getAllData();
        $errors = [];

        if (isset($_GET['action']) && isset($_GET['id'])) {
            if ($_GET['action'] === 'delete') {
                $tagToDelete = $tag->populate($_GET['id']);
                if($tagToDelete){
                    $tag->delete(['id' => (int)$_GET['id']]);
                    header('Location: /dashboard/tags?message=delete-success');
                } else {
                    $errors[] = 'La catégorie n\'existe pas.';
                }
            }
        }

        $projectCounts = [];
        foreach ($tags as $tag) {
            $tagId = $tag['id'];
            if ($tagId !== null) {
                $projectTagsModel = new Project_Tags();
                $projectCount = $projectTagsModel->countElements('tag_id', $tagId);
                $projectCounts[] = ['id' => $tagId, 'projectCount' => $projectCount];
            }
        }

        $view = new View('Tag/tags-list', 'back');
        $view->assign('errors', $errors);
        $view->assign('projectCounts', $projectCounts);
        $view->assign('tags', $tags);
        $view->render();
    }

    public function addTag(): void
    {
        $tag = new TagModel();
        $form = new Form('AddTag');
        $errors = [];

        if (isset($_GET['id']) && $_GET['id']) {
            $tagId = $_GET['id'];
            $currentTag = $tag->populate($tagId, 'array');
            if ($currentTag) {
                $form->setField($currentTag);
            } else {
                $errors[] = 'La catégorie n\'existe pas.';
            }
        }

        if( $form->isSubmitted() && $form->isValid() )
        {

            if (isset($_GET['id']) && $_GET['id']) {
                $tag->setId($currentTag['id']);
                $tag->setModificationDate(date('Y-m-d H:i:s', time()));
                $tag->setCreationDate($currentTag['creation_date']);
                
                if ($_POST['slug'] !== $currentTag['slug']) {
                    $slug = $_POST['slug'];
                    if (!empty($slug) && $tag->isUnique(['slug'=>$_POST['slug']])>0) {
                        $errors[] = 'Le slug existe déjà pour un autre projet';
                    } else {
                        if (empty($slug)) {
                            if ($tag->isUnique(['name'=>$_POST['name']])>0){
                                $existingTags = $tag->getAllData(['name'=>$_POST['name']]);
                                $count = count($existingTags);
                                $tag->setSlug($_POST['name'] . '-' . ($count + 1));    
                            } else {
                                $tag->setSlug($_POST['name']);
                            }
                        } else {
                            $tag->setSlug($_POST['slug']);
                        }
                    } 
                } else {
                    $tag->setSlug($currentTag['slug']);
                }
            } else {
                $tag->setModificationDate(date('Y-m-d H:i:s', time()));
                if (empty($slug)){
                   if ($tag->isUnique(['name'=>$_POST['name']])>0){
                        $existingTags = $tag->getAllData(['name'=>$_POST['name']]);
                        $count = count($existingTags);
                        $tag->setSlug($_POST['name'] . '-' . ($count + 1));    
                    } else {
                        $tag->setSlug($_POST['name']);
                    }
                } else {
                    $tag->setSlug($_POST['slug']);
                }
            }
            $tag->setName($_POST['name']);
            $tag->setDescription($_POST['description']);
            $tag->setUserId($_SESSION['user_id']);
            $tag->save();
            header('Location: /dashboard/tags?message=success');
            exit();
        }
        $view = new View('Tag/tag', 'back');
        $view->assign('form', $form->build());
        $view->assign('errors', $errors);
        $view->render();
    }
}