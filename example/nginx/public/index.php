<?php

// Routing examples
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../../../src/Ruta.php';

use Ruta\Ruta;
use Ruta\Request;
use Ruta\Response;

// 1. Using callbacks
Ruta::get('/home/hola', function (Request $req, Response $res, array $args) {
    $res->json(['data' => 'Hello World!']);
});
Ruta::get('/home/hola/redirect', function (Request $req, Response $res, array $args) {
    $res->redirect('/home/aaa/some/bbb');
});
Ruta::get('/home/files/{file}', function (Request $req, Response $res, array $args) {
    $base_path = getcwd();
    $file_path = $args['file'];
    $res->file($base_path, $file_path);
});

// 2. Using a class and method
class HomeCtrl
{
    public function index(Request $req, Response $res, array $args)
    {
        // 2.1 $args contains route placeholder values
        if ($args['path1']) {
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

// [Fri Dec 17 23:10:28 2021] 172.17.0.1:48748 Accepted
// [Fri Dec 17 23:10:28 2021] 172.17.0.1:48746 Closed without sending a request; it was probably just an unused speculative preconnection
// [Fri Dec 17 23:10:28 2021] 172.17.0.1:48746 Closing
// [Fri Dec 17 23:10:28 2021] 172.17.0.1:48748 [200]: POST /home/xyz/some2
// [Fri Dec 17 23:10:28 2021] 172.17.0.1:48748 Closing
Ruta::post('/home/{path3}/some2', function (Request $req, Response $res, array $args) {
    $res
        ->status()
        ->json(['post_data' => 11010101010]);
});

Ruta::post('/home/{path}', function (Request $req, Response $res, array $args) {
    $res
        ->status()
        ->header('X-Header-One', 'Header Value 1')
        ->header('X-Header-Two', 'Header Value 2')
        ->json(['some_data' => 223424234]);
});
