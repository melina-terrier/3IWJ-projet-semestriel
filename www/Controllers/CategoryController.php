<?php

namespace App\Controller;

use App\Core\Form;
use App\Core\View;
use App\Models\Category;

class CategoryController
{
    public function category()
    {
        $form = new Form("Category");

        if ($form->isSubmitted() && $form->isValid()) {
            $category = new Category();
            $category->setTitle($_POST["title"]);
            $category->save();
        }

        $view = new View("Category/category");
        $view->assign("form", $form->build());
        $view->render();
    }
}