<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\User;
use App\Form\EditRecipeType;
use App\Form\EditUserType;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{

    /**
     * User list
     * 
     * @Route("/", name="utilisateur")
     */
    public function index(UserRepository $users){
        return $this->render("admin/users.html.twig", [
            'users' => $users->findAll()
        ]);

    }

    /**
     * Edit user
     * 
     * @Route("/utilisateur/modifier/{id}", name="edit_user")
     */
    public function editUser(User $user, Request $request, UserRepository $repo){
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($repo->getCountAdmin()==1 && $repo->isAdmin($user)){
                $this->addFlash('error', 'Il doit avoir au minimum un administrateur');
            }
            else{
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Statut de l\'utilisateur modifié'
                );
                return $this->redirectToRoute("admin_utilisateur");
            }
        }

        return $this->render('admin/editUser.html.twig', [
            'editUserForm' => $form->createView()
        ]);

    }

    /**
     * Recipe
     * 
     * @Route("/recipeAdmin", name="recipeAdmin")
     */
    public function recipeAdmin(RecipeRepository $repo){
        return $this->render("admin/recipeAdmin.html.twig", [
            'recipes' => $repo->findAll()
        ]);

    }

    /**
     * Edit Recipe
     * 
     * @Route("/recipeAdmin/edit/{id}", name="edit_recipe")
     */
    public function editRecipe(Recipe $recipe, Request $request, RecipeRepository $repo){
        $form = $this->createForm(EditRecipeType::class, $recipe);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recipe);
            $entityManager->flush();
            $this->addFlash('message', 'Recette modifiée');
            return $this->redirectToRoute("admin_recipeAdmin");
        }

        return $this->render('admin/editRecipe.html.twig', [
            'editRecipeForm' => $form->createView()
        ]);

    }

   /**
    * @Route("/recipeAdmin/remove/{id}", name="remove_recipe")
    */
    public function remove(Recipe $recipe, EntityManagerInterface $entityManager){
   
    $entityManager->remove($recipe);
    $entityManager->flush();

    return $this->redirectToRoute('admin_recipeAdmin');
    }

    
}
