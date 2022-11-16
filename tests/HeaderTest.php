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

use Ruta\Header;

test('Header: validate constants', function () {
    $header  = new \ReflectionClass(Header::class);
    $headers = $header->getConstants();

    expect($headers)->toBeArray();

    foreach ($headers as $k => $h) {
        $parts = explode('-', $h);
        $const = '';
        foreach ($parts as $w) {
            $const = $const . ucfirst($w);
        }

        expect($const)->toBe($k);
    }
});
