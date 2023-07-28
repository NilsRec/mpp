<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230728135803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE note ADD nb_uninterested_beneficiaries INT NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE note ADD nb_helped_beneficiaries INT NOT NULL DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE note DROP nb_uninterested_beneficiaries');
        $this->addSql('ALTER TABLE note DROP nb_helped_beneficiaries');
    }
}
