<?php
namespace App\Controller;

use App\Core\Form;
use App\Core\View;
use App\Models\Project;

class ProjectController {
    public function project() {
        $form = new Form("Project"); 
        
        if ($form->isSubmitted() && $form->isValid()) {
            $project = new Project();
            $dateToCreate = new \DateTime();
            $project->setDate_to_create($dateToCreate);
            $project->setTitle($_POST["title"]);
            $project->setContent($_POST["content"]);
            
            // Sauvegarde du projet
            $project->save();
        }

        $view = new View("Project/project");
        $view->assign("form", $form->build());
        $view->render();
    }
}
