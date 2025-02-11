<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RecipeControllerTest extends WebTestCase
{
    //     public function testNewRecipe()
    //     {
    //         // Crée le client
    //         $client = static::createClient();

    //         // Accède au conteneur de services
    //         $container = static::getContainer();

    //         // Récupère l'EntityManager
    //         $entityManager = $container->get('doctrine')->getManager();

    //         // Crée un utilisateur pour tester la connexion
    //         $user = new User();
    //         $user->setPseudo('TestUser');
    //         $email = 'testuser' . time() . '@example.com';
    //         $user->setEmail($email);
    //         $user->setPassword('password');
    //         $user->setRoles(['ROLE_USER']);

    //         // Persiste et flush l'utilisateur
    //         $entityManager->persist($user);
    //         $entityManager->flush();

    //         // Connecte l'utilisateur
    //         $client->loginUser($user);

    //         // Crée les ingrédients nécessaires
    //         $ingredientNames = ['Tomates', 'Basilic', 'Mozzarella'];
    //         $ingredients = [];
    //         foreach ($ingredientNames as $name) {
    //             $ingredient = new Ingredient();
    //             $ingredient->setName($name);
    //             $entityManager->persist($ingredient);
    //             $ingredients[] = $ingredient;
    //         }
    //         $entityManager->flush();

    //         // Récupère les IDs des ingrédients
    //         $ingredientIds = array_map(fn($ingredient) => $ingredient->getId(), $ingredients);

    //         // Accède à la page de création de recette
    //         $crawler = $client->request('GET', '/recipe/new');
    //         $this->assertResponseIsSuccessful();

    //         // Prépare le fichier image à télécharger
    //         $imagePath ='tests/controller/fixtures/test_image.jpg';
    //         $uploadedFile = new UploadedFile(
    //             $imagePath,
    //             'test_image.jpg',
    //             'image/jpeg',
    //             null,
    //             true
    //         );

    //         // Soumet le formulaire de création de recette
    //         $form = $crawler->selectButton('submit')->form([
    //             'recipe[name]' => 'Test Recipe',
    //             'recipe[slug]' => 'test-recipe',
    //             'recipe[description]' => 'Une super recette test',
    //             'recipe[ingredients]' => $ingredientIds,
    //             'recipe[imageFile]' => $uploadedFile,
    //         ]);

    //         // Soumet le formulaire
    //         $client->submit($form);

    //         // Vérifie que la page redirige après soumission
    //         $this->assertResponseRedirects('/recipe/index');
    //         $client->followRedirect();

    //         // Vérifie que la recette est visible sur la page de la liste des recettes
    //         $this->assertSelectorTextContains('h1', 'Test Recipe');
    //     }


    public function testHomePageResponse()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "La route '/' ne retourne pas une réponse 200.");
    }
}
