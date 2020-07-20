<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720095648 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE supplier_product_root (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, container_size VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier_product_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE supplier_product ADD root_id INT DEFAULT NULL, ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE supplier_product ADD CONSTRAINT FK_522F70B279066886 FOREIGN KEY (root_id) REFERENCES supplier_product_root (id)');
        $this->addSql('ALTER TABLE supplier_product ADD CONSTRAINT FK_522F70B2C54C8C93 FOREIGN KEY (type_id) REFERENCES supplier_product_type (id)');
        $this->addSql('CREATE INDEX IDX_522F70B279066886 ON supplier_product (root_id)');
        $this->addSql('CREATE INDEX IDX_522F70B2C54C8C93 ON supplier_product (type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE supplier_product DROP FOREIGN KEY FK_522F70B279066886');
        $this->addSql('ALTER TABLE supplier_product DROP FOREIGN KEY FK_522F70B2C54C8C93');
        $this->addSql('DROP TABLE supplier_product_root');
        $this->addSql('DROP TABLE supplier_product_type');
        $this->addSql('DROP INDEX IDX_522F70B279066886 ON supplier_product');
        $this->addSql('DROP INDEX IDX_522F70B2C54C8C93 ON supplier_product');
        $this->addSql('ALTER TABLE supplier_product DROP root_id, DROP type_id');
    }
}
