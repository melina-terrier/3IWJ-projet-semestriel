<?php
namespace App\Controllers;

use App\Core\Form;
use App\Core\View;
use App\Core\SQL;
use App\Models\Status as StatusModel;
use App\Models\Media;
use App\Controllers\Error;
use App\Models\Tag as TagModel;
use App\Models\Comment as CommentModel;
use App\Models\Project as ProjectModel;

class Project{

    public function addProject(): void
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

        $form = new Form("AddProject");
        $errors = [];
        $success = [];

        $formattedDate = date('Y-m-d H:i:s');
        $userSerialized = $_SESSION['user'];
        $user = unserialize($userSerialized);
        $userId = $user->getId();

        if( $form->isSubmitted() && $form->isValid() )
        {
            $sql = new SQL();
            
            $status = $sql->getDataId("published"); // Assuming published by default

            // Check for a hidden field indicating draft (optional)
            // if (isset($_POST['draft']) && $_POST['draft'] === 'Enregistrer le brouillon') {
            //     $status = $sql->getDataId("draft");
            //     $success[] = "Votre projet a été enregistré en brouillon";
            // }


            $project = new ProjectModel();
            $project->setTitle($_POST['title']);
            $project->setContent(strip_tags(stripslashes($_POST['content']),  $allowedTags));
           
            $slug = $_POST['slug'];
            if (empty($slug)) {
                $slug = strtolower(preg_replace('/\s+/', '-', $_POST['title']));
                $project->setSlug($slug);
            } else {
                $project->setSlug($_POST['slug']);
            }

            $project->setUser($userId);
            if ($_POST['tag'] == 0) {
                $project->setTag(null); // Set tag to null if value is 0
            } else {
                $project->setTag($_POST['tag']);
            }
            
            $project->setCreationDate($formattedDate);
            $project->setPublicationDate($formattedDate);
            $project->setModificationDate($formattedDate);
            $project->setStatus($status);
            $project->save();

            $success[] = "Votre projet a été publié";
        }
        $view = new View("Project/add-project", "back");
        $view->assign("form", $form->build());
        $view->assign("mediasList", $mediasList ?? []);
        $view->assign("errorsForm", $errors);
        $view->assign("successForm", $success);
        $view->render();
    }


    public function allProjects(): void
    {
        $errors = [];
        $success = [];
        $project = new ProjectModel();
        $allProjects = $project->getAllData("object");
        $statusModel = new StatusModel();
        $statuses = $statusModel->getAllData("object");

        if (isset($_GET['action']) && isset($_GET['id'])) {
            $currentProject = $project->getOneBy(['id' => $_GET['id']], 'object');
            if ($_GET['action'] === "delete") {
                $status = $statusModel->getOneBy(["status"=>"deleted"], 'object');
                $statusId = $status->getId();
                $currentProject->setStatus($statusId);
                $currentProject->save();
                header('Location: /dashboard/projects?message=delete-success');
                exit;
            } else if ($_GET['action'] === "permanent-delete") {
                $project->delete(['id' => (int)$_GET['id']]);
                header('Location: /dashboard/projects?message=permanent-delete-success');
                exit;
            } else if ($_GET['action'] === "restore") {
                $status = $statusModel->getOneBy(["status"=>"draft"], 'object');
                $statusId = $status->getId();
                $currentProject->setStatus($statusId);
                $currentProject->save();
                header('Location: /dashboard/projects?message=restore-success');
                exit;
            }
        }
        $view = new View("Project/projects-list", "back");
        $view->assign("projects", $allProjects);
        $view->assign("statuses", $statuses);
        $view->assign("errors", $errors);
        $view->assign("success", $success);
        $view->render();
    }


    public function editProject(): void
    {
        $project = new ProjectModel();
        if (isset($_GET['project']) && $_GET['project']) {
            $projectId = $_GET['project'];
            $selectedProject = $project->getProjectsAndBlogs("project", $projectId);

            if ($selectedProject) {
                $formUpdate = new UpdateProject();
                $configUpdate = $formUpdate->getConfig($selectedProject[0]["title"], $selectedProject[0]["body"], $selectedProject[0]["id"]);
                $errorsUpdate = [];
                $successUpdate = [];

                $view = new View("Project/edit-projects", "back");
                $view->assign("project", $selectedProject);
                $view->assign("configForm", $configUpdate);
                $view->assign("errorsForm", $errorsUpdate);
                $view->assign("successForm", $successUpdate);
                $view->render();
            } else {
                echo "Project non trouvé.";
            }
        }
    }


    public function showProject($slug){
        $slugParts = explode('/', $slug);
        $slug = end($slugParts);
        $db = new ProjectModel();
        $statusModel = new StatusModel();
        $status = $statusModel->getOneBy(["status" => "published"], 'object');
        $publishedStatusId = $status->getId();

        $slugTrim = str_replace('/', '', $slug);
        $arraySlug = ["slug" => $slugTrim];
        $project = $db->getOneBy($arraySlug);
        
        if (!empty($project) && $project["status_id"] === $publishedStatusId) {
            $content = $project["content"];
            $title = $project["title"];
            // print_r($project);
            
            $requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $routeFound = false;
            if ('/projects/'.$slug === $requestUrl) {
                $routeFound = true;
            }
            if ($routeFound) {
                $form = new Form("AddComment");
                $errors = [];
                $success = [];

                $tag = new TagModel;
                $tagName="";
                $tag = $tag->getOneBy(['id'=>$project['tag_id']], 'object');
                if ($tag){
                    $tagName = $tag->getName(); 
                }

                $formattedDate = date('Y-m-d H:i:s');
                if( $form->isSubmitted() && $form->isValid() )
                {
                    $comment = new CommentModel();

                    $comment->setComment($_POST['comment']);
                    $comment->setCreationDate($formattedDate);
                    $comment->setModificationDate($formattedDate);
                    $comment->setProject($project['id']);
                    $comment->setStatus(0);

                    if (isset($_SESSION['user'])) {
                        $user = unserialize($_SESSION['user']);
                        $userId = $user->getId();
                        $userEmail = $user->getEmail();
                        $userName = $user->getUserName();
                        $comment->setUserId($userId);
                        $comment->setMail($userEmail);
                        $comment->setName($userName);
                        $comment->save();
                        $success[] = "Votre commentaire a été publié";
                    } else {
                        $user = new User();
                        if ($user->emailExists($_POST["email"])) {
                            $errors[] = "L'email correspond à un compte, merci de bien vouloir vous connecter";
                        } else {
                            $comment->setMail($_POST['email']);
                            $comment->setName($_POST['name']);
                            $comment->save();
                            $success[] = "Votre commentaire a été publié";
                        }
                    }
                }

                $commentModel = new CommentModel();
                $comments = $commentModel->getAllData();
                $filteredComments = [];
                foreach ($comments as $comment) {
                if ($comment['status'] === 1 && $comment['project_id'] == $project['id']) {
                    $filteredComments[] = $comment;
                }
                }

                $view = new View("Main/project", "front");
                $view->assign("content", $content);
                $view->assign("tagName", $tagName);
                $view->assign("title", $title);
                $view->assign("form", $form->build());
                $view->assign("errorsForm", $errors);
                $view->assign("successForm", $success);
                $view->assign("comments", $filteredComments);
                $view->render(); 
            }
        } else {
            header("Status 404 Not Found", true, 404);
            $error = new Error();
            $error->page404();
        }

    }
}

