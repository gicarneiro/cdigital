DELETE FROM transacao;
DELETE FROM carteira_digital;
DELETE FROM pessoa_fisica;

-- carteira do Joao
INSERT INTO pessoa_fisica(id, nome, email, senha, cpf)
VALUES(1, 'João', 'joao@email.a', '1234', '13373486785');
INSERT INTO carteira_digital(id, proprietario_id, saldo, atualizado_em)
VALUES(1, 1, 200, now());


-- carteira da Maria
INSERT INTO pessoa_fisica (id, nome, email, senha, cpf)
VALUES(2, 'Maria', 'maria@email.a', '0987', '12345678901');
INSERT INTO carteira_digital(id, proprietario_id, saldo, atualizado_em)
VALUES(2, 2, 500, now());