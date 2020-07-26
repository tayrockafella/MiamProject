<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request, RecipeRepository $repo)
    {

        $title = $request->request->get("search");
        $recipes = $repo->search($title);

        if ($recipes == null) {
            $this->addFlash('erreur', 'Oups! nous sommes désolés, aucune recette n\'a été trouvée à ce nom: ' . $title);
        }

        return $this->render('search/search.html.twig', [
            'recipes' => $recipes,
        ]);
    }
}
