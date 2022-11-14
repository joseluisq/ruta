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
    public static function path_segments(string $path): array
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
                $segs[]  = '';
            }
            $segs[$j] .= $path[$i];
        }

        return $segs;
    }

    /**
     * Check if a string path matches a given path segments.
     * It supports "equal", "placeholders" and "regular expressions" matches.
     *
     * @param string        $path_slug          the input path slug. It can be a plain path, "placeholders" or "regular expressions".
     * @param array<string> $path_segs_to_match the path segments to match the input path against it
     *
     * @return array{0:bool,1:string[]} returns an array of two elements. First is a bool if matched and second are path arguments.
     */
    public static function match_path_query(string $path_slug, array $path_segs_to_match): array
    {
        $match            = true;
        $args             = [];
        $segs             = RutaUtils::path_segments($path_slug);
        $segs_count       = count($segs);
        $has_placeholder  = false;

        // TODO: check also query uri

        for ($i = 0; $i < $segs_count; $i++) {
            // Safety check for "undefined array index"
            if (!array_key_exists($i, $path_segs_to_match)) {
                $match = false;
                break;
            }

            $seg      = $segs[$i];
            $path_seg = $path_segs_to_match[$i];

            // 1. If current segment matches then just continue
            if ($seg === $path_seg) {
                continue;
            }

            // 2. Otherwise proceed with the segment validation

            // 2.1. Check for "Placeholders"
            if (str_starts_with($seg, '{') && str_ends_with($seg, '}')) {
                $key = substr(substr($seg, 1), 0, -1);
                if ($key !== '') {
                    $args[$key]      = $path_seg;
                    $has_placeholder = true;
                    continue;
                }
            }

            // 2.2. Check for "Regular Expressions"
            // Format: regex(key=^[0-9]+$)
            if (str_starts_with($seg, 'regex(') && str_ends_with($seg, ')')) {
                $regex_key_start = strpos($seg, '(');
                $regex_key_end   = strpos($seg, '=');

                if (is_integer($regex_key_start) && is_integer($regex_key_end)) {
                    $regex_key      = substr($seg, $regex_key_start + 1);
                    $regex_key_last = strpos($regex_key, '=');

                    if (is_integer($regex_key_last)) {
                        $regex     = substr($seg, $regex_key_end + 1);
                        $regex     = substr($regex, 0, strlen($regex) - 1);

                        if (preg_match("/$regex/", $path_seg) === 1) {
                            $regex_key             = substr($regex_key, 0, $regex_key_last);
                            $args[$regex_key]      = $path_seg;
                            $has_placeholder       = true;
                            continue;
                        }
                    }
                }
            }

            $match = false;
            break;
        }

        if ($match && !$has_placeholder && $segs_count < count($path_segs_to_match)) {
            $match = false;
        }

        return [$match, $args];
    }
}
