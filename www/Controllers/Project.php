<?php
namespace App\Controllers;

use App\Core\Form;
use App\Core\View;
use App\Core\SQL;
use App\Models\Media;
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
            $project->setContent($_POST['content']);
           
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

        $view = new View("Project/projects-list", "back");
        $view->assign("projects", $allProjects);
        $view->assign("errors", $errors);
        $view->assign("success", $success);
        $view->render();
    }

    public function editProjects(): void
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

    public function updateProject(): void
    {
        $userSerialized = $_SESSION['user'];
        $user = unserialize($userSerialized);
        $username = $user->getFirstname();

        $formattedDate = date('Y-m-d H:i:s');

        $title = $_POST['title'];
        $body = $_POST['content'];

        $project = new ProjectModel();
        $project->setTitle($title);
        $project->setBody($body);

        if($_GET['id']){
            $post = new ProjectModel();
            $selectedProject = $post->getProjects("project", $_GET['id']);

            $project->setId($_GET['id']);
            $project->setUpdatedAt($formattedDate);
            $project->setCreatedAt($selectedProject[0]["createdat"]);
            $project->setIsDeleted($selectedProject[0]["isdeleted"]);
            $project->setPublished($selectedProject[0]["published"]);
            $project->setSlug($selectedProject[0]["slug"]);
            $project->setType($selectedProject[0]["type"]);
            $project->setUserId($selectedProject[0]["user_firstname"]);
        }else{
            $project->setUpdatedAt($formattedDate);
            $project->setCreatedAt($formattedDate);

            $project->setIsDeleted(0);
            $project->setPublished(1);
            $project->setSlug("");
            $project->setType("project");
            $project->setUserId($username);
        }
        $project->saveInpost();
        header("Location: /dashboard/projects");
        exit();
    }
}

