<?php
namespace App\Core;

class PageBuilder
{
    public function build($slug)
    {
        $db = new Post();
        $theme = new Theme();
        $slugTrim = str_replace('/', '', $slug);
        $arraySlug = ["slug"=> $slugTrim];
        $post = $db->getOneBy($arraySlug);
        $body = $post["body"];
        $title = $post["title"];
        $htmlFile = "Themes/{$slugTrim}";

        $requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $routeFound = false;
        if ($slug === $requestUrl) {
            $routeFound = true;
        }
        if ($routeFound) {
            $View = new View($htmlFile, "front");
            $View->assign("body", $body);
            $View->assign("title", $title);
        }
    }

}