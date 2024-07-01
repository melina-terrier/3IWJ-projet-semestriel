<?php
namespace App\Controllers;
use App\Core\Form;
use App\Core\View;
use App\Controllers\Error;
use App\Controllers\Media as MediaController;
use App\Models\Media;
use App\Models\Status;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Project_Tags;
use App\Models\Project as ProjectModel;
use App\Models\User;

class Project{

    public function addProject(): void
    {

        $project = new ProjectModel();
        $media = new Media();
        $view = new View("Project/add-project", "back");
        $medias = $media->getAllData(null, null, "object");
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
        $userId = $_SESSION['user_id'];

        if (isset($_GET['id']) && $_GET['id']) {
            $projectId = $_GET['id'];
            $selectedProject = $project->populate($projectId, 'array');

            if ($selectedProject) {
                $form->setField($selectedProject);
                $seoAnalysis = $selectedProject->getSeoAnalysis();
                $seoStatus = $selectedProject->getSeoStatus();
                $seoAdvices = $this->getSeoAdvices($seoAnalysis);

                $view->assign("seoAnalysis", $seoAnalysis);
                $view->assign("seoStatus", $seoStatus);
                $view->assign("seoAdvices", $seoAdvices);
            } else {
                echo "Projet introuvable.";
            }
        }

        if( $form->isSubmitted() && $form->isValid() )
        {
            if(isset($_GET['id']) && $_GET['id']){
                $project->setId($selectedProject['id']);
                $project->setModificationDate($formattedDate);
                $project->setCreationDate($selectedProject['creation_date']);

                if ($_POST['slug'] !== $selectedProject->getSlug()) {
                    $slug = $_POST['slug'];
                    if (!empty($slug) && !$project->isUnique(["slug"=>$_POST['slug']])) {
                        $errors[] = "Le slug existe déjà pour un autre projet";
                    } else {
                        if (empty($slug)){
                            if (!$project->isUnique(["title"=>$_POST['title']])){
                                $existingProjcts = $project->getAllData(["title"=>$_POST['title']]);
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
                    $project->setSlug($selectedProject['slug']);
                }
            } else {
                $project->setCreationDate($formattedDate);
                $project->setModificationDate($formattedDate);
                $slug = $_POST['slug'];
                if (!empty($slug) && !$project->isUnique(["slug"=>$_POST['slug']])) {
                    $errors[] = "Le slug existe déjà pour un autre projet";
                } else {
                    if (empty($slug)){
                        if (!$project->isUnique(["title"=>$_POST['title']])){
                            $existingProjcts = $project->getAllData(["title"=>$_POST['title']]);
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
            $project->setContent($_POST['content']);
            $project->setUser($userId);
            if (!empty($_POST['tag'])) {
                $project->setTag($_POST['tag']);
            }
            $project->setSeoTitle(isset($_POST['seo_title']) && !empty($_POST['seo_title']) ? $_POST['seo_title'] : $_POST['title']);
            $project->setSeoDescription($_POST['seo_description']);
            $project->setSeoKeyword($_POST['seo_keyword']);
            $project->setFeaturedImage($_POST['featured_image']);

            $statusModel = new Status();
            if (isset($_POST['submit-draft'])) {
                $statusId = $statusModel->getByName("Brouillon");
                $project->setStatus($statusId);
                if ($project->save()){
                    $success[] = "Votre projet a été enregistré en tant que brouillon";
                } else {
                    $errors[] = "Une erreur est survenue lors de l\'enregistrement du projet";

                }
            } else {
                $statusId = $statusModel->getByName("Publié");
                $project->setPublicationDate($formattedDate);
                $project->setStatus($statusId);
                if ($project->save()) {
                    header("Location: /dashboard/projects?message=success");
                } else {
                    $errors[] = "Une erreur est survenue lors de l\'enregistrement du projet";
                }
            }
        }
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
        $allProjects = $projects->getAllData(null, null, "array");
        $projects = new ProjectModel();
        $statusModel = new Status();
        $userModel = new User();

        if (isset($_GET['action']) && isset($_GET['id'])) {
            $currentProject = $projects->populate($_GET['id']);
            if ($currentProject){
                if ($_GET['action'] === "delete") {
                    $status = $statusModel->getByName("deleted");
                    $currentProject->setStatus($status);
                    if ($currentProject->save()){
                        $success[] = "Projet supprimé avec succès.";
                    }
                } else if ($_GET['action'] === "permanent-delete") {
                    if($projects->delete(['id' => (int)$_GET['id']])) {
                        $success[] = "Projet définitivement supprimée.";
                    }
                } else if ($_GET['action'] === "restore") {
                    $status = $statusModel->getByName("draft");
                    $currentProject->setStatus($status);
                    if ($currentProject->save()) {
                        $success[] = "Page restaurée avec succès.";
                    }
                } else {
                    $errors[] = "Action invalide.";
                }
            } else {
                $errors[] = "Projet introuvable.";
            }
        }

        foreach ($allProjects as &$project) {
            $projectModel = $projects->populate($project['id']);
            $userId = $project['user_id'];
            $statusId = $project['status_id'];
            $project['user_name'] ='';
            $project['status_name'] ='';
            if ($userId || $statusId) {
                $user = $userModel->populate($userId);
                $status = $statusModel->populate($statusId);
                if ($user) {
                    $project['user_name'] = $user->getUserName();
                }
                if ($status) {
                    $project['status_name'] = $status->getName();
                }
            }
            $project['seo_status'] = $projectModel->getSeoStatus();
        }

        $view = new View("Project/projects-list", "back");
        $view->assign("projects", $allProjects);
        $view->assign("errors", $errors);
        $view->assign("successes", $success);
        $view->render();
    }
<<<<<<< HEAD


    private function getSeoAdvices(array $seoAnalysis): array
    {
        $advices = [];

        if (!$seoAnalysis['external_links']) {
            $advices[] = "Il n’y a pas de lien externe dans cette page. Ajoutez-en !";
        }

        if (!$seoAnalysis['images']) {
            $advices[] = "Il n’y a pas d’image dans cette page. Ajoutez-en !";
        }

        if (!$seoAnalysis['internal_links']) {
            $advices[] = "Il n’y a aucun lien interne dans cette page, assurez-vous d’en ajouter !";
        }

        if (!$seoAnalysis['keyword_presence']) {
            $advices[] = "Aucune requête cible n’a été définie pour cette page. Renseignez une requête afin de calculer votre score SEO.";
        }

        if (!$seoAnalysis['meta_description_length']) {
            $advices[] = "Aucune méta description n’a été renseignée. Les moteurs de recherches afficheront du contenu de la page à la place. Assurez-vous d’en écrire une !";
        }

        if (!$seoAnalysis['content_length']) {
            $advices[] = "Le texte contient moins de 300 mots. Ajoutez plus de contenu.";
        }

        if (!$seoAnalysis['seo_title_length']) {
            $advices[] = "La longueur du titre SEO n'est pas optimale. Assurez-vous qu'il soit entre 50 et 60 caractères.";
        }
        return $advices;
=======
    
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
>>>>>>> dev
    }
    
}
?>