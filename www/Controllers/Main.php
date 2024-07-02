<?php
namespace App\Controllers;
use App\Core\View;
use App\Models\User;
use App\Models\Page;
use App\Models\Media;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Project_Tags;
use App\Models\Setting;
use App\Models\Status;
use App\Models\Role;

class Main
{
    public function home() {
        $view = new View('Main/page', 'front');
        $setting = new Setting();
        $settingId = $setting->getOneBy(['key' => 'homepage'], 'object');
        if ($settingId){
            $homepageId = $settingId->getValue();
            if($homepageId){
                $page = new Page();
                $homepage = $page->populate($homepageId);
                if (!empty($homepage)) {
                    $title = $homepage->getTitle();
                    $content = $homepage->getContent();
                } 
                $view->assign('content', $content);
                $view->assign('pageTitle', $title);
            }
        } else {
            $project = new Project();
            $statusModel = new Status();
            $userModel = new User();
            $status = $statusModel->getByName('Publié');
            $projects = $project->getAllData(['status_id' => $status]);
            foreach ($projects as &$project) {
                $userId = $project['user_id'];
                $project['username'] ='';
                $project['userSlug'] ='';
                if ($userId) {
                    $user = $userModel->populate($userId);
                    if ($user) {
                        $project['username'] = $user->getUserName();
                        $project['userSlug'] = $user->getSlug();
                        $project['userPhoto'] = $user->getPhoto();

                        if($project['userPhoto']){
                            $medias = $mediaModel->getOneBy(['url'=>$project['userPhoto']]);
                            if($medias){
                                $project['userPhotoDescription'] = $medias['description'];
                            }
                        }
                    }
                }
                if ($mediaSlug){
                    $media = $mediaModel->getOneBy(['url'=>$mediaSlug], 'object');
                    if ($media) {
                        $project['image_description'] = $media->getDescription();
                    }
                }
              }
            $view->assign('projects', $projects);
        // }
        $view->render();
    }
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
        

        $status = $statusModel->getByName('Publié');        
        $userRole = $roleModel->getByName('Utilisateur');
        $adminRole = $roleModel->getByName('Administrateur');
        $comments = $comment->getAllData();

        $userByDay = $users->getAllData(['status'=>1, 'id_role'=>$userRole], ['condition' => 'extract(day FROM creation_date) AS day, extract(month FROM creation_date) AS month, extract(year FROM creation_date) AS year, COUNT(*) AS user_count', 'name' => 'year, month, day'], 'array');
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

        $userMonth = $users->getAllData(['status'=>1, 'id_role'=>$userRole], ['condition' => 'extract(month FROM creation_date) AS month, extract(year FROM creation_date) AS year, COUNT(*) AS user_count', 'name' => 'year, month'], 'array');
        $userByYear = [];
        foreach ($userMonth as $monthData) {
            $year = $monthData['year'];
            $month = $monthData['month'];
            if (!isset($userByMonth[$year])) {
                $userByYear[$year] = [];
            }
            $userByYear[$year][$month] = $monthData['user_count'];
        }

        $projectByDay = $projects->getAllData(['status_id'=>$status], ['condition' => 'extract(day FROM creation_date) AS day, extract(month FROM creation_date) AS month, extract(year FROM creation_date) AS year, COUNT(*) AS project_count', 'name' => 'year, month, day'], 'array');
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

        $projectMonth = $projects->getAllData(['status_id'=>$status], ['condition' => 'extract(month FROM creation_date) AS month, extract(year FROM creation_date) AS year, COUNT(*) AS project_count', 'name' => 'year, month'], 'array');
        $projectByYear = [];
        foreach ($projectMonth as $monthData) {
            $year = $monthData['year'];
            $month = $monthData['month'];
            if (!isset($projectByYear[$year])) {
                $projectByYear[$year] = [];
            }
            $projectByYear[$year][$month] = $monthData['project_count'];
        }

        $admin = $users->getAllData(['id_role'=>$adminRole, 'status'=>1], null,  'object');
        $editors = $users->getAllData(['id_role'=>$userRole, 'status'=>1], null, 'object');

        $userProjectCounts = []; 
        $AllUsers = $users->getAllData(['status'=>1], null, 'object');
        foreach ($AllUsers as $user) {
          $userId = $user->getId();
          $userName = $user->getUserName();
          $userProjectCounts[$userName] = 0;
          $AllProjects=$projects->getAllData(['status_id'=>$status], null, 'object');
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

        $labels = array_keys($userProjectCounts);
        $data = array_values($userProjectCounts);
      
        $view = new View('Main/dashboard', 'back');
        $view->assign('comments', $comments);
        $view->assign('elementsCount', $elementsCount);

        $view->assign("labels", $labels);
        $view->assign("data", $data);
        
        $view->render();
    }

    public function displayResult()
    {
        $searchTerm = '%'.$_POST['search-term'].'%';
        $page = new Page();
        $errors = [];
        $project = new Project();
        if ($searchTerm){

            $pages = $page->search(['title'=>$searchTerm, 'content'=>$searchTerm]);
            $projects = $project->search(['title'=>$searchTerm, 'content'=>$searchTerm]);
            foreach ($projects as &$project){
                $project['allTags'] = [];
                $tag = new Project_Tags();
                $tagsModel = new Tag();
                $tags = $tag->getAllData(['project_id'=>$project['id']]);
                if ($tags){
                    foreach($tags as $tag){
                        $tagName = $tagsModel->populare($tag['tag_id']);
                        if ($tagName){
                            $project['allTags'][] = [
                                'tag_id' => $tagName->getId(),
                                'name' => $tagName->getName(),
                            ];
                        }
                    }
                }
            }
            $user = new User();
            $users = $user->search(['slug'=>$searchTerm, 'occupation'=>$searchTerm]);
            $view = new View('Main/search', 'front');
        } else {
            $errors = 'veuillez faire une recherche';
        }
        $view->assign('users', $users);
        $view->assign('projects', $projects);
        $view->assign('pages', $pages);
        $view->assign('errors', $errors);
        $view->render();
    }
}

?>