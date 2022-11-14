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

namespace Ruta;

final class RutaUtils
{
    /**
     * @return array<string>
     */
    public static function path_as_segments(string $path): array
    {
        $raw = parse_url($path, PHP_URL_PATH);
        if (!is_string($raw)) {
            return [];
        }
        $path    = trim($raw);
        $segs    = [];
        $j       = 0;
        $slashes = 0;
        for ($i = 0; $i < strlen($path); $i++) {
            if ($path[$i] === '/') {
                $slashes++;
                if ($i === 0 || $slashes > 1) {
                    continue;
                }
                $j++;
                continue;
            }
            if (!array_key_exists($j, $segs)) {
                $slashes = 0;
                array_push($segs, '');
            }
            $segs[$j] .= $path[$i];
        }

        return $segs;
    }

    /**
     * @param array<string> $full_path_segments
     *
     * @return array{0:bool,1:string[]}
     */
    public static function match_path_query(string $path, array $full_path_segments): array
    {
        $match            = true;
        $args             = [];
        $segs_def         = RutaUtils::path_as_segments($path);
        $segs_def_count   = count($segs_def);
        $has_placeholder  = false;

        // TODO: check also query uri
        for ($i = 0; $i < $segs_def_count; $i++) {
            // Safety check for "undefined array index"
            if (!array_key_exists($i, $full_path_segments)) {
                $match = false;
                break;
            }

            $seg = $segs_def[$i];

            // 1. If current segment matches then just continue
            if ($seg === $full_path_segments[$i]) {
                continue;
            }

            // 2. Otherwise proceed with the segment validation

            // 1. Placeholders
            if (str_starts_with($seg, '{') && str_ends_with($seg, '}')) {
                $key = substr(substr($seg, 1), 0, -1);
                if ($key !== '') {
                    $args[$key]      = $full_path_segments[$i];
                    $has_placeholder = true;
                    continue;
                }
            }

            // 2. Regular Expressions
            // format: regex(key=^[0-9]+$)
            if (str_starts_with($seg, 'regex(') && str_ends_with($seg, ')')) {
                $slug            = $segs_def[$i];
                $regex_key_start = strpos($slug, '(');
                $regex_key_end   = strpos($slug, '=');

                if (is_integer($regex_key_end) && is_integer($regex_key_start)) {
                    $regex_key      = substr($slug, $regex_key_start + 1);
                    $regex_key_last = strpos($regex_key, '=');

                    if (is_integer($regex_key_last)) {
                        $regex_key = substr($regex_key, 0, $regex_key_last);
                        $regex     = substr($slug, $regex_key_end + 1);
                        $regex     = substr($regex, 0, strlen($regex) - 1);

                        if (preg_match("/$regex/", $full_path_segments[$i]) === 1) {
                            $args[$regex_key]      = $full_path_segments[$i];
                            $has_placeholder       = true;
                            continue;
                        }
                    }
                }
            }

            $match = false;
            break;
        }

        if ($match && !$has_placeholder && $segs_def_count < count($full_path_segments)) {
            $match = false;
        }

        return [$match, $args];
    }
}
