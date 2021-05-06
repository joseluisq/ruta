<?php

class Request {
}
class Response {
}

/** A multi purpose (HTTP/CLI) route functionality for PHP. */
class Ruta
{
    private static $ruta;
    private static string $uri = '';
    private static string $req_method = '';
    private static array $req_path = [];
    private static array $req_query = [];

    /** It handles `GET` requests. */
    public static function get(string $path, callable|array $class_method_or_func) {
        self::match_req_route_delegate($path, 'GET', $class_method_or_func);
    }

    /** It handles `HEAD` requests. */
    public static function head(string $path, callable|array $class_method_or_func) {
        self::match_req_route_delegate($path, 'HEAD', $class_method_or_func);
    }

    /** It handles `POST` requests. */
    public static function post(string $path, callable|array $class_method_or_func) {
        self::match_req_route_delegate($path, 'POST', $class_method_or_func);
    }

    /** It handles `PUT` requests. */
    public static function put(string $path, callable|array $class_method_or_func) {
        self::match_req_route_delegate($path, 'PUT', $class_method_or_func);
    }

    /** It handles `DELETE` requests. */
    public static function delete(string $path, callable|array $class_method_or_func) {
        self::match_req_route_delegate($path, 'DELETE', $class_method_or_func);
    }

    /** It handles `CONNECT` requests. */
    public static function connect(string $path, callable|array $class_method_or_func) {
        self::match_req_route_delegate($path, 'CONNECT', $class_method_or_func);
    }

    /** It handles `OPTIONS` requests. */
    public static function options(string $path, callable|array $class_method_or_func) {
        self::match_req_route_delegate($path, 'OPTIONS', $class_method_or_func);
    }

    /** It handles `TRACE` requests. */
    public static function trace(string $path, callable|array $class_method_or_func) {
        self::match_req_route_delegate($path, 'TRACE', $class_method_or_func);
    }

    private function __construct() {}

    /** Create a new singleton instance of `Ruta`. */
    private static function new(string $request_uri = '', string $request_method = '') {
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
        self::$req_path = self::parse_req_path($uri);
        self::$req_query = self::parse_req_query($uri);
        self::$req_method = $method;
        if (self::$ruta) {
            return self::$ruta;
        }
        self::$ruta = new Ruta();
        return self::$ruta;
    }

    private static function match_req_route_delegate(string $path, string $method, callable|array $class_method_or_func) {
        if (is_null(self::$ruta)) {
            self::new();
        }
        if (self::$req_method !== $method) {
            return;
        }
        list($match, $args) = self::match_req_path_query($path);
        if (!$match) {
            return;
        }
        if (is_array($class_method_or_func)) {
            if (!count($class_method_or_func) === 2) {
                throw new InvalidArgumentException('Provided value is not a valid class and method pair.');
            }
            list($class_name, $method) = $class_method_or_func;
            $class_method = [new $class_name(), $method];
            if (is_callable($class_method, false)) {
                call_user_func_array($class_method, [new Request(), new Response(), $args]);
                return;
            }
            throw new InvalidArgumentException('Provided class is not defined or its method is not callable.');
        }
        $class_method_or_func(new Request(), new Response(), $args);
    }

    private static function match_req_path_query(string $path) {
        $match = true;
        $args = [];
        $segs = self::parse_req_path($path);
        $segs_count = count($segs);
        $has_placeholder = false;
        // TODO: check also query
        for ($i = 0; $i < $segs_count; $i++) {
            if (!isset(self::$req_path[$i])) {
                $match = false;
                break;
            }
            $seg_in = self::$req_path[$i];
            $seg = $segs[$i];
            if ($seg !== $seg_in) {
                // If it contains a placeholder and it passes validation
                if (str_starts_with($seg, '{') && str_ends_with($seg, '}')) {
                    $key = trim(str_replace('}', '', str_replace('{', '', $seg)));
                    if (!empty($key)) {
                        $args[$key] = $seg_in;
                        $has_placeholder = true;
                        continue;
                    }
                }
                $match = false;
                break;
            }
        }
        if ($match && !$has_placeholder && $segs_count < count(self::$req_path)) {
            $match = false;
        }
        return [$match, $args];
    }

    private static function parse_req_path(string $path) {
        $path = trim(parse_url($path, PHP_URL_PATH));
        $segs = [];
        $j = 0;
        for ($i = 0; $i < strlen($path); $i++) {
            $s = $path[$i];
            if ($s === '/') {
                if ($i === 0) {
                    continue;
                }
                $j++;
                continue;
            }
            if (!isset($segs[$j])) {
                array_push($segs, '');
            }
            $segs[$j] .= $s;
        }
        return $segs;
    }

    private static function parse_req_query(string $query) {
        $query = trim(parse_url($query, PHP_URL_QUERY));
        $segs = [];
        $j = 0;
        $j2 = 0;
        for ($i = 0; $i < strlen($query); $i++) {
            $s = $query[$i];
            if ($s === '&') {
                $j2 = 0;
                if ($i === 0) {
                    continue;
                }
                $j++;
                continue;
            }
            if (!isset($segs[$j])) {
                array_push($segs, ['', '']);
            }
            if ($s === '=') {
                $j2++;
                continue;
            }
            $segs[$j][$j2] .= $s;
        }
        return $segs;
    }
}
