<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221024135105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D9F1D6087');
        $this->addSql('DROP INDEX IDX_6D28840D9F1D6087 ON payment');
        $this->addSql('ALTER TABLE payment CHANGE products_id products_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D9F1D6087 FOREIGN KEY (products_id_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_6D28840D9F1D6087 ON payment (products_id_id)');
        $this->addSql('ALTER TABLE products CHANGE lildescription lildescription VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D9F1D6087');
        $this->addSql('DROP INDEX IDX_6D28840D9F1D6087 ON payment');
        $this->addSql('ALTER TABLE payment CHANGE products_id_id products_id INT NOT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D9F1D6087 FOREIGN KEY (products_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_6D28840D9F1D6087 ON payment (products_id)');
        $this->addSql('ALTER TABLE products CHANGE lildescription lildescription VARCHAR(255) DEFAULT NULL');
    }
}
