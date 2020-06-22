# Faire

### Objetivo:
O Faire foi feito para estudo e para testar o Light Framework, um framework em PHP criado para o aprofundamento na linguagem.

### Requisitos: 
   1. PHP 7.x
   2. Composer

### Instalação:
   1. Faça um fork e clone este repositório.
   2. Abra o terminal no diretório e execute o comando:  ```composer install```.
   3. Copie o ".env.example" e cole como ".env" .
   4. No .env preencha com as variaveis de seu ambiente.
   5. Rode o comando ```vendor/bin/phinx migrate``` para rodar as migrations.
   3. Execute esse comando: ```php -S localhost:8000 -t public```. 

### Sobre: 
Um web-app para criar listas de tarefas de código aberto para ajudar aqueles que estão começando.

### Detalhes sobre o diretório: 
1. No diretório "routes" contém o arquivo para as rotas, lá você define todos endpoints da aplicação.
2. No diretório "database" contém as seeds e migrations feitos pelo phinx.php
3. No diretório "app" fica o coração da aplicação:
    1. Primeiramente temos a pasta "controller" onde contém os arquivos que controlarão as views e interagirão com os models.
    2. Depois temos o diretório "core" onde fica classes que servem de base para nossa aplicação, essas classes farão coisas como renderizar uma view, handling de exceptions, sistema de rotas, entre outras funções.
    3. O diretório "model" é onde fica os models do nosso projeto, classes para interação com o banco de dados.
    4. O diretório "template" fica os templates do projeto.
    5. No diretório "view" fica todos as views do nosso projeto, ou as páginas. (lembrando que usa o twig para renderização, ou seja você pode não precisa fazer uma página estática).
4. No diretório "lib" é onde ficam classes ou scripts que podem ser reaproveitados por outro projeto.
5. No diretório "public" é onde fica seu index.php o ponto inicial do sistema, os assets que seria a estilização e o .htaccess que tem algumas regras para url amigável e redirecionamento.
6. No diretório "vendor" estão as dependências do projeto.

### Features:
    
* ##### User
* ##### Todo-lists