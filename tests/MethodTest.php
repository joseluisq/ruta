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

use Ruta\Method;

test('Method: validate constants', function () {
    $method  = new \ReflectionClass(Method::class);
    $methods = $method->getConstants();

    expect($methods)->toBeArray();

    foreach ($methods as $k => $h) {
        expect($h)->toBe($k);
    }
});
