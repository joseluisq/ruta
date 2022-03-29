<?php

use Ruta\Request;

test('Request: create initial class instance', function () {
    $uri = '/server/info/';
    $path = explode('/', $uri);
    array_shift($path);
    array_pop($path);

    $req = new Request($uri, 'POST', $path, []);
    expect($req->headers())->toBeEmpty();
    expect($req->header('abc'))->toBeEmpty();
    expect($req->proto())->toBe('HTTP/1.1');
    expect($req->uri())->toBe('/server/info/');
    expect($req->method())->toBe('POST');
    expect($req->path())->toBe(['server', 'info']);
    expect($req->query())->toBeEmpty();
    expect($req->raw())->toBeEmpty();
    expect($req->multipart())->toBeEmpty();
    expect($req->urlencoded())->toBeEmpty();
    expect($req->json())->toBeNull();
    expect($req->xml())->toBeNull();
});
