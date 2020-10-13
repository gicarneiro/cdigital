# APIs

## 1. API para visualizar carteira digital:

GET localhost/{usuario}/carteiradigital


*Retornos*:

codigo | tipo | retorno
|------|------|------------
200 | OK | json com dados da carteira digital
404 | Falha | Mensagem informando que o dado ou parte dele não foi encontrado



## 2. API para fazer transferencia:


POST localhost/transaction

Corpo:
{
    value : 50.00
    payer : 2
    payee : 1
}

*Retornos*:


codigo | tipo | retorno
--------|-------|---------
200 | OK | json com dados da transação
404 | Falha | Mensagem informando que o dado ou parte dele não foi encontrado
403 | Falha | Mensagem informando que ação não é permitida
504 | Falha | Mensagem infornado que o serviço está indisponível (utilizado na parte de integração com os serviços de terceiros)


### [Voltar para página inicial](../README.md)