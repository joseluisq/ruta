<?php

// Example

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'Ruta.php';

echo "<pre>";

$route = Ruta::new();

$route::get('/home/hola', function () {
    echo "GET /home/hola\n";
    echo "\n";
});

$route::get('/home/{path}', function (Request $req, Response $resp, array $args) {
    echo "GET /home/{path}\n";
    var_dump('PATH: ' . $args['path']);
    echo "\n";
});

class HomeCtrl
{
    public function index(Request $req, Response $resp, array $args)
    {
        echo "GET /home/{path}/some\n";
        var_dump($args);
        echo "\n";
    }
}

$route::get('/home/{path}/some', [HomeCtrl::class, 'index']);
