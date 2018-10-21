# 🐪💼 PHP Camel Caser

[![StyleCI](https://github.styleci.io/repos/147511192/shield?branch=master)](https://github.styleci.io/repos/147511192)
[![Packagist](https://img.shields.io/packagist/dt/divineomega/php-camel-caser.svg)](https://packagist.org/packages/divineomega/php-camel-caser/stats)

This package lets you use built-in PHP functions in camel case.

## Installation


PHP Camel Caser can be easily installed using Composer. Just run the following command from the root of your project.

```
composer require divineomega/php-camel-caser
```

If you have never used the Composer dependency manager before, head to the [Composer website](https://getcomposer.org/) for more information on how to get started.

## Usage

After installing PHP Camel Caser, the new functions are available straight away.

Some example usage is shown below.

```php
require_once __DIR__.'/vendor/autoload.php';

strReplace('c', 'b', 'cat');                // bat
strWordCount("Hello world!");               // 2
inArray('Picard', ['Picard', 'Janeway']);   // true

// and so on...
```

