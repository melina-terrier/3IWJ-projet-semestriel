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
                    $projectsTag = new Project_Tags();
                    $tagsToDelete = $projectsTag->getAllData(['tag_id'=>$tagToDelete->getId()]);
                    foreach($tagsToDelete as $tags){
                        $projectsTag->delete(['id' => $tags['id']]);
                    }
                    $tag->delete(['id' => $tagToDelete->getId()]);
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

                if ($_POST['slug'] !== $currentTag['slug']) {
                    $slug = $_POST['slug'];
                    $slug = trim(strtolower($slug));
                    $slug = str_replace(' ', '-', $slug);
                    $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
                    $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
                    $slug = str_replace($search, $replace, $slug);
                    $pattern = '/[^a-zA-Z0-9\/-]/'; 
                    $slug = preg_replace('[' . $pattern . ']', '', $slug);
                    if (!empty($slug) && $tag->isUnique(['slug'=>$slug])>0) {
                        $errors[] = 'Le slug existe déjà pour une autre catégorie';
                    } else {
                        if (empty($slug)) {
                            $name = trim(strtolower($_POST['name']));
                            $name = str_replace(' ', '-', $name);
                            $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
                            $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
                            $name = str_replace($search, $replace, $name);
                            $pattern = '/[^a-zA-Z0-9\/-]/'; 
                            $name = preg_replace('[' . $pattern . ']', '', $name);
                            if ($tag->isUnique(['slug'=>$name.'-%'], 'ILIKE')>0){
                                $existingTags = $tag->getAllData(['slug'=>$name.'-%'], null, 'array', 'ILIKE');
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
                $slug = $_POST['slug'];
                if (!empty($slug)){
                    $slug = $_POST['slug'];
                    $slug = trim(strtolower($slug));
                    $slug = str_replace(' ', '-', $slug);
                    $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
                    $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
                    $slug = str_replace($search, $replace, $slug);
                    $pattern = '/[^a-zA-Z0-9\/-]/'; 
                    $slug = preg_replace('[' . $pattern . ']', '', $slug);
                    if ($tag->isUnique(['slug'=>$slug])>0) {
                        $errors[] = 'Le slug existe déjà pour une autre catégorie';
                    } else {
                        $tag->setSlug($slug);
                    }
                } else {
                    $name = trim(strtolower($_POST['name']));
                    $name = str_replace(' ', '-', $name);
                    $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
                    $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
                    $name = str_replace($search, $replace, $name);
                    $pattern = '/[^a-zA-Z0-9\/-]/'; 
                    $name = preg_replace('[' . $pattern . ']', '', $name);
                    if ($tag->isUnique(['slug'=>$name.'-%'], 'ILIKE')>0){
                        $existingTags = $tag->getAllData(['slug'=>$name.'-%'], null, 'array', 'ILIKE');
                        $count = count($existingTags);
                        $tag->setSlug($_POST['name'] . '-' . ($count + 1));    
                    } else {
                        $tag->setSlug($_POST['name']);
                    }
                }
            }
            $tag->setName($_POST['name']);
            $tag->setDescription($_POST['description']);
            $tag->setUserId($_SESSION['user_id']);
            if (empty($errors)){
                $tag->save();
                header('Location: /dashboard/tags?message=success');
                exit();
            }
        }
        $view = new View('Tag/tag', 'back');
        $view->assign('form', $form->build());
        $view->assign('errorsForm', $errors);
        $view->render();
    }
}