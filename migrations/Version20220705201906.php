<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705201906 extends AbstractMigration
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
        $this->addSql('ALTER TABLE bet CHANGE devis devis NUMERIC(10, 0) NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE price price NUMERIC(10, 0) DEFAULT NULL, CHANGE minbet minbet NUMERIC(10, 0) DEFAULT NULL');
    }
}
