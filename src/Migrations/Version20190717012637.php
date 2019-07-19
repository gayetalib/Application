<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190717012637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE approvisionnement (id INT AUTO_INCREMENT NOT NULL, fournisseurs_id INT NOT NULL, articles_id INT NOT NULL, numero_commande INT NOT NULL, date_entree DATE NOT NULL, quantite_approv INT NOT NULL, INDEX IDX_516C3FAA27ACDDFD (fournisseurs_id), INDEX IDX_516C3FAA1EBAF6CC (articles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, types_id INT NOT NULL, unites_id INT NOT NULL, nom_article VARCHAR(255) NOT NULL, designation VARCHAR(255) NOT NULL, alerte_stock INT NOT NULL, etat INT NOT NULL, situation VARCHAR(255) NOT NULL, quantite_stock INT NOT NULL, INDEX IDX_23A0E668EB23357 (types_id), INDEX IDX_23A0E66A6998D31 (unites_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consommation (id INT AUTO_INCREMENT NOT NULL, services_id INT NOT NULL, articles_id INT NOT NULL, date_consommation DATE NOT NULL, quantite_cons INT NOT NULL, INDEX IDX_F993F0A2AEF5A6C1 (services_id), INDEX IDX_F993F0A21EBAF6CC (articles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, directions_id INT DEFAULT NULL, nom_departement VARCHAR(255) NOT NULL, INDEX IDX_C1765B6389B5C81B (directions_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE direction (id INT AUTO_INCREMENT NOT NULL, nom_direction VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom_fournisseur VARCHAR(255) NOT NULL, numero_fournisseur INT NOT NULL, adresse_fournisseur VARCHAR(255) NOT NULL, mail_fournisseur VARCHAR(255) NOT NULL, boite_postale VARCHAR(255) NOT NULL, fax INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, nom_role VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles_user (roles_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_57048B3038C751C4 (roles_id), INDEX IDX_57048B30A76ED395 (user_id), PRIMARY KEY(roles_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, departements_id INT DEFAULT NULL, nom_service VARCHAR(255) NOT NULL, INDEX IDX_E19D9AD21DB279A6 (departements_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_article (id INT AUTO_INCREMENT NOT NULL, nom_type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unite_article (id INT AUTO_INCREMENT NOT NULL, nom_unite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, matricule VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE approvisionnement ADD CONSTRAINT FK_516C3FAA27ACDDFD FOREIGN KEY (fournisseurs_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE approvisionnement ADD CONSTRAINT FK_516C3FAA1EBAF6CC FOREIGN KEY (articles_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E668EB23357 FOREIGN KEY (types_id) REFERENCES type_article (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A6998D31 FOREIGN KEY (unites_id) REFERENCES unite_article (id)');
        $this->addSql('ALTER TABLE consommation ADD CONSTRAINT FK_F993F0A2AEF5A6C1 FOREIGN KEY (services_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE consommation ADD CONSTRAINT FK_F993F0A21EBAF6CC FOREIGN KEY (articles_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6389B5C81B FOREIGN KEY (directions_id) REFERENCES direction (id)');
        $this->addSql('ALTER TABLE roles_user ADD CONSTRAINT FK_57048B3038C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roles_user ADD CONSTRAINT FK_57048B30A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD21DB279A6 FOREIGN KEY (departements_id) REFERENCES departement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE approvisionnement DROP FOREIGN KEY FK_516C3FAA1EBAF6CC');
        $this->addSql('ALTER TABLE consommation DROP FOREIGN KEY FK_F993F0A21EBAF6CC');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD21DB279A6');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6389B5C81B');
        $this->addSql('ALTER TABLE approvisionnement DROP FOREIGN KEY FK_516C3FAA27ACDDFD');
        $this->addSql('ALTER TABLE roles_user DROP FOREIGN KEY FK_57048B3038C751C4');
        $this->addSql('ALTER TABLE consommation DROP FOREIGN KEY FK_F993F0A2AEF5A6C1');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E668EB23357');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A6998D31');
        $this->addSql('ALTER TABLE roles_user DROP FOREIGN KEY FK_57048B30A76ED395');
        $this->addSql('DROP TABLE approvisionnement');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE consommation');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE direction');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE roles_user');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE type_article');
        $this->addSql('DROP TABLE unite_article');
        $this->addSql('DROP TABLE user');
    }
}
