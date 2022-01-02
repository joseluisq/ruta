# Ruta

> A lightweight single-file HTTP routing library for PHP. (WIP)

## Requirements

[PHP 8.0](https://www.php.net/releases/8.0/en.php) or newer.

## Usage

```php
<?php

// 1. Callback style
Ruta::get('/home/hola', function (Response $res) {
    $res->json(['data' => 'Hello World!']);
});
Ruta::get('/home/hola/redirect', function (Response $res) {
    $res->redirect('/home/aaa/some/bbb');
});
Ruta::get('/home/files/{file}', function (Response $res, array $args) {
    $base_path = getcwd();
    $file_path = $args['file'];
    $res->file($base_path, $file_path);
});

Ruta::post('/home/{path3}/some2', function (Response $res) {
    $res
        ->status()
        ->json(['post_data' => 11010101010]);
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
        // 2.3. Get data provided via `application/x-www-form-urlencoded` 
        $data = $req->urlencoded();
        // 2.4. Get data provided via `application/json`
        $data = $req->json();
        // 2.5. Get data provided via `application/xml`
        $data = $req->xml();
        // 2.6. Get query data
        $data = $req->query();
        $res->json(['data' => 'Message from a class!']);
    }
}

Ruta::get('/home/{path1}/some/{path2}', [HomeCtrl::class, 'index']);
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
