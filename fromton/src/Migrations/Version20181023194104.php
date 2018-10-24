<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181023194104 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE "cheese_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "category_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE country_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE location_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "cheese" (id INT NOT NULL, category_id INT DEFAULT NULL, location_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EDCE51C35E237E06 ON "cheese" (name)');
        $this->addSql('CREATE INDEX IDX_EDCE51C312469DE2 ON "cheese" (category_id)');
        $this->addSql('CREATE INDEX IDX_EDCE51C364D218E ON "cheese" (location_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, full_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(64) DEFAULT NULL, token VARCHAR(64) NOT NULL, roles JSON NOT NULL, validate BOOLEAN DEFAULT \'false\' NOT NULL, xp INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE users_cheeses (user_id INT NOT NULL, cheese_id INT NOT NULL, PRIMARY KEY(user_id, cheese_id))');
        $this->addSql('CREATE INDEX IDX_E98EE69AA76ED395 ON users_cheeses (user_id)');
        $this->addSql('CREATE INDEX IDX_E98EE69A2AD46E66 ON users_cheeses (cheese_id)');
        $this->addSql('CREATE TABLE "category" (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON "category" (name)');
        $this->addSql('CREATE TABLE country (id INT NOT NULL, name VARCHAR(255) NOT NULL, country_code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE location (id INT NOT NULL, country_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5E9E89CBF92F3E70 ON location (country_id)');
        $this->addSql('ALTER TABLE "cheese" ADD CONSTRAINT FK_EDCE51C312469DE2 FOREIGN KEY (category_id) REFERENCES "category" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "cheese" ADD CONSTRAINT FK_EDCE51C364D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_cheeses ADD CONSTRAINT FK_E98EE69AA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_cheeses ADD CONSTRAINT FK_E98EE69A2AD46E66 FOREIGN KEY (cheese_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users_cheeses DROP CONSTRAINT FK_E98EE69AA76ED395');
        $this->addSql('ALTER TABLE users_cheeses DROP CONSTRAINT FK_E98EE69A2AD46E66');
        $this->addSql('ALTER TABLE "cheese" DROP CONSTRAINT FK_EDCE51C312469DE2');
        $this->addSql('ALTER TABLE location DROP CONSTRAINT FK_5E9E89CBF92F3E70');
        $this->addSql('ALTER TABLE "cheese" DROP CONSTRAINT FK_EDCE51C364D218E');
        $this->addSql('DROP SEQUENCE "cheese_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "category_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE country_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE location_id_seq CASCADE');
        $this->addSql('DROP TABLE "cheese"');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE users_cheeses');
        $this->addSql('DROP TABLE "category"');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE location');
    }
}
