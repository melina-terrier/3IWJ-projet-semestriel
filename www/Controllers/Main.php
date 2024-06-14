<?php
namespace App\Controllers;
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
    public function home()
    {
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
            $status = $statusModel->getOneBy(["status" => "published"], 'object');
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

    public function dashboard()
    {
        $user = new User();
        $page = new Page();
        $media = new Media();
        $project = new Project();
        $comment = new Comment();
        $tag = new Tag();

        $elementsCount = [
            'users' => $user->getNbElements(),
            'pages' => $page->getNbElements(),
            'medias' => $media->getNbElements(),
            'projects' => $project->getNbElements(),
            'comments' => $comment->getNbElements(),
            'tags'=>$tag->getNbElements(),
        ];

        $comments = $comment->getAllData();

        $view = new View("Main/dashboard", "back");
        $view->assign("elementsCount", $elementsCount);
        $view->assign("comments", $comments);
        $view->render();
    }

}