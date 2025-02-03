<?php 

// src/Controller/ImageController.php
namespace App\Controller;

use App\Entity\Image;
use App\Entity\Recipe;
use App\Form\ImageType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/upload/{recipeId}", name="image_upload")
     */
    public function upload(Request $request, $recipeId, RecipeRepository $recipeRepository): Response
    {
        // Récupérer la recette par son ID
        $recipe = $recipeRepository->find($recipeId);

        // Vérifier si la recette existe
        if (!$recipe) {
            throw $this->createNotFoundException('La recette n\'a pas été trouvée.');
        }

        // Créer une nouvelle image et son formulaire
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image, [
            'recipe_id' => $recipeId, // Passer l'ID de la recette au formulaire
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le fichier
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                try {
                    // Déplacer le fichier dans le répertoire des uploads
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                    $image->setFileName($newFilename);
                } catch (FileException $e) {
                    // Gérer l'erreur d'upload ici si nécessaire
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'upload.');
                }

                // Lier l'image à la recette
                $image->setRecipe($recipe);

                // Sauvegarder l'image dans la base de données
                $this->entityManager->persist($image);
                $this->entityManager->flush();

                return $this->redirectToRoute('image_success'); // Rediriger après succès
            }
        }

        return $this->render('image/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
