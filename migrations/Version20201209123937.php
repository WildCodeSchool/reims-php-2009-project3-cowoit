<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201209123937 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participation ADD passenger_id INT NOT NULL');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F4502E565 FOREIGN KEY (passenger_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AB55E24F4502E565 ON participation (passenger_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F4502E565');
        $this->addSql('DROP INDEX IDX_AB55E24F4502E565 ON participation');
        $this->addSql('ALTER TABLE participation DROP passenger_id');
    }
}
