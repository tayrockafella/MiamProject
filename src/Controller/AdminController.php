<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\User;
use App\Form\EditRecipeType;
use App\Form\EditUserType;
use App\Form\RecipeType;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
    public function index(UserRepository $users)
    {
        return $this->render("admin/users.html.twig", [
            'users' => $users->findAll()
        ]);
    }

    /**
     * Edit user
     * 
     * @Route("/utilisateur/modifier/{id}", name="edit_user")
     */
    public function editUser(User $user, Request $request, UserRepository $repo)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);
        $flashMessage ="";

        if ($form->isSubmitted() && $form->isValid()) {
            if ($repo->getCountAdmin() == 1 && $repo->isAdmin($user)) {
                $flashMessage ='Attention, il doit y avoir au minimum un utilisateur';
            } else {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                $flashMessage ='Utilisateur modifié';
        
            }
        }

        return $this->render('admin/editUser.html.twig', [
            'editUserForm' => $form->createView(),
            'flashMessage' => $flashMessage
        ]);
    }

    /**
     * Recipe
     * 
     * @Route("/recipeAdmin", name="recipeAdmin")
     */
    public function recipeAdmin(RecipeRepository $repo)
    {
        return $this->render("admin/recipeAdmin.html.twig", [
            'recipes' => $repo->findAll()
        ]);
    }

    /**
     * Edit Recipe
     * 
     * @Route("/recipeAdmin/edit/{id}", name="edit_recipe")
     */
    public function editRecipe(Recipe $recipe, Request $request, RecipeRepository $repo)
    {
        $form = $this->createForm(EditRecipeType::class, $recipe);
        $form->handleRequest($request);
        $flashMessage ="";
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recipe);
            $entityManager->flush();
            $flashMessage ='Recette modifiée';
           // return $this->redirectToRoute("admin_recipeAdmin");
        }

        return $this->render('admin/editRecipe.html.twig', [
            'editRecipeForm' => $form->createView(),
            'flashMessage' => $flashMessage
        ]);
    }

    /**
     * @Route("/recipeAdmin/remove/{id}", name="remove_recipe")
     */
    public function remove(Recipe $recipe, EntityManagerInterface $entityManager)
    {

        $entityManager->remove($recipe);
        $entityManager->flush();

        return $this->redirectToRoute('admin_recipeAdmin');
    }

     /**
     * 
     * @Route("/addRecipe", name="addRecipe")
     */
    public function addRecipe(CategoryRepository $catRepo, Request $request, EntityManagerInterface $manager)
    {
        $cat = $catRepo->findAll();

        $recipe = new Recipe();

        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $img = $form->get('image')->getData();
            if ($img) {

                $originalFilename = $img->getClientOriginalName();

                try {
                    $img->move(
                        $this->getParameter('img_directory'),
                        $originalFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $recipe->setImage($originalFilename);
            }
            $recipe->setDate(new \DateTime());
            $recipe->setCategory($catRepo->findOneBy(['name' => $request->request->get('category')]));
            $manager->persist($recipe);
            $manager->flush();
            return $this->redirectToRoute('recipeView', ['id' => $recipe->getId()]);
        }


        return $this->render('admin/addRecipe.html.twig', [
            'formRecipe' => $form->createView(),
            'cats' => $cat,
        ]);
    }
}
