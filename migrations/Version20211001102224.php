<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211001102224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audit_log ALTER params TYPE TEXT');
        $this->addSql('ALTER TABLE audit_log ALTER params DROP DEFAULT');
        $this->addSql('ALTER TABLE notification.notification ALTER message TYPE jsonb');
        $this->addSql('ALTER TABLE notification.notification ALTER message DROP DEFAULT');
        $this->addSql('ALTER TABLE notification.notification ALTER customer_info TYPE jsonb');
        $this->addSql('ALTER TABLE notification.notification ALTER customer_info DROP DEFAULT');
        $this->addSql('ALTER TABLE notification.notification ALTER delivery_info TYPE jsonb');
        $this->addSql('ALTER TABLE notification.notification ALTER delivery_info DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE audit_log ALTER params TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE audit_log ALTER params DROP DEFAULT');
        $this->addSql('ALTER TABLE notification.notification ALTER message TYPE JSONB');
        $this->addSql('ALTER TABLE notification.notification ALTER message DROP DEFAULT');
        $this->addSql('ALTER TABLE notification.notification ALTER customer_info TYPE JSONB');
        $this->addSql('ALTER TABLE notification.notification ALTER customer_info DROP DEFAULT');
        $this->addSql('ALTER TABLE notification.notification ALTER delivery_info TYPE JSONB');
        $this->addSql('ALTER TABLE notification.notification ALTER delivery_info DROP DEFAULT');
    }
}
