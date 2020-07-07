<?php

namespace App\Controller;
use App\Entity\Recipe;
use App\Entity\Category;
use App\Form\RecipeType;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
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
            'controller_name' => 'IndexController',
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

    /**
     * @Route("/recipe", name="recipe")
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
        $recipeList= $cat->getRecipes();
        return $this->render('miam/recipeList.html.twig', [
            'lists' => $recipeList,
            'cat' => $cat,
        ]);
    }

    /**
     * @Route("/recipeView/{id}", name="recipeView")
     */
    public function recipeView(Recipe $recipe)
    {
        $cat= $recipe->getCategory();
        return $this->render('miam/recipeView.html.twig', [
            'recipe'=>$recipe,
            'cat' => $cat
        ]);
    }

    /**
     * @Route("/addRecipe", name="addRecipe")
     */
    public function addRecipe(CategoryRepository $catRepo, Request $request, EntityManagerInterface $manager)
    {
        
        $cat=$catRepo->findAll();
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class,$recipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
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
            return $this->redirectToRoute('recipeView',['id' => $recipe->getId()]);
        }

        
        return $this->render('miam/addRecipe.html.twig',[
            'formRecipe' => $form->createView(),
            'cats'=>$cat,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('miam/contact.html.twig', [
            'controller_name' => 'ContactController',
            'title'=> 'Contacts',
        ]);
    }
}
    

 