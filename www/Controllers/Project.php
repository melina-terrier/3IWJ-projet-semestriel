<?php
namespace App\Controllers;

use App\Core\Form;
use App\Core\View;
use App\Models\Project as ProjectModel;

class Project{

    public function addProject(): void
    {
        $form = new Form("AddProject");
        $errors = [];
        $success = [];

        $formattedDate = date('Y-m-d H:i:s');

        if( $form->isSubmitted() && $form->isValid() )
        {
            $project = new ProjectModel();
            $project->setTitle($_POST['title']);
            $project->setContent($_POST['content']);

            // $project->setSlug();
            // $project->setUserName();

            $project->setCreationDate($formattedDate);
            $project->setModificationDate($formattedDate);
            $project->setStatus('Publié');
            $project->save();
            $success[] = "Votre projet a été publié";
        }
        $view = new View("Project/add-project", "back");
        $view->assign("form", $form->build());
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