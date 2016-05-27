[![Latest Stable Version](https://poser.pugx.org/jiaoyix/jiaoyix-php/v/stable)](https://packagist.org/packages/jiaoyix/jiaoyix-php)
[![Total Downloads](https://poser.pugx.org/jiaoyix/jiaoyix-php/downloads)](https://packagist.org/packages/jiaoyix/jiaoyix-php)
[![Latest Unstable Version](https://poser.pugx.org/jiaoyix/jiaoyix-php/v/unstable)](https://packagist.org/packages/jiaoyix/jiaoyix-php)
[![License](https://poser.pugx.org/jiaoyix/jiaoyix-php/license)](https://packagist.org/packages/jiaoyix/jiaoyix-php)

Jiaoyix PHP SDK
=================
## 简介
lib 文件夹下是 PHP SDK 文件，<br>
example 文件夹里面是简单的接入示例，该示例仅供参考。

## 版本要求
PHP 版本 5.3 及以上

## 安装
### 使用 Composer
在你自己的 `composer.json` 中添加以下代码
```
{
  "require": {
    "jiaoyix/Jiaoyix-php": "dev-master"
  }
}
```
然后执行
```
composer install
```
使用 Composer 的 autoload 引入
```php
require_once('vendor/autoload.php');
```
### 手动引入
``` php
require_once('/path/to/Jiaoyix-php/init.php');
```

## 接入方法
### 初始化
``` php
\Jiaoyix\Jiaoyix::setApiKey('YOUR-KEY');
\Jiaoyix\Jiaoyix::setApiSecret('YOUR-SECRET');
\Jiaoyix\Jiaoyix::setAppId('YOUR-APP-ID');
```

### 创建 用户
```php
\Jiaoyix\User::create(array(
    'description' => '描述',
    'email' => 'xxx@163.com',
    'phone' => '1xxxxxxxxxx',
    'shipping' => array(
        'address' => '具体地址',
        'name' => '姓名',
        'phone' => '收货人手机号',
    )
));
```


### 创建 商品
```php
\Jiaoyix\Product::create(array(
    'seller' => 'usr_I5rlKWu6xOixVRVBFB5ifLv46K5e',
    'name' => 'iPhone7',
    'price' => '100000',
    'inventory' => 10
));
```

###　创建 订单
```php
\Jiaoyix\Order::create(array(
    'customer' => 'usr_W0sQmbBNcqW2e1U2JEumJ7C12XEt2j2e',
    'items' => array(
        'type' => 'product',
        'parent' => 'pro_INyG9ahiiTG6crCfGY6bG9Igaune'
        'quantity' => 1,
        'amount' => 400,
        'description' => 'iPhone 6s'
    )
));
```

###　支付 订单
```php
$order = \Jiaoyix\Order::retrieve('ord_G9p1Roy7T0H4R0TR2T6E2Cf4TKSe');
$params = array(
    'channel' => 'wx_pub',
    'extra' => array()
);
$order->pay($params);
```

###　查询 支付
```php
\Jiaoyix\Charge::retrieve('cha_4tVQUAaQIofT3tv4ufF4T354sT1e');
```


