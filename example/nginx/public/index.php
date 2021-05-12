<?php
// Routing examples
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../../../src/Ruta.php';

// 1. Using callbacks
Ruta::get('/home/hola', function (Request $req, Response $res, array $args) {
    $res->json(['data' => 'Hello World!']);
});
Ruta::put('/home/hola', function (Request $req, Response $res, array $args) {
    $res->redirect('/home/aaa/some/bbb');
});
Ruta::post('/home/{path}', function (Request $req, Response $res, array $args) {
    $res
        ->status(200)
        ->header('X-Header-One', 'Header Value 1')
        ->header('X-Header-Two', 'Header Value 2')
        ->json(['some_data' => 223424234]);
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
        $res->json(['data' => 'Message from within a class!']);
    }
}
Ruta::get('/home/{path1}/some/{path2}', [HomeCtrl::class, 'index']);
