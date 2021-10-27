<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211027130800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE libelle (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, couleur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, tva_id INT NOT NULL, designation VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, prix NUMERIC(10, 2) NOT NULL, nom_image VARCHAR(255) DEFAULT NULL, INDEX IDX_29A5EC27BCF5E72D (categorie_id), INDEX IDX_29A5EC274D79775F (tva_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit_libelle (produit_id INT NOT NULL, libelle_id INT NOT NULL, INDEX IDX_622D8C20F347EFB (produit_id), INDEX IDX_622D8C2025DD318D (libelle_id), PRIMARY KEY(produit_id, libelle_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slide (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) DEFAULT NULL, texte LONGTEXT DEFAULT NULL, nom_image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tva (id INT AUTO_INCREMENT NOT NULL, taux_reduit DOUBLE PRECISION NOT NULL, taux_intermediaire DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC274D79775F FOREIGN KEY (tva_id) REFERENCES tva (id)');
        $this->addSql('ALTER TABLE produit_libelle ADD CONSTRAINT FK_622D8C20F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_libelle ADD CONSTRAINT FK_622D8C2025DD318D FOREIGN KEY (libelle_id) REFERENCES libelle (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCF5E72D');
        $this->addSql('ALTER TABLE produit_libelle DROP FOREIGN KEY FK_622D8C2025DD318D');
        $this->addSql('ALTER TABLE produit_libelle DROP FOREIGN KEY FK_622D8C20F347EFB');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC274D79775F');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE libelle');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE produit_libelle');
        $this->addSql('DROP TABLE slide');
        $this->addSql('DROP TABLE tva');
        $this->addSql('DROP TABLE user');
    }
}
