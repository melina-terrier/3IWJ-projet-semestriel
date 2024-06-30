<?php
namespace App\Controllers;

use App\Core\Form;
use App\Core\View;
use App\Core\SQL;
use App\Controllers\Error;
use App\Models\Media;
use App\Models\Status;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Project_Tags;
use App\Models\Project as ProjectModel;
use App\Models\User;
use App\Core\Sitemap;

class Project{

    public function addProject(): void
    {
        $allowedTags = '<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
        $allowedTags .= '<li><ol><ul><span><div><br><ins><del><table><tr><td><th><tbody><thead><tfoot>';
        $allowedTags .= '<a><hr><iframe><video><source><embed><object><param>';

        $project = new ProjectModel();
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

        if (isset($_GET['id']) && $_GET['id']) {
            $projectId = $_GET['id'];
            $selectedProject = $project->getOneBy(["id"=>$projectId], 'object');
            if ($selectedProject) {
                $form->setField('title', $selectedProject->getTitle());
                $form->setField('content', $selectedProject->getContent());
                $form->setField('slug', $selectedProject->getSlug());
                $form->setField('tag', $selectedProject->getTag());

                $errorsUpdate = [];
                $successUpdate = [];
            } else {
                echo "Projet non trouvé.";
            }
        }

        if( $form->isSubmitted() && $form->isValid() )
        {
            if(isset($_GET['id']) && $_GET['id']){
                $project->setId($selectedProject->getId());
                $project->setModificationDate($formattedDate);
                $project->setCreationDate($selectedProject->getCreationDate());

                if ($_POST['slug'] !== $selectedProject->getSlug()) {
                    $slug = $_POST['slug'];
                    if (!empty($slug) && !empty($project->getOneBy(["slug"=>$_POST['slug']]))) {
                        $errors[] = "Le slug existe déjà pour un autre projet";
                    } else {
                        if (empty($slug)){
                            $existingName = $project->getOneBy(["title"=>$_POST['title']]);
                            if (!empty($existingName)){
                                $existingProjcts = $project->getAllDataWithWhere(["title"=>$_POST['title']]);
                                $count = count($existingProjcts);
                                $project->setSlug($_POST['title'] . '-' . ($count + 1));    
                            } else {
                                $project->setSlug($_POST['title']);
                            }
                        } else {
                            $project->setSlug($_POST['slug']);
                        }
                    }
                } else {
                    $project->setSlug($selectedProject->getSlug());
                }
            } else {
                $project->setCreationDate($formattedDate);
                $project->setModificationDate($formattedDate);
                $slug = $_POST['slug'];
                if (!empty($slug) && !empty($project->getOneBy(["slug"=>$_POST['slug']]))) {
                    $errors[] = "Le slug existe déjà pour un autre projet";
                } else {
                    if (empty($slug)){
                        $existingName = $project->getOneBy(["title"=>$_POST['title']]);
                        if (!empty($existingName)){
                            $existingProjcts = $project->getAllDataWithWhere(["title"=>$_POST['title']]);
                            $count = count($existingProjcts);
                            $project->setSlug($_POST['title'] . '-' . ($count + 1));    
                        } else {
                            $project->setSlug($_POST['title']);
                        }
                    } else {
                        $project->setSlug($_POST['slug']);
                    }
                }
            }
            $project->setTitle($_POST['title']);
            $project->setContent(strip_tags(stripslashes($_POST['content']),  $allowedTags));
            $project->setUser($userId);
            if (!empty($_POST['tag'])) {
                $project->setTag($_POST['tag']);
            }

           // $project->setFeaturedImage($_POST['featured_image']);

            $statusModel = new Status();
            if (isset($_POST['submit-draft'])) {
                $statusId = $statusModel->getOneBy(["status"=>"Brouillon"], 'object');
                $status = $statusId->getId();
                $project->setStatus($status);
                $success[] = "Votre projet a été enregistré en brouillon";
            } else {
                $statusId = $statusModel->getOneBy(["status"=>"Publié"], 'object');
                $status = $statusId->getId();
                $project->setPublicationDate($formattedDate);
                $project->setStatus($status);
            }
            $project->save();
            $sitemap = new Sitemap();
            $sitemap->renderSiteMap();
            header("Location: /dashboard/projects?&&message=success");
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
        $allProjects = $project->getAllData("array");
        $statusModel = new Status();
        $userModel = new User();
        $sitemap = new Sitemap();

        if (isset($_GET['action']) && isset($_GET['id'])) {
            $currentProject = $project->getOneBy(['id' => $_GET['id']], 'object');
            if ($_GET['action'] === "delete") {
                $status = $statusModel->getOneBy(["status"=>"deleted"], 'object');
                $statusId = $status->getId();
                $currentProject->setStatus($statusId);
                $currentProject->save();
                $sitemap->renderSiteMap();
                header('Location: /dashboard/projects?message=delete-success');
                exit;
            } else if ($_GET['action'] === "permanent-delete") {
                $project->delete(['id' => (int)$_GET['id']]);
                $sitemap->renderSiteMap();
                header('Location: /dashboard/projects?message=permanent-delete-success');
                exit;
            } else if ($_GET['action'] === "restore") {
                $status = $statusModel->getOneBy(["status"=>"draft"], 'object');
                $statusId = $status->getId();
                $currentProject->setStatus($statusId);
                $currentProject->save();
                $sitemap->renderSiteMap();
                header('Location: /dashboard/projects?message=restore-success');
                exit;
            }
        }

        foreach ($allProjects as &$project) {
            $userId = $project['user_id'];
            $statusId = $project['status_id'];
            $project['user_name'] ='';
            $project['status_name'] ='';
            if ($userId || $statusId) {
                $user = $userModel->getOneBy(['id' => $userId], 'object');
                $status = $statusModel->getOneBy(['id' => $statusId], 'object');
                if ($user || $status) {
                    $project['user_name'] = $user->getUserName();
                    $project['status_name'] = $status->getName();
              }
            }
          }

        $view = new View("Project/projects-list", "back");
        $view->assign("projects", $allProjects);
        $view->assign("errors", $errors);
        $view->assign("successes", $success);
        $view->render();
    }
    
    public function showProject($slug)
    {
        $projectTagsId = [];
        $slugParts = explode('/', $slug);
        $slug = end($slugParts);
        $db = new ProjectModel();
        $statusModel = new Status();
        $status = $statusModel->getOneBy(["status" => "Publié"], 'object');
        $publishedStatusId = $status->getId();
    
        $slugTrim = str_replace('/', '', $slug);
        $arraySlug = ["slug" => $slugTrim];
        $project = $db->getOneBy($arraySlug);
    
        $tags = new Tag();
        $tag = $tags->getOneBy($arraySlug);
        $requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
        if (!empty($project) && ($project["status_id"] === $publishedStatusId || (isset($_GET['preview']) && $_GET['preview'] == true))) {
            $content = $project["content"];
            $title = $project["title"];
    
            $form = new Form("AddComment");
            $errors = [];
            $success = [];
    
            $tagName = "";
            $projectTags = new Project_Tags();
            $projectTagsId = $projectTags->getAllDataWithWhere(['project_id' => $project['id']]);
            if ($projectTagsId) {
                foreach ($projectTagsId as $projectTagId) {
                    $tagId = $tags->getOneBy(['id' => $projectTagId['tag_id']]);
                    if ($tagId) {
                        $tagName .= $tagId['name'] . ', ';
                    }
                }
                $tagName = rtrim($tagName, ', ');
            }
    
            if ($form->isSubmitted() && $form->isValid()) {
                $comment = new Comment();
    
                $comment->setComment($_POST['comment']);
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
    
            $commentModel = new Comment();
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
        } else if (!empty($tag)) {
            $title = $tag['name'];
            $description = $tag['description'];
    
            $projects = $db->getAllDataWithWhere(['tag_id' => $tag['id']]);
            $userModel = new User();
            foreach ($projects as &$project) {
                $userId = $project['user_id'];
                $project['username'] = '';
                $project['userSlug'] = '';
                if ($userId) {
                    $user = $userModel->getOneBy(['id' => $userId], 'object');
                    if ($user) {
                        $project['username'] = $user->getUserName();
                        $project['userSlug'] = $user->getSlug();
                    }
                }
            }
            $view = new View('Main/all-projects', 'front');
            $view->assign("title", $title);
            $view->assign("description", $description);
            $view->assign("projects", $projects);
            $view->render();
        } else if ($requestUrl === '/projects' || $requestUrl === '/projects//') {
            $projectTags = new Project_Tags();
            $projects = $db->getAllDataWithWhere(['status_id' => $publishedStatusId]);
            $userModel = new User();
            foreach ($projects as &$project) {
                $userId = $project['user_id'];
                $project['category_name'] = '';
                $project['username'] = '';
                $project['userSlug'] = '';
                $project['profile_photo'] = '';
                if ($userId) {
                    $user = $userModel->getOneBy(['id' => $userId], 'object');
                    if ($user) {
                        $project['username'] = $user->getUserName();
                        $project['userSlug'] = $user->getSlug();
                        $project['profile_photo'] = $user->getPhoto();
                    }
                }
                if ($projectTagsId) {
                    foreach ($projectTagsId as $projectTagId) {
                        $tagId = $tags->getOneBy(['id' => $projectTagId['tag_id']]);
                        if ($tagId) {
                            $project['category_name'] .= $tagId['name'] . ', ';
                        }
                    }
                    $project['category_name'] = rtrim($project['category_name'], ', ');
                }
            }
    
            $view = new View("Main/all-projects", "front");
            $view->assign("projects", $projects);
            $view->render();
        } else {
            header("Status 404 Not Found", true, 404);
            $error = new Error();
            $error->page404();
        }
    }
    
}
?>