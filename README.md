# BtErrorLog - ZF2 Module that logs dispatch and render errors

Version 1.0 Created by [Benjamin Tigano](http://benjamin-t.com/)

## Introduction

This ZF2 module is used for logging dispatch and render MVC errors to a Zend\Log instance.

## Installation

To install BtErrorLog, recursively clone this repository (`git clone
--recursive`) into your ZF2 modules directory or download and extract into
your ZF2 modules directory.

## Enable the module

Once you've installed the module, you need to enable it. You can do this by 
adding it to your `config/application.config.php` file:

```php
<?php
return array(
    'modules' => array(
        'Application',
        'BtErrorLog',
    ),
);
```

## Configuration

Create a file in `config/autoload` named `logs.local.php` with the following contents:
```php
return array(
    'log' => array(
        'MyErrorLogger' => array(
            'writers' => array(
                array(
                    'name' => 'Zend\Log\Writer\Stream',
                    'options' => array(
                        "stream" => "data/error.log"
                    )
                )
            )
        ),
    ),
);
```

Data will be logged to the `data/error.log` file.

## License

BtErrorLog is released under a New BSD license. See the included LICENSE file.