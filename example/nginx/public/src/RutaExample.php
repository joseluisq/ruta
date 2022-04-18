<?php

declare(strict_types=1);

/*
 * This file is part of Ruta.
 *
 * (c) Jose Quintana <joseluisq.net>
 *
 * This source file is subject to the Apache 2.0 and MIT licenses which are bundled
 * with this source code in the files LICENSE-APACHE and LICENSE-MIT respectively.
 */

namespace RutaExample;

use Ruta\Header;
use Ruta\Method;
use Ruta\Ruta;
use Ruta\Request;
use Ruta\Response;
use Ruta\Status;

// 1. Callback style

// NOTE: `Request`, `Response`, `array` (slug arguments) are passed to the callback.
// However they are optional and their order can be modified. See more examples below.

$app = new \AppGati;
$app->step('start');

// Middleware example which should be defined at the beginning
Ruta::before(function (Request $req, Response $resp) {
    // Example: Redirect if request uri is /
    if ($req->uri() === '/') {
        $resp->redirect('/server/info');
        exit;
    }
});

Ruta::get('/server/info', function (Request $req, Response $resp) {
    $app = new \AppGati;
    $app->step('start');

    $resp->json([
        'server' => $_SERVER,
        'method' => $req->method(),
        ...$req->headers(),
    ]);

    $app->step('end');
    $report = $app->getReport('start', 'end');
    file_put_contents('/usr/share/nginx/html/log.log', var_export($report, true) . PHP_EOL, LOCK_EX);
});

Ruta::get('/home/hola/redirect', function (Response $resp) {
    $resp->redirect('/home/aaa/some/bbb');
});

Ruta::get('/reg/regex(id=^[0-9]+$)/exp', function (Response $resp, array $args, array $data) {
    $resp->json(['args' => $args, 'data' => $data]);
}, ['a', 1, 'b', 2]);

Ruta::post('/home/{path3}/some2', function (Response $resp) {
    $resp->json(['post_data' => 11010101010]);
});

Ruta::some('/home/some', [Method::POST, Method::PUT], function (Request $req, Response $resp) {
    $resp->json(['only' => $req->method()]);
});

Ruta::any('/home/methods', function (Request $req, Response $resp) {
    $resp->json(['method' => $req->method()]);
});

Ruta::post('/home/{path}', function (Response $resp) {
    $resp
        ->header('X-Header-One', 'Header Value 1')
        ->header('X-Header-Two', 'Header Value 2')
        ->header(Header::Server, 'Ruta Server')
        ->json(['some_data' => 223424234]);
});

// 2. class/method style
class HomeCtrl
{
    public function index(Request $req, Response $resp, array $args)
    {
        // 2.1 $args contains route placeholder values
        if (array_key_exists('path1', $args)) {
            // do something...
        }

        // 2.2. Get data provided via `multipart/form-data` 
        $data = $req->multipart();
        // 2.3. Get all headers
        $data = $req->headers();
        // 2.4. Get a single header
        $data = $req->header('Host');
        // 2.5. Get data provided via `application/x-www-form-urlencoded` 
        $data = $req->urlencoded();
        // 2.6. Get data provided via `application/json`
        $data = $req->json();
        // 2.7. Get data provided via `application/xml`
        $data = $req->xml();
        // 2.8. Get query data
        $data = $req->query();

        $resp->json(['data' => 'Message from a class!']);
    }

    // Custom 404 reply
    public function not_found(Response $resp)
    {
        $resp
            ->status(Status::NotFound)
            ->xml('404 - Page Not Found!');
    }
}

Ruta::get('/home/{path1}/some/{path2}', [HomeCtrl::class, 'index']);

// 3. Handle 404 not found routes
Ruta::not_found([HomeCtrl::class, 'not_found']);

$app->step('end');
$report = $app->getReport('start', 'end');
file_put_contents('/usr/share/nginx/html/log.log', var_export($report, true) . PHP_EOL, LOCK_EX);
