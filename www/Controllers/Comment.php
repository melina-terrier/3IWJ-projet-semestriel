<?php

namespace App\Controllers;
use App\Core\View;
use App\Models\Project;
use App\Models\Comment as CommentModel;

class Comment
{
    public function allComments(): void
    {
        $comment = new CommentModel();
        $comments = $comment->getAllData();
        $successes = [];
        $errors = [];
    
        if (isset($_GET['action']) && isset($_GET['id'])) {
            $currentComment = $comment->populate($_GET['id']);
            if ($currentComment) {
                if ($_GET['action'] === 'permanent-delete') {
                    $comment->delete(['id' => $_GET['id']]);
                    $successes[] = 'Commentaire définitivement supprimé.';
                } else {
                    $validActions = ['approuved', 'disapprouved', 'restore', 'delete'];
                    if (!in_array($_GET['action'], $validActions)) {
                        $errors[] = 'Action invalide.';
                    }
                    $newStatus = ($_GET['action'] === 'approuved') ? 1 : (($_GET['action'] === 'disapprouved') ? -1 : (($_GET['action'] === 'delete') ? -2 : 0));
                    $currentComment->setStatus($newStatus);
                    $currentComment->save();

                    $successMessages = [
                        'approuved' => 'Commentaire approuvé avec succès.',
                        'disapprouved' => 'Commentaire désapprouvé avec succès.',
                        'restore' => 'Commentaire restauré avec succès.',
                        'delete' => 'Commentaire supprimé avec succès.',
                    ];
                    $successes[] = $successMessages[$_GET['action']];
                }
            } else {
                $errors[] = 'Commentaire introuvable.';
            }
        }
    
        $projects = [];
        foreach ($comments as &$comment) {
            $projectId = $comment['project_id'];
            $projectModel = new Project();
            $project = $projectModel->populate($projectId);
            if ($project) {
                $comment['project'] = $project->getTitle();
            }
        }

        $view = new View('Comment/comments-list', 'back');
        $view->assign('comments', $comments);
        $view->assign('errors', $errors);
        $view->assign('successes', $successes);
        $view->render();
    }
}
