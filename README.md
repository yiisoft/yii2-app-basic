Yii 2 Basic Plus Project Template
=================================

Yii 2 Basic Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
rapidly creating small projects. Now it's a little customized for using environments in your projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      environments/        contains environments ('dev' and 'prod' by default)
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

~~~
php composer.phar global require "fxp/composer-asset-plugin:~1.1.1"
php composer.phar create-project --prefer-dist --stability=dev the0rist/yii2-basic-plus basic-plus
~~~

Now you should be able to access the application through the following URL, assuming `basic-plus` is the directory
directly under the Web root.

~~~
http://localhost/basic-plus/web/
~~~

Or you can do `sudo vagrant up` from your terminal (in the project root), drink some coffee while VM is preparing, then add this line to your hosts file: 
~~~
192.168.56.102 yii2basic.dev
~~~
Now you can access your project inside Virtual Box VM.
This method requires pre-installed [VirtualBox](https://www.virtualbox.org/wiki/Downloads) and [Vagrant](https://www.vagrantup.com/) on your machine.

FIRST RUN
---------

Don't forget to do `php init` in your terminal inside the project root directory and select your environment.

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
- Refer to the README in the `tests` directory for information specific to basic application tests.
