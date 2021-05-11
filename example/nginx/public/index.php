<?php
// Routing examples
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../../../src/Ruta.php';

// 1. Using callbacks
Ruta::get('/home/hola', function (Request $req, Response $res, array $args) {
    $res->json(['data' => 'hello world!']);
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

// 2. Using a class and method
class HomeCtrl {
    public function index(Request $req, Response $res, array $args) {
        // 1.1 $args contains route placeholder values
        if ($args['path1']) { }
        // 1.2. Get data provided via `multipart/form-data` 
        $data = $req->multipart();
        // 1.3. Get data provided via `application/x-www-form-urlencoded` 
        $data = $req->urlencoded();
        // 1.4. Get data provided via `application/json`
        $data = $req->json();
        // 1.5. Get data provided via `application/xml`
        $data = $req->xml();
        // 1.6. Get query data
        $data = $req->query();
        $res->json(['data' => 'hello world!']);
    }
}
Ruta::get('/home/{path1}/some/{path2}', [HomeCtrl::class, 'index']);
