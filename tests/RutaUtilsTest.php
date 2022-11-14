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

use Ruta\RutaUtils;

test('path_segments: returns empty array', function () {
    expect(RutaUtils::path_segments(''))->toBeArray()->toBeEmpty();
    expect(RutaUtils::path_segments('/'))->toBeArray()->toBeEmpty();
});

test('path_segments: returns valid segments skipping repeated slashes', function () {
    expect(RutaUtils::path_segments('//reg/1234//exp/'))->toMatchArray(['1234', 'exp']);
});

test('path_segments: returns valid segments', function () {
    expect(RutaUtils::path_segments('/reg/1234/exp'))->toMatchArray(['reg', '1234', 'exp']);
    expect(RutaUtils::path_segments('/ábc/dñefgh/12.html'))->toMatchArray(['ábc', 'dñefgh', '12.html']);
    expect(RutaUtils::path_segments('/abc/def ghi/'))->toMatchArray(['abc', 'def ghi']);
});

test('match_path_query: should not match when invalid plain path or segments', function () {
    $path_segs = RutaUtils::path_segments('');
    expect(RutaUtils::match_path_query('/abc/4567/def/', $path_segs))->toBe([false, []]);

    $path_segs = RutaUtils::path_segments('///abc/4567/def/');
    expect(RutaUtils::match_path_query('/abc/4567/def/', $path_segs))->toBe([false, []]);
});

test('match_path_query: should not match when invalid placeholder path or segments', function () {
    $path_segs = RutaUtils::path_segments('/abc/abcd/def/');
    expect(RutaUtils::match_path_query('/abc/{id/def/', $path_segs))->toBe([false, []]);
    expect(RutaUtils::match_path_query('/abc/id}/def/', $path_segs))->toBe([false, []]);
});

test('match_path_query: should not match when invalid regex path or segments', function () {
    $path_segs = RutaUtils::path_segments('/abc/xyz/def/');
    expect(RutaUtils::match_path_query('/abc/regex(key=^[A-Z]+$)/def/', $path_segs))->toBe([false, []]);

    $path_segs = RutaUtils::path_segments('/abc/123/def/');
    expect(RutaUtils::match_path_query('/abc/regex(key^[0-9]+$)/def/', $path_segs))->toBe([false, []]);
    expect(RutaUtils::match_path_query('/abc/regexkey^[0-9]+$)/def/', $path_segs))->toBe([false, []]);
    expect(RutaUtils::match_path_query('/abc/regex(key^[0-9]+$/def/', $path_segs))->toBe([false, []]);
    expect(RutaUtils::match_path_query('/abc/regex(key= ^[0-9]+$)/def/', $path_segs))->toBe([false, []]);
});

test('match_path_query: should match when valid plain paths', function () {
    $path_segs = RutaUtils::path_segments('/abc/4567/def/');
    expect(RutaUtils::match_path_query('/abc/4567/def/', $path_segs))->toBe([true, []]);
});

test('match_path_query: should match placeholder when valid paths', function () {
    $path_segs = RutaUtils::path_segments('/abc/7890/def/');
    expect(RutaUtils::match_path_query('/abc/{id}/def/', $path_segs))->toBe([true, ['id' => '7890']]);
});

test('match_path_query: should match regex when valid paths', function () {
    $path_segs = RutaUtils::path_segments('/abc/XYZ/def/');
    expect(RutaUtils::match_path_query('/abc/regex(key=^([A-Z]+)$)/def/', $path_segs))->toBe([true, ['key' => 'XYZ']]);
});
