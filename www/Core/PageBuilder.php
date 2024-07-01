<?php
namespace App\Core;
use App\Models\User;
use App\Models\Page;
use App\Models\Project;
use App\Models\Status;
use App\Controllers\Error;
use App\Models\Tag;
use App\Models\Project_Tags;
use App\Models\Comment;
use App\Models\Media;

class PageBuilder 
{
    public function __construct()
    {
        $this->userModel = new User();
        $this->pageModel = new Page();
        $this->projectModel = new Project();
        $this->statusModel = new Status();
        $this->tagModel = new Tag();
        $this->commentModel = new Comment();
    }

    public function show(string $slug): void
    {
        $slugParts = explode('/', $slug);
        $slug = end($slugParts);
        $slugTrim = str_replace('/', '', $slug);
        $requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $publishedStatusId = $this->statusModel->getByName('Publié');

        $user = $this->userModel->getOneBy(['slug' => $slugTrim]);
        if ($user && '/profiles/' . $slug === $requestUrl) {
            $this->handleUserProfile($user);
            return;
        } else if ($requestUrl === '/profiles' || $requestUrl === '/profiles//') {
            $users = $this->userModel->getAllData(['status' => 1]);
            $this->handleUsers($users);
            return;
        }

        $project = $this->projectModel->getOneBy(['slug' => $slugTrim]);
        $tag = $this->tagModel->getOneBy(['slug' => $slugTrim]);

        if ($project) {
            if (($project['status_id'] === $publishedStatusId || (isset($_GET['preview']) && $_GET['preview'] == true))) {
                $this->handleProject($project);
                return;
            }
        } elseif ($tag) {
            // $projectTag = new Project_Tags();
            // $projects = $projectTag->getAllData(['tag_id' => $tag['id']]);
            // $projectArray = [];
            // foreach ($projects as $projectId){
            //     $projectId = $projects->getOneBy()
            // }
            // $this->handleProjectList($projects, $tag['name'], $tag['description']);
            return;
        } else if ($requestUrl === '/projects' || $requestUrl === '/projects//') {
            $projects = $this->userModel->getAllData(['status_id' => $publishedStatusId]);
            $this->handleProjects($projects);
            return;
        }

        $page = $this->pageModel->getOneBy(['slug' => $slugTrim]);
        if ($page && ($page['status_id'] === $publishedStatusId || (isset($_GET['preview']) && $_GET['preview'] == true))) {
            $this->handlePage($page);
            return;
        }

        header('Status 404 Not Found', true, 404);
        $error = new Error();
        $error->page404();
    }

    private function handleUsers(array $users): void
    {
        $view = new View('Main/users', 'front');
        $media = new Media();
        foreach ($users as &$user){
            $user['photoDescription'] ='';
            $medias = $media->getOneBy(['url'=>$user['photo']]);
            if($medias){
                $user['photoDescription'] = $medias['description'];
            }
        }
        $view->assign('users', $users);
        $view->render();
    }

    private function handleUserProfile(array $user): void
    {
        $mediaModel = new Media();
        $media = $mediaModel->getOneBy(['url' => $user['photo']]);
        $project = new Project();
        $projects = $project->getAllData(['user_id'=>$user['id']]);
        $view = new View('Main/user', 'front');
        $view->assign('user', $user);
        $view->assign('media', $media);
        $view->assign('projects', $project);
        $view->render();
    }

    private function handleProject(array $project): void
    {
        $content = $project['content'];
        $title = $project['title'];
        $form = new Form("AddComment");
        $user = new User();
        $tagProjects = new Project_Tags();
        $tag = $this->tagModel;
        $errors = [];
        $success = [];
        $tagName = [];
        $featured_image = $project['featured_image'];
        $tags = $tagProjects->getAllData(['project_id' => $project['id']], null, 'object');
        if (!empty($tags)) {
            foreach($tags as $uniqueTag){
                $tagId = $uniqueTag->getTagId();
                $tagsId = $tag->populate($tagId);
                $tagNames[] = $tagsId->getName();
            }
        }
        if ($form->isSubmitted() && $form->isValid()) {
             $this->commentModel->setComment($_POST['comment']);
             $this->commentModel->setProject($project['id']);
             $this->commentModel->setStatus(0);

            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                $actualUser = $user->populate($_SESSION['user_id']);
                $userEmail = $actualUser->getEmail();
                $userName = $actualUser->getUserName();
                $this->commentModel->setUserId($userId);
                $this->commentModel->setMail($userEmail);
                $this->commentModel->setName($userName);
                $this->commentModel->save();
                $success[] = "Votre commentaire a été publié";
            } else {
                $user = new User();
                if ($user->isUnique(['email'=>$_POST["email"]])) {
                    $errors[] = "L'email correspond à un compte, merci de bien vouloir vous connecter";
                } else {
                    $this->commentModel->setMail($_POST['email']);
                    $this->commentModel->setName($_POST['name']);
                    $this->commentModel->save();
                    $success[] = "Votre commentaire a été publié, il sera publié une fois vérifié";
                }
            }
        }
        $comments = $this->commentModel->getAllData(['status' => 1, 'project_id' => $project['id']]);
        $view = new View("Main/project", "front");
        $view->assign('projectContent', $content);
        $view->assign('tagName', $tagNames);
        $view->assign('featured_image', $featured_image);
        $view->assign('projectTitle', $title);
        $view->assign('form', $form->build());
        $view->assign('errors', $errors);
        $view->assign('successes', $success);
        $view->assign('comments', $comments);
        $view->render();
    }

    private function handleProjectList(array $projects, string $title, string $description): void
    {
        foreach ($projects as &$project) {
            $userId = $project['user_id'];
            $project['username'] = '';
            $project['userSlug'] = '';
            $project['profile_photo'] = '';
            if ($userId) {
                $user = $this->userModel->getOneBy(['id' => $userId], 'object');
                if ($user) {
                    $project['username'] = $user->getUserName();
                    $project['userSlug'] = $user->getSlug();
                    $project['profile_photo'] = $user->getPhoto();
                }
            }
        }
    
        $view = new View("Main/all-projects", "front");
        $view->assign("title", $title);
        $view->assign("description", $description);
        $view->assign("projects", $projects);
        $view->render();
    }

    private function handleProjects(array $projects): void
    {
        $userModel = new User();
        foreach ($projects as &$project) {
            $projectTagsId = $projectTags->getAllData(['project_id'=>$project['id']]);
            $userId = $project['user_id'];
            $project['category_name'] ='';
            $project['username'] ='';
            $project['userSlug'] ='';
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
                foreach ($projectTagsId as $projectTagId){
                    $tagId = $tags->getOneBy(['id' => $projectTagId['tag_id']]);
                    if ($tagId) {
                        $project['category_name'] .= $tagId['name'];
                    }
                }
            }
        }

        $view = new View("Main/all-projects", "front");
        $view->assign("projects", $projects);
        $view->render();
    }
    
    private function handlePage(array $page): void
    {
        $content = $page['content'];
        $pageTitle = $page['title'];

        $view = new View("Main/page", "front");
        $view->assign("content", $content);
        $view->assign("pageTitle", $pageTitle);
        $view->render();
    }
}