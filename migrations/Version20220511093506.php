<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511093506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_allergene (user_id INT NOT NULL, allergene_id INT NOT NULL, INDEX IDX_93C3A701A76ED395 (user_id), INDEX IDX_93C3A7014646AB2 (allergene_id), PRIMARY KEY(user_id, allergene_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_regime (user_id INT NOT NULL, regime_id INT NOT NULL, INDEX IDX_CFD45141A76ED395 (user_id), INDEX IDX_CFD4514135E7D534 (regime_id), PRIMARY KEY(user_id, regime_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_allergene ADD CONSTRAINT FK_93C3A701A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_allergene ADD CONSTRAINT FK_93C3A7014646AB2 FOREIGN KEY (allergene_id) REFERENCES allergene (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_regime ADD CONSTRAINT FK_CFD45141A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_regime ADD CONSTRAINT FK_CFD4514135E7D534 FOREIGN KEY (regime_id) REFERENCES regime (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_allergene DROP FOREIGN KEY FK_93C3A701A76ED395');
        $this->addSql('ALTER TABLE user_regime DROP FOREIGN KEY FK_CFD45141A76ED395');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_allergene');
        $this->addSql('DROP TABLE user_regime');
    }
}
