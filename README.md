# Ruta

> A single-file and lightweight HTTP routing library for PHP. (WIP)

## Requirements

[PHP 8.0+](https://www.php.net/releases/8.0/en.php)

## Usage

```php
<?php

use Ruta\Ruta;
use Ruta\Request;
use Ruta\Response;

// 1. Callback style
Ruta::get('/home/hola', function (Request $req, Response $res, array $args) {
    $res->json(['data' => 'Hello World!']);
});
Ruta::get('/home/hola/redirect', function (Request $req, Response $res, array $args) {
    $res->redirect('/home/aaa/some/bbb');
});
Ruta::put('/home/{path}', function (Request $req, Response $res, array $args) {
    $res
        ->status()
        ->header('X-Header-One', 'Header Value 1')
        ->header('X-Header-Two', 'Header Value 2')
        ->json(['timestamp' => time()]);
});
Ruta::get('/home/files/{file}', function (Request $req, Response $res, array $args) {
    $base_path = getcwd();
    $file_path = $args['file'];
    $res->file($base_path, $file_path);
});

// 2. Class-method style
class HomeCtrl
{
    public function index(Request $req, Response $res, array $args)
    {
        // 2.1 $args contains route placeholder values
        if ($args['path1']) {
        }
        // 2.2. It gets the data provided via `multipart/form-data` 
        $data = $req->multipart();
        // 2.3. It gets the data provided via `application/x-www-form-urlencoded` 
        $data = $req->urlencoded();
        // 2.4. It gets the data provided via `application/json`
        $data = $req->json();
        // 2.5. It gets the data provided via `application/xml`
        $data = $req->xml();
        // 2.6. It gets the query data
        $data = $req->query();
        // Note: also other methods like xml(), text() and html()
        $res->json(['data' => 'Hi from a class method!']);
    }
}
Ruta::post('/home/{path1}/some/{path2}', [HomeCtrl::class, 'index']);
```

## Code example

File: [example/nginx/public/index.php](example/nginx/public/index.php)

```sh
# Run example using the PHP built-in server
make dev
```

```sh
# Or run example using Docker + Nginx server
make compose
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
