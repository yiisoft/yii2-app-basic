<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
    <br>
</p>

Yii 2 Basic Project Template is a skeleton [Yii 2](https://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg?style=for-the-badge&label=Stable&logo=packagist)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg?style=for-the-badge&label=Downloads)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![build](https://img.shields.io/github/actions/workflow/status/yiisoft/yii2-app-basic/build.yml?style=for-the-badge&logo=github&label=Build)](https://github.com/yiisoft/yii2-app-basic/actions?query=workflow%3Abuild)
[![Static Analysis](https://img.shields.io/github/actions/workflow/status/yiisoft/yii2-app-basic/static.yml?style=for-the-badge&label=Static&logo=github)](https://github.com/yiisoft/yii2-app-basic/actions/workflows/static.yml)
[![codecov](https://img.shields.io/codecov/c/github/yiisoft/yii2-app-basic.svg?style=for-the-badge&logo=codecov&logoColor=white&label=Codecov)](https://codecov.io/gh/yiisoft/yii2-app-basic)

## Docker

[![Apache](https://img.shields.io/github/actions/workflow/status/yiisoft/yii2-app-basic/docker.yml?style=for-the-badge&logo=apache&label=Apache)](https://github.com/yiisoft/yii2-app-basic/tree/apache)

DIRECTORY STRUCTURE
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

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 8.2.

INSTALLATION
------------

> [!IMPORTANT]
> - The minimum required [PHP](https://www.php.net/) version of Yii is PHP `8.2`.

## Install via Composer

If you do not have [Composer](https://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](https://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

~~~
composer create-project --prefer-dist yiisoft/yii2-app-basic basic
~~~

Now you should be able to access the application through the following URL, assuming `basic` is the directory
directly under the Web root.

~~~
http://localhost/basic/web/
~~~

## Install from an Archive File

Extract the archive file downloaded from [yiiframework.com](https://www.yiiframework.com/download/) to
a directory named `basic` that is directly under the Web root.

Set cookie validation key in `config/web.php` file to some random secret string:

```php
'request' => [
    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
    'cookieValidationKey' => '<secret random string goes here>',
],
```

You can then access the application through the following URL:

~~~
http://localhost/basic/web/
~~~

## Install with Docker

Update your vendor packages

    docker-compose run --rm php composer update --prefer-dist
    
Run the installation triggers (creating cookie validation code)

    docker-compose run --rm php composer install    
    
Start the container

    docker-compose up -d
    
You can then access the application through the following URL:

    http://127.0.0.1:8000

Run tests inside the container

    docker compose exec -T php vendor/bin/codecept build
    docker compose exec -T php vendor/bin/codecept run

**NOTES:** 
- Minimum required Docker engine version `17.04` for development (see [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.docker-composer` for composer caches


CONFIGURATION
-------------

## Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
- Refer to the README in the `tests` directory for information specific to basic application tests.

TESTING
-------

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](https://codeception.com/).
By default, there are 3 test suites:

- `unit`
- `functional`
- `acceptance`

Tests can be executed by running

```
vendor/bin/codecept run --env php-builtin
```

The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction.


## Acceptance tests

The `acceptance` suite is configured in `tests/Acceptance.suite.yml`.

### Acceptance tests (PhpBrowser)

By default, acceptance tests use the `PhpBrowser` module and run against the built-in PHP web server started via the
`php-builtin` environment.

```
# run all tests with built-in web server
composer tests

# run acceptance tests only
vendor/bin/codecept run Acceptance --env php-builtin
```

### Acceptance tests (WebDriver + Selenium)

To run acceptance tests in a real browser, switch the `acceptance` suite to use the `WebDriver` module.
`tests/Acceptance.suite.yml` contains an example WebDriver configuration (commented).

1. Download and start [Selenium Server](https://www.selenium.dev/downloads/).
2. Install the corresponding browser driver (for example. [GeckoDriver](https://github.com/mozilla/geckodriver/releases) or
   [ChromeDriver](https://googlechromelabs.github.io/chrome-for-testing/)).
3. Update `tests/Acceptance.suite.yml` to enable `WebDriver` and disable `PhpBrowser`.
4. Run:

```
vendor/bin/codecept run Acceptance --env php-builtin
```

## Code coverage support

Code coverage is configured in `codeception.yml`. You can run your tests and collect coverage with the following command:

```
#collect coverage for all tests
vendor/bin/codecept run --coverage --coverage-html --coverage-xml --env php-builtin

#collect coverage only for unit tests
vendor/bin/codecept run Unit --coverage --coverage-html --coverage-xml --env php-builtin

#collect coverage for unit and functional tests
vendor/bin/codecept run Functional,Unit --coverage --coverage-html --coverage-xml --env php-builtin
```

You can see code coverage output under the `tests/Support/output` directory.

## Composer scripts

```
# run all tests
composer tests

# run static analysis
composer static

# run phpcs
composer phpcs

# run phpcbf
composer phpcbf
```

## Support the project

[![Open Collective](https://img.shields.io/badge/Open%20Collective-sponsor-7eadf1?style=for-the-badge&logo=open%20collective&logoColor=7eadf1&labelColor=555555)](https://opencollective.com/yiisoft)

## Follow updates

[![Official website](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=for-the-badge&logo=yii)](https://www.yiiframework.com/)
[![Twitter](https://img.shields.io/badge/twitter-follow-1DA1F2?style=for-the-badge&logo=twitter&logoColor=1DA1F2&labelColor=555555?style=flat)](https://twitter.com/yiiframework)
[![Telegram](https://img.shields.io/badge/telegram-join-1DA1F2?style=for-the-badge&logo=telegram)](https://t.me/yii2en)
[![Slack](https://img.shields.io/badge/slack-join-1DA1F2?style=for-the-badge&logo=slack)](https://yiiframework.com/go/slack)
