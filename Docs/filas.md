# Consumo de fila de notificação

Quando uma transação é realizada, uma mensagem contendo o id da transação é enfileirada para ser enviada a um sistema notificador terceirizado.

Para consumir essa fila execute o seguinte comando em um terminal:

```
$ php bin/console messenger:consume async -vv
```

Onde -vv exibe o log, caso não precise das informações, retire esse trecho do comando.

Para acessar o RabbitMQ a fim de visualizar a fila, digite no navegador: http://localhost:15672/#/queues

> Quando a mensagem é consumida, além de executar tarefas próprias da regra de negócio um log de informação é salvo. Se houver problema no consumo e a notificação não puder ser executada, a mensagem é reenfileirada e um log de erro é salvo. 

### [Voltar para página inicial](../README.md)