<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201009030205 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE carteira_digital_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE pessoa_fisica_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE transacao_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE carteira_digital (id INT NOT NULL, proprietario_id INT NOT NULL, saldo DOUBLE PRECISION NOT NULL, atualizado_em TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8E558DF56759BAE5 ON carteira_digital (proprietario_id)');
        $this->addSql('CREATE TABLE pessoa_fisica (id INT NOT NULL, nome VARCHAR(150) NOT NULL, email VARCHAR(100) NOT NULL, senha VARCHAR(255) NOT NULL, cpf VARCHAR(11) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE transacao (id INT NOT NULL, origem_id INT NOT NULL, destino_id INT NOT NULL, data TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, valor DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE carteira_digital ADD CONSTRAINT FK_8E558DF56759BAE5 FOREIGN KEY (proprietario_id) REFERENCES pessoa_fisica (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transacao ADD CONSTRAINT FK_6C9E60CE81E73123 FOREIGN KEY (origem_id) REFERENCES carteira_digital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transacao ADD CONSTRAINT FK_6C9E60CEE4360615 FOREIGN KEY (destino_id) REFERENCES carteira_digital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE transacao DROP CONSTRAINT FK_6C9E60CE81E73123');
        $this->addSql('ALTER TABLE transacao DROP CONSTRAINT FK_6C9E60CEE4360615');
        $this->addSql('ALTER TABLE carteira_digital DROP CONSTRAINT FK_8E558DF56759BAE5');
        $this->addSql('DROP SEQUENCE carteira_digital_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pessoa_fisica_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE transacao_id_seq CASCADE');
        $this->addSql('DROP TABLE carteira_digital');
        $this->addSql('DROP TABLE pessoa_fisica');
        $this->addSql('DROP TABLE transacao');
    }
}
