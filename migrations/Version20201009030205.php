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
        /* pessoas */
        $this->addSql('CREATE SEQUENCE pessoas_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pessoas (id INT NOT NULL, nome VARCHAR(150) NOT NULL, email VARCHAR(100) NOT NULL, senha VARCHAR(255) NOT NULL, cpf VARCHAR(11), cnpj VARCHAR(14), tipo INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_PESSOAS_CNPJ ON pessoas (cnpj)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_PESSOAS_CPF ON pessoas (cpf)');

        /* carteiras_digitais */
        $this->addSql('CREATE SEQUENCE carteiras_digitais_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE carteiras_digitais (id INT NOT NULL, proprietario_id INT NOT NULL, saldo NUMERIC(15,2) NOT NULL, atualizado_em TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CARTEIRAS_DIGITAIS_PROPRIETARIO ON carteiras_digitais (proprietario_id)');
        $this->addSql('ALTER TABLE carteiras_digitais ADD CONSTRAINT FK_CARTEIRAS_DIGITAIS_PROPRIETARIO FOREIGN KEY (proprietario_id) REFERENCES pessoas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        /* transacoes */
        $this->addSql('CREATE SEQUENCE transacoes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE transacoes (id INT NOT NULL, origem_id INT NOT NULL, destino_id INT NOT NULL, data TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, valor NUMERIC(15,2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE transacoes ADD CONSTRAINT FK_TRANSACOES_ORIGEM FOREIGN KEY (origem_id) REFERENCES carteiras_digitais (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transacoes ADD CONSTRAINT FK_TRANSACOES_DESTINO FOREIGN KEY (destino_id) REFERENCES carteiras_digitais (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transacoes DROP CONSTRAINT FK_TRANSACOES_ORIGEM');
        $this->addSql('ALTER TABLE transacoes DROP CONSTRAINT FK_TRANSACOES_DESTINO');
        $this->addSql('ALTER TABLE carteiras_digitais DROP CONSTRAINT FK_CARTEIRAS_DIGITAIS_PROPRIETARIO');
        $this->addSql('DROP SEQUENCE carteiras_digitais_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pessoas_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE transacoes_id_seq CASCADE');
        $this->addSql('DROP TABLE carteiras_digitais');
        $this->addSql('DROP TABLE pessoas');
        $this->addSql('DROP TABLE transacoes');
    }
}
