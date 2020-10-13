# Regras de negócio

O sistema deve permitir transações financeiras entre pessoa física e pessoas jurídicas/físicas, sendo que o beneficiado recebe uma notificação ao receber a transferência. 

![Image do caso de uso](diagramas/diagramas_cdigital_uc.png)

Para isso foi proposta a seguinte estrutura macro de banco:

![Banco](diagramas/diagramas_cdigital-BD.png)


É importante citar que cnpj e cpf são únicos no sistema.

O banco foi implementado em postgres 11.5 e seu script consta na pasta migrations que é executada pelo Symfony.

A aplicação segue o seguinte conceito:

![Classes](diagramas/diagramas_cdigital-Classe.png)


Por fim segue o fluxo macro implementado:

![Workflow](diagramas/diagramas_cdigital-Workflow.png)

Note que as notificações são enfileiradas e serão executadas por um job a parte.

### [Voltar para página inicial](../README.md)