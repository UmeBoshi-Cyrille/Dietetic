<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220510204518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recette_regime (recette_id INT NOT NULL, regime_id INT NOT NULL, INDEX IDX_B316888589312FE9 (recette_id), INDEX IDX_B316888535E7D534 (regime_id), PRIMARY KEY(recette_id, regime_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette_ingredient (recette_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_17C041A989312FE9 (recette_id), INDEX IDX_17C041A9933FE08C (ingredient_id), PRIMARY KEY(recette_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette_allergene (recette_id INT NOT NULL, allergene_id INT NOT NULL, INDEX IDX_20F5442B89312FE9 (recette_id), INDEX IDX_20F5442B4646AB2 (allergene_id), PRIMARY KEY(recette_id, allergene_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recette_regime ADD CONSTRAINT FK_B316888589312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_regime ADD CONSTRAINT FK_B316888535E7D534 FOREIGN KEY (regime_id) REFERENCES regime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_ingredient ADD CONSTRAINT FK_17C041A989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_ingredient ADD CONSTRAINT FK_17C041A9933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_allergene ADD CONSTRAINT FK_20F5442B89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_allergene ADD CONSTRAINT FK_20F5442B4646AB2 FOREIGN KEY (allergene_id) REFERENCES allergene (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE allergene CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE recette CHANGE preparation_time preparation_time INT NOT NULL, CHANGE rest_time rest_time INT DEFAULT NULL, CHANGE cooking_time cooking_time INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE recette_regime');
        $this->addSql('DROP TABLE recette_ingredient');
        $this->addSql('DROP TABLE recette_allergene');
        $this->addSql('ALTER TABLE allergene CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE recette CHANGE preparation_time preparation_time VARCHAR(75) NOT NULL, CHANGE rest_time rest_time VARCHAR(75) DEFAULT NULL, CHANGE cooking_time cooking_time VARCHAR(75) DEFAULT NULL');
    }
}
