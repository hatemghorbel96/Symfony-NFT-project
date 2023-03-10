<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705210517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet CHANGE devis devis INT NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE price price INT DEFAULT NULL, CHANGE minbet minbet INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet CHANGE devis devis DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE price price DOUBLE PRECISION DEFAULT NULL, CHANGE minbet minbet DOUBLE PRECISION DEFAULT NULL');
    }
}
