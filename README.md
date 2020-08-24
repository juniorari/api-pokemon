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

~~~
$ git clone git@github.com/juniorari/api-pokemon.git
~~~

Acesse o diretório:

~~~
$ cd api-pokemon/
~~~

Atualize os pacotes (seja paciente...):

~~~
$ docker-compose run --rm php composer update --prefer-dist -vvv
~~~ 
???????????????????????????????
Run the installation triggers (creating cookie validation code)
~~~
$ docker-compose run --rm php composer install    
~~~

Dê permissão de escrita aos diretórios `web/assets` e `runtime`:
~~~
$ chmod -R 777 web/assets
$ chmod -R 777 runtime
~~~ 
Inicialize os containers:

~~~
$ docker-compose up -d
~~~
A aplicação estará disponível na seguinte URL:
~~~
http://127.0.0.1:8000
~~~

**OBS:** 
- O mínimo requerido para o Docker engine é a versão `17.04` (veja em [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.composer-docker` for composer caches
- A configuração padrão usa o diretório `.composer-docker` na home para os caches do composer


CONFIGURAÇÃO
-------------

### Banco de Dados

Edite o arquivo `config/db.php` com os dados de acesso ao banco no container:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mysql;dbname=pokemon',
    'username' => 'root',
    'password' => 'pokemon',
    'charset' => 'utf8',
];
```
Executar as migrations:
```
$ php yii migrate
```

**OBS:**
- Não é necessário criar o banco de dados. A configuração do docker já faz isso! ;-)


TESTING
-------

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](http://codeception.com/).
By default there are 3 test suites:

- `unit`
- `functional`
- `acceptance`

Tests can be executed by running

```
vendor/bin/codecept run
```

The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction. Acceptance tests are disabled by default as they require additional setup since
they perform testing in real browser. 


### Running  acceptance tests

To execute acceptance tests do the following:  

1. Rename `tests/acceptance.suite.yml.example` to `tests/acceptance.suite.yml` to enable suite configuration

2. Replace `codeception/base` package in `composer.json` with `codeception/codeception` to install full featured
   version of Codeception

3. Update dependencies with Composer 

    ```
    composer update  
    ```

4. Download [Selenium Server](http://www.seleniumhq.org/download/) and launch it:

    ```
    java -jar ~/selenium-server-standalone-x.xx.x.jar
    ```

    In case of using Selenium Server 3.0 with Firefox browser since v48 or Google Chrome since v53 you must download [GeckoDriver](https://github.com/mozilla/geckodriver/releases) or [ChromeDriver](https://sites.google.com/a/chromium.org/chromedriver/downloads) and launch Selenium with it:

    ```
    # for Firefox
    java -jar -Dwebdriver.gecko.driver=~/geckodriver ~/selenium-server-standalone-3.xx.x.jar
    
    # for Google Chrome
    java -jar -Dwebdriver.chrome.driver=~/chromedriver ~/selenium-server-standalone-3.xx.x.jar
    ``` 
    
    As an alternative way you can use already configured Docker container with older versions of Selenium and Firefox:
    
    ```
    docker run --net=host selenium/standalone-firefox:2.53.0
    ```

5. (Optional) Create `yii2_basic_tests` database and update it by applying migrations if you have them.

   ```
   tests/bin/yii migrate
   ```

   The database configuration can be found at `config/test_db.php`.


6. Start web server:

    ```
    tests/bin/yii serve
    ```

7. Now you can run all available tests

   ```
   # run all available tests
   vendor/bin/codecept run

   # run acceptance tests
   vendor/bin/codecept run acceptance

   # run only unit and functional tests
   vendor/bin/codecept run unit,functional
   ```

### Code coverage support

By default, code coverage is disabled in `codeception.yml` configuration file, you should uncomment needed rows to be able
to collect code coverage. You can run your tests and collect coverage with the following command:

```
#collect coverage for all tests
vendor/bin/codecept run -- --coverage-html --coverage-xml

#collect coverage only for unit tests
vendor/bin/codecept run unit -- --coverage-html --coverage-xml

#collect coverage for unit and functional tests
vendor/bin/codecept run functional,unit -- --coverage-html --coverage-xml
```

You can see code coverage output under the `tests/_output` directory.
