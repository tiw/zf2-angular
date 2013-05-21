zf2-angular
===========

A prototype using zf2 as backend and anuglarjs as frontend.

## Requirement

1. ant
2. yeoman / node
3. php
4. nginx
5. mysql

## Install

### php

安装php需要的库
    >php composer.phar update
    
### 数据库

1. 创建一个数据库，名字为ppm
2. 导入data/install.sql
3. 创建config/autoload/local.php 添加如下内容

```php

<?php

return array(
    'db' => array(
        'username' => 'root',
        'password' => 'root',
    )
);

```

### 测试页面
    http://<your_domain_name>/#/product


