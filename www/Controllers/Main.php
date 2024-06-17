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

class Main
{
    public function home() {
        $view = new View("Main/page", "front");
        $setting = new Setting();
        $settingId = $setting->getOneBy(['id' => 1], 'object');
        if ($settingId){
            $homepageId = $settingId->getHomepage();
            $page = new Page();
            $homepage = $page->getOneBy(['id' => $homepageId]);
            if (!empty($homepage)) {
                $title = $homepage["title"];
                $content = $homepage["content"];
            } 
            $view->assign("content", $content);
            $view->assign("title", $title);
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
        $user = new User();
        $page = new Page();
        $media = new Media();
        $projects = new Project();
        $comment = new Comment();
        $tag = new Tag();

        $comments = $comment->getAllData();

        $userByDay = $user->getAllDataGroupBy(['condition'=>'extract(day FROM creation_date) AS day', 'name'=>'day'], 'array');
        $userByMonth = $user->getAllDataGroupBy(['condition'=>'extract(month FROM creation_date) AS month', 'name'=>'month'], 'array');
        $userByYear = $user->getAllDataGroupBy(['condition'=>'extract(year FROM creation_date) AS year', 'name'=>'year'], 'array');

        $projectByDay = $projects->getAllDataGroupBy(['condition'=>'extract(day FROM creation_date) AS day', 'name'=>'day'], 'array');
        $projectByMonth = $projects->getAllDataGroupBy(['condition'=>'extract(month FROM creation_date) AS month', 'name'=>'month'], 'array');
        $projectByYear = $projects->getAllDataGroupBy(['condition'=>'extract(year FROM creation_date) AS year', 'name'=>'year'], 'array');

        foreach ($users as $user) {
            $userId = $user->getId();
            $projectCount = 0;
            foreach ($projects as $project) {
                $currentUserId = $project->getUser();
                if ($currentUserId === $userId) {
                    $projectCount++;
                }
            }
        }

        $admin = $user->getAllDataWithWhere(['id'=>1], "object");
        $users = $user->getAllDataWithWhere(['id'=>3], 'object');

        $elementsCount = [
            'users' => count($users),
            'admin' => count($admin),
            'userByYear' => count($userByYear),
            'userByMonth' => count($userByMonth),
            'userByDay' => count($userByDay),
            'pages' => $page->getNbElements(),
            'medias' => $media->getNbElements(),
            'projects' => $projects->getNbElements(),
            'projectByYear' => count($projectByYear),
            'projectByMonth' => count($projectByMonth),
            'projectByDay' => count($projectByDay),
            'projectByUser' => $projectCount,
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
