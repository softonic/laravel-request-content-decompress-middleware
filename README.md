Laravel request content decompress middleware
=====

[![Latest Version](https://img.shields.io/github/release/softonic/laravel-request-content-decompress-middleware.svg?style=flat-square)](https://github.com/softonic/laravel-request-content-decompress-middleware/releases)
[![Software License](https://img.shields.io/badge/license-Apache%202.0-blue.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/softonic/laravel-request-content-decompress-middleware/master.svg?style=flat-square)](https://travis-ci.org/softonic/laravel-request-content-decompress-middleware)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/softonic/laravel-request-content-decompress-middleware.svg?style=flat-square)](https://scrutinizer-ci.com/g/softonic/laravel-request-content-decompress-middleware/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/softonic/laravel-request-content-decompress-middleware.svg?style=flat-square)](https://scrutinizer-ci.com/g/softonic/laravel-request-content-decompress-middleware)
[![Total Downloads](https://img.shields.io/packagist/dt/softonic/laravel-request-content-decompress-middleware.svg?style=flat-square)](https://packagist.org/packages/softonic/laravel-request-content-decompress-middleware)
[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/softonic/laravel-request-content-decompress-middleware.svg?style=flat-square)](http://isitmaintained.com/project/softonic/laravel-request-content-decompress-middleware "Average time to resolve an issue")
[![Percentage of issues still open](http://isitmaintained.com/badge/open/softonic/laravel-request-content-decompress-middleware.svg?style=flat-square)](http://isitmaintained.com/project/softonic/laravel-request-content-decompress-middleware "Percentage of issues still open")

This middleware adds the ability to automatically decompress the content of a compressed request

Installation
-------

Via composer:
```
composer require softonic/laravel-request-content-decompress-middleware
```

Documentation
-------

To use the middleware simply register it in `app/Http/Kernel.php`

```
    protected $middleware
        = [
            ...
            RequestContentDecompress::class,
            ...
        ];
```

From now on all requests having `Content-Encoding: gzip` will be automatically decompressed and processed as a uncompressed request.

Testing
-------

`softonic/laravel-request-content-decompress-middleware` has a [PHPUnit](https://phpunit.de) test suite and a coding style compliance test suite using [PHP CS Fixer](http://cs.sensiolabs.org/).

To run the tests, run the following command from the project folder.

``` bash
$ docker-compose run test
```

License
-------

The Apache 2.0 license. Please see [LICENSE](LICENSE) for more information.

[PSR-2]: http://www.php-fig.org/psr/psr-2/
[PSR-4]: http://www.php-fig.org/psr/psr-4/
