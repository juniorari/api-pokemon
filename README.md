<h1>API Pokemon on Yii 2 </h1>

Este projeto é baseado no Framework Yii2 com a estrutura básica

O modelo contém estrutura de uma API Pokémon, podendo criar 01 time com até seis pokémons.

A Página Inicial consiste na visualização de randômica de alguns pokémons, exibindo seus nomes e seu respectivo XP.

Na página `Pokémons` é exibindo uma tela com a exibição dos pokemons em uma tabela com paniação, podendo
realizar busca pelo nome e/ou tipo.
Já na página `Criar Time`, é possível criar times com até 06 pokémons. Todas as ações nesta página são 
feitas via AJAX, chamando as APIs.


ESTRUTURA DOS DIRETÓRIOS
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources




TECNOLOGIAS UTILIZADAS:
-----------

- [Yii2 Framework](https://www.yiiframework.com/download)
- [Docker](http://docker.com)
- [jQuery](https://code.jquery.com/)
- [Bootstrap](https://getbootstrap.com/)
- [MySQL](https://www.mysql.com/downloads/)  
- [Krakee Dialog](https://demos.krajee.com/dialog/)  

<!--
- [NPM JS](https://www.npmjs.com/)
- [Composer](https://getcomposer.org/)
- [Grunt](https://gruntjs.com/)
- [Krakee Fileinput](https://plugins.krajee.com/file-input)
- [Krajee Select2](https://demos.krajee.com/widget-details/select2) 
- [Testes com Codeception](https://codeception.com/)
- [MySQL Workbench](https://dev.mysql.com/downloads/workbench/)
-->

INSTALAÇÃO
------------

Com o [Docker](http://docker.com) devidamente instalado e funcionando, executar o seguinte comando:

```
$ git clone git@github.com/juniorari/api-pokemon.git
```

Acesse o diretório:

```
$ cd api-pokemon/
```

Atualize os pacotes (seja paciente...):

```
$ docker-compose run --rm php composer update --prefer-dist -vvv
``` 
???????????????????????????????

Run the installation triggers (creating cookie validation code)
```
$ docker-compose run --rm php composer install    
```

Dê permissão de escrita aos diretórios `web/assets` e `runtime`:
```
$ chmod -R 777 web/assets
$ chmod -R 777 runtime
``` 
### Banco de Dados

Caso necessário, editar o arquivo `config/db.php` com os dados de acesso ao banco no container:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mysql;dbname=pokemon',
    'username' => 'root',
    'password' => 'pokemon',  //senha definida na variável MYSQL_ROOT_PASSWORD do arquivo docker-compose-yml 
    'charset' => 'utf8',
];
```
Executar as migrations:
```
$ php yii migrate
```

**OBS:**
- Não é necessário criar o banco de dados. A configuração do docker já faz isso! ;-)


Inicialize os containers:

```
$ docker-compose up -d
```
A aplicação estará disponível na seguinte URL:
```
http://127.0.0.1:8000
```

**OBS:** 
- O mínimo requerido para o Docker engine é a versão `17.04` (veja em [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.composer-docker` for composer caches
- A configuração padrão usa o diretório `.composer-docker` na home para os caches do composer

A API
---
A API está documentada no endereço: [https://documenter.getpostman.com/view/2889430/TVCY5rka](https://documenter.getpostman.com/view/2889430/TVCY5rka)


Realizando Testes com Codeception
----

* Caso tenha alterado a url e/ou porta, atualizar ou alterar o parâmetro **url** no 
arquivo **tests/acceptance.suite.yml**, de acordo com a URL do site. 
Ex: **http://127.0.0.1:8000**
```
actor: AcceptanceTester
modules:
    enabled:
        - PhpBrowser:
            url: http://127.0.0.1:8000
        - \Helper\Acceptance
```
* Executar os testes:
```
$ php vendor/bin/codecept run
```
