<?php
namespace App\Core;
use App\Core\View;
use App\Core\SQL;
use App\Models\Page;
use App\Controllers\Error;

class PageBuilder
{
    public function build($slug)
    {
        $db = new Page();
        $slugTrim = str_replace('/', '', $slug);
        $arraySlug = ["slug"=> $slugTrim];
        $page = $db->getOneBy($arraySlug);

        if (!empty($page)){
            $content = $page["content"];
            $title = $page["title"];
    
            $requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $routeFound = false;
            if ($slug === $requestUrl) {
                $routeFound = true;
            }
            if ($routeFound) {
                $view = new View("Main/page", "front");
                $view->assign("content", $content);
                $view->assign("title", $title);
                $view->render(); 
            }
        } else {
            header("Status 404 Not Found", true, 404);
            $error = new Error();
            $error->page404();
        }
    }

}
