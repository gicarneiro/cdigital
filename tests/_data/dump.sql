DELETE FROM transacao;
DELETE FROM carteira_digital;
DELETE FROM pessoas;

-- carteira do Joao
INSERT INTO pessoas(id, nome, email, senha, cpf, tipo)
VALUES(1, 'João', 'joao@email.a', '1234', '13373486785', 1);
INSERT INTO carteira_digital(id, proprietario_id, saldo, atualizado_em)
VALUES(1, 1, 200.00, now());


-- carteira da Maria
INSERT INTO pessoas (id, nome, email, senha, cpf, tipo)
VALUES(2, 'Maria', 'maria@email.a', '0987', '12345678901', 1);
INSERT INTO carteira_digital(id, proprietario_id, saldo, atualizado_em)
VALUES(2, 2, 500.00, now());

-- carteira do Supermecado Bom de Preço
INSERT INTO pessoas (id, nome, email, senha, cnpj, tipo)
VALUES(3, 'Supermecado Bom de Preço', 'superbomdepreco@email.a', '0987', '12345678912345', 2);
INSERT INTO carteira_digital(id, proprietario_id, saldo, atualizado_em)
VALUES(3, 3, 10000.00, now());