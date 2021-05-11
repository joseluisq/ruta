<?php

// Routing example

error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../../../src/Ruta.php';

Ruta::get('/home/hola', function (Request $req, Response $resp, array $args) {
    // echo "<pre>";
    // echo "<b>GET /home/hola</b>\n";
    // var_dump($args);
    // echo "</pre>\n";

    $resp->json(['data' => 'hello world!']);
});

Ruta::put('/home/hola', function (Request $req, Response $resp, array $args) {
    // echo "<pre>";
    // echo "<b>POST /home/hola</b>\n";
    // var_dump($args);
    // echo "</pre>\n";

    $resp->redirect('/home/aaa/some/bbb');
});

Ruta::put('/home/{path}', function (Request $req, Response $resp, array $args) {
    // echo "<pre>";
    // echo "<b>PUT /home/{path}</b>\n";
    // var_dump('PATH: ' . $args['path']);
    // var_dump($req->multipart());
    // var_dump($req->query());
    // echo "</pre>\n";

    $resp
        ->header('X-Header-One', 'Header Value')
        ->header('X-Header-Two', 'Header Value')
        ->json(['data' => 123123123]);
});

class HomeCtrl {
    public function index(Request $req, Response $resp, array $args) {
        echo "<pre>";
        echo "<b>GET /home/{path1}/some/{path2}</b>\n";
        var_dump($args);
        echo "</pre>\n";
    }
}

Ruta::get('/home/{path1}/some/{path2}', [HomeCtrl::class, 'index']);
