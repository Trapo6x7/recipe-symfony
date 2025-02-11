<?php

namespace App\Tests\Controller;

use App\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IngredientControllerTest extends WebTestCase
{
    public function testInsertIngredients()
    {
        $client = static::createClient();
        $container = static::getContainer();
        $entityManager = $container->get('doctrine')->getManager();

        // Crée les ingrédients nécessaires
        $ingredientNames = ['Tomates', 'Basilic', 'Mozzarella'];
        foreach ($ingredientNames as $name) {
            $ingredient = new Ingredient();
            $ingredient->setName($name);
            $entityManager->persist($ingredient);
        }
        $entityManager->flush();

        // Vérifie que les ingrédients ont été insérés en base de données
        $ingredientRepository = $entityManager->getRepository(Ingredient::class);
        foreach ($ingredientNames as $name) {
            $ingredient = $ingredientRepository->findOneBy(['name' => $name]);
            $this->assertNotNull($ingredient, "L'ingrédient $name n'a pas été trouvé en base de données.");
        }
    }
}