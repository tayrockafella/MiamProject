<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Favorites;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\EditCommentType;
use App\Form\RecipeType;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/recipe")
 */
class RecipeController extends AbstractController
{
    /**
     * @Route("/", name="recipe")
     */
    public function recipe(CategoryRepository $repo)
    {
        $cat = $repo->findAll();
        return $this->render('miam/recipe.html.twig', [
            'title' => 'Recettes',
            'cats' => $cat,
        ]);
    }

    /**
     * @Route("/recipeList/{id}", name="recipeList")
     */
    public function recipeList(Category $cat)
    {
        $recipeList = $cat->getRecipes();
        return $this->render('miam/recipeList.html.twig', [
            'lists' => $recipeList,
            'cat' => $cat,
        ]);
    }

    /**
     * @Route("/recipeView/{id}", name="recipeView")
     */
    public function recipeView(Recipe $recipe, Request $request, EntityManagerInterface $manager)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $cat = $recipe->getCategory();
        $user = $this->getUser();
        $isFav = false;
        if ($user != null) {
            $favorites = $user->getFavorites();

            foreach ($favorites as $fav) {
                if ($fav->getRecipe()->getId() == $recipe->getId()) {
                    $isFav = true;
                }
            }
        }


        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setUser($user);
            $comment->setDate(new \DateTime());
            $comment->setRecipes($recipe);
            $manager->persist($comment);
            $manager->flush();
        }

        return $this->render('miam/recipeView.html.twig', [
            'recipe' => $recipe,
            'cat' => $cat,
            'form' => $form->createView(),
            'isFav' => $isFav,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
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


        return $this->render('miam/addRecipe.html.twig', [
            'formRecipe' => $form->createView(),
            'cats' => $cat,
        ]);
    }

    /**
     * @Route("/recipeVote/{id}/vote/{direction}")
     */
    public function recipeVote(Recipe $recipe, $direction, EntityManagerInterface $em)
    {
        $currentVote = $recipe->getVote();
        if ($direction == "up") {
            $currentVote++;
        } else {
            $currentVote--;
        }

        $recipe->setVote($currentVote);
        $em->persist($recipe);
        $em->flush();

        return $this->json(['vote' => $currentVote]);
    }

    /**
     * @Route("/recipeFav/{id}")
     */
    public function recipeFav(Recipe $recipe, EntityManagerInterface $em)
    {
        $user = $this->getUser();  // récupère les infos de User
        $favorites = $user->getFavorites();
        foreach ($favorites as $fav) {
            if ($recipe->getId() == $fav->getRecipeId()->getId()) {

                $em->remove($fav);
                $em->flush();
                return $this->json(["fav" => "TRUE"]);
            }
        }
        $favorite = new Favorites();
        $favorite->setUser($user); // insère id de l'user préalablement récupéré
        $favorite->setRecipe($recipe); // insère id de la recette préalablement récupéré
        $em->persist($favorite);
        $em->flush();
        return $this->json(["fav" => "FALSE"]);
    }

    /**
     * @Route("/comment/remove/{id}", name="remove_comment")
     */
    public function remove(Comment $comment, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($comment);
        $entityManager->flush();
        return $this->json(['rep' => true]);
    }
}
