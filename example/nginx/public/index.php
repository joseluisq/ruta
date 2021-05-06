<?php

// Example

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'Ruta.php';

echo "<pre>";

Ruta::get('/home/hola', function (Request $req, Response $resp, array $args) {
    echo "GET /home/hola\n";
    var_dump($args);
    echo "\n";
});

Ruta::get('/home/{path}', function (Request $req, Response $resp, array $args) {
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

Ruta::get('/home/{path}/some/{path}', [HomeCtrl::class, 'index']);
