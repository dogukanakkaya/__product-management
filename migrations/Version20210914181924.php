<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914181924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE currency (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(25) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE file (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, original_name VARCHAR(255) NOT NULL, unique_name VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size BIGINT NOT NULL, directory VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE option (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE option_value (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, option_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_249CE55CA7C41D6F ON option_value (option_id)');
        $this->addSql('DROP INDEX IDX_6BA7E35B2C2AC5D3');
        $this->addSql('DROP INDEX stock_translation_unique_translation');
        $this->addSql('CREATE TEMPORARY TABLE __temp__stock_translation AS SELECT id, translatable_id, name, locale FROM stock_translation');
        $this->addSql('DROP TABLE stock_translation');
        $this->addSql('CREATE TABLE stock_translation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, translatable_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, locale VARCHAR(5) NOT NULL COLLATE BINARY, CONSTRAINT FK_6BA7E35B2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES stock (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO stock_translation (id, translatable_id, name, locale) SELECT id, translatable_id, name, locale FROM __temp__stock_translation');
        $this->addSql('DROP TABLE __temp__stock_translation');
        $this->addSql('CREATE INDEX IDX_6BA7E35B2C2AC5D3 ON stock_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX stock_translation_unique_translation ON stock_translation (translatable_id, locale)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE option');
        $this->addSql('DROP TABLE option_value');
        $this->addSql('DROP INDEX IDX_6BA7E35B2C2AC5D3');
        $this->addSql('DROP INDEX stock_translation_unique_translation');
        $this->addSql('CREATE TEMPORARY TABLE __temp__stock_translation AS SELECT id, translatable_id, name, locale FROM stock_translation');
        $this->addSql('DROP TABLE stock_translation');
        $this->addSql('CREATE TABLE stock_translation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, translatable_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(5) NOT NULL)');
        $this->addSql('INSERT INTO stock_translation (id, translatable_id, name, locale) SELECT id, translatable_id, name, locale FROM __temp__stock_translation');
        $this->addSql('DROP TABLE __temp__stock_translation');
        $this->addSql('CREATE INDEX IDX_6BA7E35B2C2AC5D3 ON stock_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX stock_translation_unique_translation ON stock_translation (translatable_id, locale)');
    }
}
