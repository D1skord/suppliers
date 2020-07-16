<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200716205923 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE supplier_product (id INT AUTO_INCREMENT NOT NULL, supplier_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, height VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, count_min VARCHAR(255) DEFAULT NULL, count_max VARCHAR(255) DEFAULT NULL, diameter_barrel VARCHAR(255) DEFAULT NULL, diameter_crown VARCHAR(255) DEFAULT NULL, diameter_coma VARCHAR(255) DEFAULT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_522F70B22ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE supplier_product ADD CONSTRAINT FK_522F70B22ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE supplier CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE site site VARCHAR(255) DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE distance distance VARCHAR(255) DEFAULT NULL, CHANGE requisites requisites LONGTEXT DEFAULT NULL, CHANGE comment comment LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE supplier_staffer CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE position position VARCHAR(255) DEFAULT NULL, CHANGE comment comment LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE supplier_product');
        $this->addSql('ALTER TABLE supplier CHANGE phone phone VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE site site VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE address address VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE distance distance VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE requisites requisites LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE comment comment LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE supplier_staffer CHANGE phone phone VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE position position VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE comment comment LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
