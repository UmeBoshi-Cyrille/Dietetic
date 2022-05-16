<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516172340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE allergene (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(75) NOT NULL, description LONGTEXT NOT NULL, published_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_published TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) NOT NULL, description LONGTEXT NOT NULL, published_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_published TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mark (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, recipe_id INT NOT NULL, mark INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6674F271A76ED395 (user_id), INDEX IDX_6674F27159D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, preparation_time INT NOT NULL, rest_time INT DEFAULT NULL, cooking_time INT DEFAULT NULL, step LONGTEXT NOT NULL, published_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_published TINYINT(1) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette_regime (recette_id INT NOT NULL, regime_id INT NOT NULL, INDEX IDX_B316888589312FE9 (recette_id), INDEX IDX_B316888535E7D534 (regime_id), PRIMARY KEY(recette_id, regime_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette_ingredient (recette_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_17C041A989312FE9 (recette_id), INDEX IDX_17C041A9933FE08C (ingredient_id), PRIMARY KEY(recette_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette_allergene (recette_id INT NOT NULL, allergene_id INT NOT NULL, INDEX IDX_20F5442B89312FE9 (recette_id), INDEX IDX_20F5442B4646AB2 (allergene_id), PRIMARY KEY(recette_id, allergene_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regime (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) NOT NULL, description LONGTEXT NOT NULL, published_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_published TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_allergene (user_id INT NOT NULL, allergene_id INT NOT NULL, INDEX IDX_93C3A701A76ED395 (user_id), INDEX IDX_93C3A7014646AB2 (allergene_id), PRIMARY KEY(user_id, allergene_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_regime (user_id INT NOT NULL, regime_id INT NOT NULL, INDEX IDX_CFD45141A76ED395 (user_id), INDEX IDX_CFD4514135E7D534 (regime_id), PRIMARY KEY(user_id, regime_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mark ADD CONSTRAINT FK_6674F271A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mark ADD CONSTRAINT FK_6674F27159D8A214 FOREIGN KEY (recipe_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE recette_regime ADD CONSTRAINT FK_B316888589312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_regime ADD CONSTRAINT FK_B316888535E7D534 FOREIGN KEY (regime_id) REFERENCES regime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_ingredient ADD CONSTRAINT FK_17C041A989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_ingredient ADD CONSTRAINT FK_17C041A9933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_allergene ADD CONSTRAINT FK_20F5442B89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_allergene ADD CONSTRAINT FK_20F5442B4646AB2 FOREIGN KEY (allergene_id) REFERENCES allergene (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_allergene ADD CONSTRAINT FK_93C3A701A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_allergene ADD CONSTRAINT FK_93C3A7014646AB2 FOREIGN KEY (allergene_id) REFERENCES allergene (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_regime ADD CONSTRAINT FK_CFD45141A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_regime ADD CONSTRAINT FK_CFD4514135E7D534 FOREIGN KEY (regime_id) REFERENCES regime (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette_allergene DROP FOREIGN KEY FK_20F5442B4646AB2');
        $this->addSql('ALTER TABLE user_allergene DROP FOREIGN KEY FK_93C3A7014646AB2');
        $this->addSql('ALTER TABLE recette_ingredient DROP FOREIGN KEY FK_17C041A9933FE08C');
        $this->addSql('ALTER TABLE mark DROP FOREIGN KEY FK_6674F27159D8A214');
        $this->addSql('ALTER TABLE recette_regime DROP FOREIGN KEY FK_B316888589312FE9');
        $this->addSql('ALTER TABLE recette_ingredient DROP FOREIGN KEY FK_17C041A989312FE9');
        $this->addSql('ALTER TABLE recette_allergene DROP FOREIGN KEY FK_20F5442B89312FE9');
        $this->addSql('ALTER TABLE recette_regime DROP FOREIGN KEY FK_B316888535E7D534');
        $this->addSql('ALTER TABLE user_regime DROP FOREIGN KEY FK_CFD4514135E7D534');
        $this->addSql('ALTER TABLE mark DROP FOREIGN KEY FK_6674F271A76ED395');
        $this->addSql('ALTER TABLE user_allergene DROP FOREIGN KEY FK_93C3A701A76ED395');
        $this->addSql('ALTER TABLE user_regime DROP FOREIGN KEY FK_CFD45141A76ED395');
        $this->addSql('DROP TABLE allergene');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE mark');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE recette_regime');
        $this->addSql('DROP TABLE recette_ingredient');
        $this->addSql('DROP TABLE recette_allergene');
        $this->addSql('DROP TABLE regime');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_allergene');
        $this->addSql('DROP TABLE user_regime');
    }
}
