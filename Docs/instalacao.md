# Instalação

### Requisitos:

Serão necessários no ambiente:

* Docker
* Docker compose
* Symfony 5
* PHP-FPM 7.4
* NGINX
* Composer

> docker-compose providenciará as imagens do rabbitmq e postgres necessárias

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

3. Execute a migração do symfony
   
   ```
   $ php bin/console doctrine:migrations:migrate
   ```


> Pronto! O Projeto está pronto para ser executado!

### [Voltar para página inicial](../README.md)