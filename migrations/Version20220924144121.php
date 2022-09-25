<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220924144121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE special_event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE terrain_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE unit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE unit_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE special_event (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, modifier DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE terrain (id INT NOT NULL, name VARCHAR(255) NOT NULL, attacker_modifier DOUBLE PRECISION NOT NULL, defender_modifier DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE unit (id INT NOT NULL, unit_type_id INT NOT NULL, attack INT NOT NULL, defense INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DCBB0C5391058251 ON unit (unit_type_id)');
        $this->addSql('CREATE TABLE unit_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C5391058251 FOREIGN KEY (unit_type_id) REFERENCES unit_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE special_event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE terrain_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE unit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE unit_type_id_seq CASCADE');
        $this->addSql('ALTER TABLE unit DROP CONSTRAINT FK_DCBB0C5391058251');
        $this->addSql('DROP TABLE special_event');
        $this->addSql('DROP TABLE terrain');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE unit_type');
    }
}
