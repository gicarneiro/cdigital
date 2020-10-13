# Instalação

### Requisitos:

Serão necessários no seu ambiente:

* Docker
* Docker compose

> docker-compose providenciará as imagens do Composer, RabbitMQ, PostgreSQL, NGINX e PHP-FPM 7.4 necessárias

### Instalação passo a passo

1. Clone o projeto e acesse-o
   
   1. Acesse a pasta onde deseja clonar o projeto
   2. Execute o comando para clonar do git
    ```
    $ git clone git@github.com:gicarneiro/cdigital.git
    ```
   3. Acesse a pasta clonada

2. Inicie os containers
   
   ```
   $ docker-compose up -d
   ```

> Pronto! O Projeto já pode ser acessado em localhost! 



> Se quiser popular o banco de dados, execute os testes (ou rode no banco o script localizado em tests/_data/dump.sql).
> Leia na seção de API sobre as APIs REST implementadas


Obs: A migração do symfony é realizada automaticamente no container do php-fpm mas se necessário o comando é o seguinte
   ```
   $ php bin/console doctrine:migrations:migrate
   ```



### [Voltar para página inicial](../README.md)