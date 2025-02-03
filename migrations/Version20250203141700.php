<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203141700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient_recipe DROP FOREIGN KEY FK_36F2717659D8A214');
        $this->addSql('ALTER TABLE ingredient_recipe DROP FOREIGN KEY FK_36F27176933FE08C');
        $this->addSql('DROP TABLE ingredient_recipe');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredient_recipe (ingredient_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_36F27176933FE08C (ingredient_id), INDEX IDX_36F2717659D8A214 (recipe_id), PRIMARY KEY(ingredient_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ingredient_recipe ADD CONSTRAINT FK_36F2717659D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient_recipe ADD CONSTRAINT FK_36F27176933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
