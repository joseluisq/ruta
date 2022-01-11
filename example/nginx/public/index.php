<?php

// Routing examples
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../../../src/Ruta.php';

use Ruta\Ruta;
use Ruta\Request;
use Ruta\Response;
use Ruta\Status;

// 1. Callback style
Ruta::get('/home/hola', function (Request $req, Response $res) {
    $res
        ->json(
            ['headers' => $req->headers()]
        );
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
    $res->json(['post_data' => 11010101010]);
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
