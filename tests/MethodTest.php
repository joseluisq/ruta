<?php

use Ruta\Method;

test('Method: validate constants', function () {
    $method = new \ReflectionClass(Method::class);
    $methods = $method->getConstants();

    expect($methods)->toBeArray();

    foreach ($methods as $k => $h) {
        expect($h)->toBe($k);
    }
});
