<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MiamController extends AbstractController
{


    /**
     * @Route("/", name="miam")
     */
    public function index(RecipeRepository $repo) 
    {   
        $recipe = $repo->findAllLimit();
        return $this->render('miam/index.html.twig', [
            'title'=> 'Miam !',
            'recipes' => $recipe,
        ]);
    }
    
    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('miam/about.html.twig', [
            'controller_name' => 'AboutController',
            'title'=> 'A propos',
        ]);
    }

   
    

}
    

 