<?php

use Ruta\Status;

test('Status: validate status code contants', function () {
    $status   = new \ReflectionClass(Status::class);
    $statuses = $status->getConstants(\ReflectionClassConstant::IS_PUBLIC);

    expect($statuses)->toBeArray();

    foreach ($statuses as $k => $i) {
        expect($i)->toBeInt();

        $txt   = Status::text($i);
        $parts = explode(' ', str_replace($txt, '-', ''));
        $const = '';
        foreach ($parts as $w) {
            $const = $const . ucfirst($w);
        }

        expect($k)->toContain($const);
    }
});

test('Status: invalid status code value', function () {
    expect(Status::text(-1))->toBeEmpty();
    expect(Status::text(1000))->toBeEmpty();
});
