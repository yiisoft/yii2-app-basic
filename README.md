Yii2微信系统模板
==============

以[Yii2-app-basic](https://github.com/yiisoft/yii2-app-basic)为基础模板展现[Yii2-wechat](https://github.com/callmez/yii2-wechat)模块的基础功能,  可用于生产环境或模块使用示例.


安装要求
-------

PHP >= 5.4.0.


安装
---


### 使用Composer安装

命令行执行以下命令:

~~~
// Yii2框架依赖
php composer.phar global require "fxp/composer-asset-plugin:1.0.0" 
// 框架安装为wechat目录
php composer.phar create-project --prefer-dist --stability=dev callmez/yii2-app-wechat wechat 
~~~


配置
---

### 数据库

编辑 `config/db.php` 填入你的数据库配置, 例如:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2wechat', // 数据库必须存在. 
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

### 微信设置

当数据库配置完成后, 需要执行一些步骤来完整的使用wechat模块提供的功能

命令行执行

~~~
// 迁移wechat模块数据库表
php yii migrate --migrationPath=@callmez/wechat/migrations 
// 迁移示例模块数据库表, 如果已经熟悉微信模块的功能这一步可以略过
php yii migrate --migrationPath=@app/modules/example/migrations 
~~~

访问
---
如果以上都设置完毕, 并且应用安装在你的Web服务访问目录下, 你只需要在浏览器输入以下地址即可体验
~~~
http://localhost/wechat/web
~~~
