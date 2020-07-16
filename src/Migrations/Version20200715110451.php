<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200715110451 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE supplier_staffer (id INT AUTO_INCREMENT NOT NULL, supplier_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, position VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_1FEE042E7927C74 (email), INDEX IDX_1FEE0422ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE supplier_staffer ADD CONSTRAINT FK_1FEE0422ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE supplier_staffer');
    }
}
