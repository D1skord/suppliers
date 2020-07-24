<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200723143527 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE request_item DROP FOREIGN KEY FK_60BC02E4427EB8A5');
        $this->addSql('ALTER TABLE request_item ADD CONSTRAINT FK_60BC02E4427EB8A5 FOREIGN KEY (request_id) REFERENCES request (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE request_item DROP FOREIGN KEY FK_60BC02E4427EB8A5');
        $this->addSql('ALTER TABLE request_item ADD CONSTRAINT FK_60BC02E4427EB8A5 FOREIGN KEY (request_id) REFERENCES supplier (id)');
    }
}
