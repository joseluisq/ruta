<?php

use Ruta\Header;

test('Header: validate constants', function () {
    $header = new \ReflectionClass(Header::class);
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
