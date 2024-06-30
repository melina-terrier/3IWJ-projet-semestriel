<?php
namespace App\Controllers;

use App\Core\SQL;
use App\Models\StatUser;
use App\Core\View;
use App\Models\User;
use App\Models\Page;
use App\Models\Media;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Setting;
use App\Models\Status;
use App\Models\Role;

class Main
{
    public function home() {
        $view = new View("Main/page", "front");
        $setting = new Setting();
        $settingId = $setting->getOneBy(['key' => 'homepage'], 'object');
        if ($settingId){
            $homepageId = $settingId->getValue();
            if($homepageId){
                $page = new Page();
                $homepage = $page->getOneBy(['id' => $homepageId]);
                if (!empty($homepage)) {
                    $title = $homepage["title"];
                    $content = $homepage["content"];
                } 
                $view->assign("content", $content);
                $view->assign("title", $title);
            }
        } else {
            $project = new Project();
            $statusModel = new Status();
            $userModel = new User();
            $status = $statusModel->getOneBy(["status" => "Publié"], 'object');
            $publishedStatusId = $status->getId();
            $projects = $project->getAllDataWithWhere(['status_id' => $publishedStatusId]);
            foreach ($projects as &$project) {
                $userId = $project['user_id'];
                $project['username'] ='';
                $project['userSlug'] ='';
                if ($userId) {
                    $user = $userModel->getOneBy(['id' => $userId], 'object');
                    if ($user) {
                        $project['username'] = $user->getUserName();
                        $project['userSlug'] = $user->getSlug();
                  }
                }
              }
            $view->assign("projects", $projects);
        }
        $view->render();
    }

    public function dashboard() {
        $users = new User();
        $page = new Page();
        $media = new Media();
        $projects = new Project();
        $comment = new Comment();
        $tag = new Tag();
        $statusModel = new Status();
        $roleModel = new Role();

        $status = $statusModel->getOneBy(["status" => "Publié"], 'object');
        $publishedStatusId = $status->getId();
        
        $userRole = $roleModel->getOneBy(["role" => "Utilisateur"], 'object');
        $userRoleId = $userRole->getId();
        $adminRole = $roleModel->getOneBy(["role" => "Administrateur"], 'object');
        $adminRoleId = $adminRole->getId();

        $comments = $comment->getAllData();

        $userByDay = $users->getAllDataGroupBy(["status"=>1, "id_role"=>$userRoleId], ['condition' => 'extract(day FROM creation_date) AS day, extract(month FROM creation_date) AS month, extract(year FROM creation_date) AS year, COUNT(*) AS user_count', 'name' => 'year, month, day'], 'array');
        $userByMonth = [];
        foreach ($userByDay as $dayData) {
            $year = $dayData['year'];
            $month = $dayData['month'];
            if (!isset($userByMonth[$year])) {
                $userByMonth[$year] = [];
            }
            if (!isset($userByMonth[$year][$month])) {
                $userByMonth[$year][$month] = [];
            }
            $userByMonth[$year][$month][$dayData['day']] = $dayData['user_count'];
        }

        $userMonth = $users->getAllDataGroupBy(["status"=>1, "id_role"=>$userRoleId], ['condition' => 'extract(month FROM creation_date) AS month, extract(year FROM creation_date) AS year, COUNT(*) AS user_count', 'name' => 'year, month'], 'array');
        $userByYear = [];
        foreach ($userMonth as $monthData) {
            $year = $monthData['year'];
            $month = $monthData['month'];
            if (!isset($userByMonth[$year])) {
                $userByYear[$year] = [];
            }
            $userByYear[$year][$month] = $monthData['user_count'];
        }

        $projectByDay = $projects->getAllDataGroupBy(["status_id"=>$publishedStatusId], ['condition' => 'extract(day FROM creation_date) AS day, extract(month FROM creation_date) AS month, extract(year FROM creation_date) AS year, COUNT(*) AS project_count', 'name' => 'year, month, day'], 'array');
        $projectByMonth = [];
        foreach ($projectByDay as $dayData) {
            $year = $dayData['year'];
            $month = $dayData['month'];
            if (!isset($projectByMonth[$year])) {
                $projectByMonth[$year] = [];
            }
            if (!isset($projectByMonth[$year][$month])) {
                $projectByMonth[$year][$month] = [];
            }
            $projectByMonth[$year][$month][$dayData['day']] = $dayData['project_count'];
        }

        $projectMonth = $projects->getAllDataGroupBy(["status_id"=>$publishedStatusId], ['condition' => 'extract(month FROM creation_date) AS month, extract(year FROM creation_date) AS year, COUNT(*) AS project_count', 'name' => 'year, month'], 'array');
        $projectByYear = [];
        foreach ($projectMonth as $monthData) {
            $year = $monthData['year'];
            $month = $monthData['month'];
            if (!isset($projectByYear[$year])) {
                $projectByYear[$year] = [];
            }
            $projectByYear[$year][$month] = $monthData['project_count'];
        }

        $admin = $users->getAllDataWithWhere(['id_role'=>$adminRoleId, "status"=>1], "object");
        $editors = $users->getAllDataWithWhere(['id_role'=>$userRoleId, "status"=>1], 'object');

        $userProjectCounts = []; 
        $AllUsers = $users->getAllDataWithWhere(['status'=>1], "object");
        foreach ($AllUsers as $user) {
          $userId = $user->getId();
          $userName = $user->getUserName();
          $userProjectCounts[$userName] = 0;
          $AllProjects=$projects->getAllDataWithWhere(["status_id"=>$publishedStatusId],"object");
          foreach ($AllProjects as $project) {
            $currentUserId = $project->getUser();
            if ($currentUserId === $userId) {
              $userProjectCounts[$userName]++; 
            }
          }
        }

        $elementsCount = [
            'users' => count($editors),
            'admin' => count($admin),
            'userByYear' => $userByYear,
            'userByMonth' => $userByMonth,
            'pages' => $page->getNbElements(),
            'medias' => $media->getNbElements(),
            'projects' => $projects->getNbElements(),
            'projectByMonth' => $projectByMonth,
            'projectByYear' => $projectByYear,
            'projectByUser' => $userProjectCounts,
            'comments' => $comment->getNbElements(),
            'tags'=>$tag->getNbElements(),
        ];

        $view = new View("Main/dashboard", "back");
        $view->assign("comments", $comments);
        $view->assign("elementsCount", $elementsCount);
        $view->render();
    }
}
?>