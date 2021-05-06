<?php

// Routing example

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'Ruta.php';

Ruta::get('/home/hola', function (Request $req, Response $resp, array $args) {
    echo "<pre>";
    echo "<b>GET /home/hola</b>\n";
    var_dump($args);
    echo "</pre>\n";
});

Ruta::get('/home/{path}', function (Request $req, Response $resp, array $args) {
    echo "<pre>";
    echo "<b>GET /home/{path}</b>\n";
    var_dump('PATH: ' . $args['path']);
    echo "</pre>\n";
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
