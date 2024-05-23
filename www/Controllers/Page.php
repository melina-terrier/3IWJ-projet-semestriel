<<<<<<< HEAD
<?php
namespace App\Controller;
use App\Core\Form;
use App\Core\Page as Auth;
use App\Core\View;
use App\Models\User;

class Page{



    public function page(): void
    {

        $form = new Form("Page");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $user->setTitle($_POST["title"]);
            $user->save();
        }

        $view = new View("Page/page");
        $view->assign("form", $form->build());
        $view->render();
    }

}



















=======
<?php
namespace App\Controller;
class Page
{

    
    public function show(): void
    {
        echo "Affichage d'une category";
    }
    public function edit(): void
    {
    
    }
    public function add(): void
    {

    }
    public function delete(): void
    {

    }
   

}
>>>>>>> bbdc864 (mise en place de la vérification du statut de l'user)
