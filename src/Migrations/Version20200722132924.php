<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200722132924 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE request_supplier_product');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE request_supplier_product (request_id INT NOT NULL, supplier_product_id INT NOT NULL, INDEX IDX_37ACF13F427EB8A5 (request_id), INDEX IDX_37ACF13F2475ABB3 (supplier_product_id), PRIMARY KEY(request_id, supplier_product_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE request_supplier_product ADD CONSTRAINT FK_37ACF13F2475ABB3 FOREIGN KEY (supplier_product_id) REFERENCES supplier_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE request_supplier_product ADD CONSTRAINT FK_37ACF13F427EB8A5 FOREIGN KEY (request_id) REFERENCES request (id) ON DELETE CASCADE');
    }
}
