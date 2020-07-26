<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function profil()
    {  
        $user = $this->getUser();
        $recipes = [];
        foreach( $user->getFavorites() as $fav){
            array_push($recipes,$fav->getRecipe());
        }
        return $this->render('profil/profil.html.twig', [
            'recipes' => $recipes,
        ]);
    }
}
