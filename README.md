# Ruta

[![tests ci](https://github.com/joseluisq/ruta/actions/workflows/tests.yml/badge.svg?branch=master)](https://github.com/joseluisq/ruta/actions/workflows/tests.yml) [![Latest Stable Version](https://poser.pugx.org/joseluisq/ruta/version)](https://packagist.org/packages/joseluisq/ruta) [![Latest Unstable Version](https://poser.pugx.org/joseluisq/ruta/v/unstable)](//packagist.org/packages/joseluisq/ruta) [![Total Downloads](https://poser.pugx.org/joseluisq/ruta/downloads)](https://packagist.org/packages/joseluisq/ruta) [![License](https://poser.pugx.org/joseluisq/ruta/license)](https://packagist.org/packages/joseluisq/ruta)

> A lightweight single-file HTTP routing library for PHP. (WIP)

## Requirements

[PHP 8.0](https://www.php.net/releases/8.0/en.php) or newer.

## Install

Install via [Composer](https://packagist.org/packages/joseluisq/ruta)

```sh
composer require joseluisq/ruta:dev-master
```

## Usage

```php
<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Ruta\Header;
use Ruta\Method;
use Ruta\Ruta;
use Ruta\Request;
use Ruta\Response;
use Ruta\Status;

// 1. Callback style

// NOTE: `Request`, `Response`, `array` (slug arguments) are passed to the callback.
// However they are optional and their order can be modified. See more examples below.

Ruta::get('/home/hola', function (Request $req, Response $res) {
    $res->json([
        'host' => $req->header(Header::Host),
        'headers' => $req->headers(),
    ]);
});
Ruta::get('/home/hola/redirect', function (Response $res) {
    $res->redirect('/home/aaa/some/bbb');
});
Ruta::post('/home/{path3}/some2', function (Response $res) {
    $res->json(['post_data' => 11010101010]);
});

Ruta::some('/home/some', [Method::POST, Method::PUT], function (Request $req, Response $res) {
    $res->json(['only' => $req->method()]);
});

Ruta::any('/home/methods', function (Request $req, Response $res) {
    $res->json(['method' => $req->method()]);
});

Ruta::post('/home/{path}', function (Response $res) {
    $res
        ->header('X-Header-One', 'Header Value 1')
        ->header('X-Header-Two', 'Header Value 2')
        ->json(['some_data' => 223424234]);
});

// 2. class/method style
class HomeCtrl
{
    public function index(Request $req, Response $res, array $args)
    {
        // 2.1 $args contains route placeholder values
        if (isset($args['path1'])) {
            // do something...
        }

        // 2.2. Get data provided via `multipart/form-data` 
        $data = $req->multipart();
        // 2.3. Get all headers
        $data = $req->headers();
        // 2.4. Get a single header
        $data = $req->header("Host");
        // 2.5. Get data provided via `application/x-www-form-urlencoded` 
        $data = $req->urlencoded();
        // 2.6. Get data provided via `application/json`
        $data = $req->json();
        // 2.7. Get data provided via `application/xml`
        $data = $req->xml();
        // 2.8. Get query data
        $data = $req->query();

        $res->json(['data' => 'Message from a class!']);
    }

    // Custom 404 reply
    public function not_found(Response $res)
    {
        $res
            ->status(Status::NotFound)
            ->text("404 - Page Not Found!");
    }
}

Ruta::get('/home/{path1}/some/{path2}', [HomeCtrl::class, 'index']);

// 3. Handle 404 not found routes
Ruta::not_found([HomeCtrl::class, 'not_found']);
```

## Code example

File: [example/nginx/public/index.php](example/nginx/public/index.php)

```sh
# Or run example using Docker + Nginx server
make compose-up
```

```sh
# Run example using the PHP built-in server
make container-dev
```

Now navigate for example to [http://localhost:8088/home/hola](http://localhost:8088/home/hola)

## Contributions

Feel free to send a [pull request](https://github.com/joseluisq/ruta/pulls) or file some [issue](https://github.com/joseluisq/ruta/issues).

## Contributions

Unless you explicitly state otherwise, any contribution intentionally submitted for inclusion in current work by you, as defined in the Apache-2.0 license, shall be dual licensed as described below, without any additional terms or conditions.

Feel free to send some [Pull request](https://github.com/joseluisq/ruta/pulls) or [issue](https://github.com/joseluisq/ruta/issues).

## License

This work is primarily distributed under the terms of both the [MIT license](LICENSE-MIT) and the [Apache License (Version 2.0)](LICENSE-APACHE).

© 2021-present [Jose Quintana](https://git.io/joseluisq)
