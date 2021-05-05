<?php

class Request
{
}
class Response
{
}

/**
 * A WIP and multi purpose (HTTP/CLI) route functionality for PHP.
 */
class Ruta
{
    private static string $uri = "";
    private static string $req_method = "";
    private static array $req_path = [];
    private static array $req_query = [];

    private static $instance;

    private function __construct()
    {
    }

    /**
     * Create a new singleton instance of `Ruta`.
     *
     * @return \Ruta
     */
    static function new(string $request_uri = "", string $request_method = "")
    {
        if (empty($request_uri) && isset($_SERVER['REQUEST_URI'])) {
            $request_uri = $_SERVER['REQUEST_URI'];
        }

        if (empty($request_method) && isset($_SERVER['REQUEST_METHOD'])) {
            $request_method = $_SERVER['REQUEST_METHOD'];
        }

        $uri = trim(urldecode($request_uri));
        $method = trim($request_method);

        if (empty($uri)) {
            throw new InvalidArgumentException('HTTP request uri is not provided.');
        }

        if (empty($method)) {
            throw new InvalidArgumentException('HTTP request method is not provided.');
        }

        self::$uri = $uri;
        self::$req_method = $method;
        self::$req_path = self::parse_path($uri);
        self::$req_query = self::parse_query($uri);

        if (self::$instance) {
            return self::$instance;
        }

        self::$instance = new Ruta();
        return self::$instance;
    }

    private static function match_req_route(string $path): array
    {
        $match = true;
        $args = [];
        $segs = self::parse_path($path);
        // TODO: check also query
        for ($i = 0; $i < count($segs); $i++) {
            $in_seg = self::$req_path[$i];
            $seg = $segs[$i];
            if ($seg !== $in_seg) {
                // If it contains a placeholder and it passes validation
                if (str_starts_with($seg, '{') && str_ends_with($seg, '}')) {
                    $key = trim(str_replace('}', '', str_replace('{', '', $seg)));
                    if (!empty($key)) {
                        $args[$key] = $in_seg;
                        continue;
                    }
                }
                $match = false;
                break;
            }
        }
        return [$match, $args];
    }

    /**
     * It handles a GET request.
     * 
     * @return void
     */
    public static function get(string $path, callable|array $class_method_pair_or_func)
    {
        if (self::$req_method !== 'GET') {
            return;
        }

        list($match, $args) = self::match_req_route($path);
        if (!$match) {
            return;
        }

        if (is_array($class_method_pair_or_func)) {
            if (!count($class_method_pair_or_func) === 2) {
                throw new InvalidArgumentException('Provided value is not a valid class and method pair.');
            }

            list($class_name, $method) = $class_method_pair_or_func;
            $class_method = [new $class_name(), $method];

            if (is_callable($class_method, false)) {
                call_user_func_array($class_method, [new Request(), new Response(), $args]);
                return;
            }

            throw new InvalidArgumentException('Provided class is not defined or its method is not callable.');
        }

        $class_method_pair_or_func(new Request(), new Response(), $args);
    }

    /**
     *
     * @return array
     */
    private static function parse_path(string $path)
    {
        $path = trim(parse_url($path, PHP_URL_PATH));
        $segments = [];
        $idx = 0;

        for ($i = 0; $i < strlen($path); $i++) {
            $s = $path[$i];

            if ($s === '/') {
                if ($i === 0) {
                    continue;
                }

                $idx++;
                continue;
            }

            if (!isset($segments[$idx])) {
                array_push($segments, "");
            }

            $segments[$idx] .= $s;
        }

        return $segments;
    }

    /**
     *
     * @return array
     */
    private static function parse_query(string $query)
    {
        $query = trim(parse_url($query, PHP_URL_QUERY));
        $segments = [];
        $idx = 0;
        $idx2 = 0;

        for ($i = 0; $i < strlen($query); $i++) {
            $s = $query[$i];

            if ($s === '&') {
                $idx2 = 0;

                if ($i === 0) {
                    continue;
                }

                $idx++;
                continue;
            }

            if (!isset($segments[$idx])) {
                array_push($segments, ['', '']);
            }

            if ($s === '=') {
                $idx2++;
                continue;
            }

            $segments[$idx][$idx2] .= $s;
        }

        return $segments;
    }
}
