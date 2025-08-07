<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250805191216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id SERIAL NOT NULL, offer_id UUID DEFAULT NULL, interview_id INT DEFAULT NULL, assignment_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, content VARCHAR(2000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526C53C674EE ON comment (offer_id)');
        $this->addSql('CREATE INDEX IDX_9474526C55D69D95 ON comment (interview_id)');
        $this->addSql('CREATE INDEX IDX_9474526CD19302F8 ON comment (assignment_id)');
        $this->addSql('COMMENT ON COLUMN comment.offer_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN comment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C55D69D95 FOREIGN KEY (interview_id) REFERENCES interview (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD19302F8 FOREIGN KEY (assignment_id) REFERENCES assignment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assignment ADD name VARCHAR(255) DEFAULT NULL');
//        $this->addSql('ALTER TABLE offer ALTER state TYPE INT');
        $this->addSql('ALTER TABLE offer_response ADD original_content VARCHAR(10000) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C53C674EE');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C55D69D95');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CD19302F8');
        $this->addSql('DROP TABLE comment');
        $this->addSql('ALTER TABLE offer ALTER state TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE offer_response DROP original_content');
        $this->addSql('ALTER TABLE assignment DROP name');
    }
}
