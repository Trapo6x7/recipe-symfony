<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Entity\User;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/')]
final class RecipeController extends AbstractController
{
    #[Route(name: 'app_recipe_index', methods: ['GET'])]
    public function index(RecipeRepository $recipeRepository): Response
    {
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipeRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('recipe/new', name: 'app_recipe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()) {
                $recipe->setUser($this->getUser());
            }
            // Vérifie si les ingrédients ont été correctement ajoutés
            // $ingredients = $recipe->getIngredients(); // Récupère la collection d'ingrédients

            // Si la collection d'ingrédients est vide ou contient des objets invalides, cela pourrait être la cause de l'erreur.
            // foreach ($ingredients as $ingredient) {
            //     if (!$ingredient instanceof Ingredient) {
            //         throw new \Exception("Un des ingrédients n'est pas valide");
            //     }
            // }

            $entityManager->persist($recipe);
            $entityManager->flush();

            return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recipe/new.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    #[Route('recipe/{id}', name: 'app_recipe_show', methods: ['GET'])]
    public function show(Recipe $recipe): Response
    {
        dd($recipe);
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('recipe/{id}/edit', name: 'app_recipe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recipe $recipe, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User || $recipe->getUser() !== $user) {
            return $this->redirectToRoute('app_recipe_index');
        }

        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les ingrédients ajoutés ou modifiés
            // $ingredients = $form->get('ingredients')->getData();
            // Associer les ingrédients à la recette
            // foreach ($ingredients as $ingredient) {
            //     $recipe->addIngredient($ingredient);
            // }

            // Sauvegarder la recette modifiée
            $entityManager->flush();

            return $this->redirectToRoute('app_recipe_index');
        }

        return $this->render('recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('recipe/{id}', name: 'app_recipe_delete', methods: ['POST'])]
    public function delete(Request $request, Recipe $recipe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $recipe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($recipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
    }
}
