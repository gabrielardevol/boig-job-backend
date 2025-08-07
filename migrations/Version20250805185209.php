<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250805185209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assignment (id SERIAL NOT NULL, offer_id UUID DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, message VARCHAR(2000) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_30C544BA53C674EE ON assignment (offer_id)');
        $this->addSql('COMMENT ON COLUMN assignment.offer_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN assignment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE assignment DROP CONSTRAINT FK_30C544BA53C674EE');
        $this->addSql('DROP TABLE assignment');
        $this->addSql('ALTER TABLE offer ALTER state TYPE VARCHAR(255)');
    }
}
