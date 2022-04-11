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

/** A lightweight HTTP routing library for PHP. */
class Ruta
{
    private static Ruta|null $instance = null;

    private static string $uri    = '';
    private static string $method = '';

    /**
     * @var array<string>
     */
    private static array $path    = [];

    /**
     * @var array<string>
     */
    private static array $query   = [];

    /**
     * @var array<string>
     */
    private static array $data    = [];

    /**
     * @var \Closure|array<string>
     */
    private static \Closure|array $not_found_callable = [];

    private static bool $is_not_found = false;

    /**
     * It handles requests based on the HTTP `GET` method.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function get(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_route_delegate($path, [Method::GET], $class_method_or_func, $data);
    }

    /**
     * It handles requests based on the HTTP `HEAD` method.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function head(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_route_delegate($path, [Method::HEAD], $class_method_or_func, $data);
    }

    /**
     * It handles requests based on the HTTP `POST` method.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function post(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_route_delegate($path, [Method::POST], $class_method_or_func, $data);
    }

    /**
     * It handles requests based on the HTTP `PUT` method.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function put(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_route_delegate($path, [Method::PUT], $class_method_or_func, $data);
    }

    /**
     * It handles requests based on the HTTP `DELETE` method.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function delete(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_route_delegate($path, [Method::DELETE], $class_method_or_func, $data);
    }

    /**
     * It handles requests based on the HTTP `CONNECT` method.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function connect(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_route_delegate($path, [Method::CONNECT], $class_method_or_func, $data);
    }

    /**
     * It handles requests based on the HTTP `OPTIONS` method.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function options(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_route_delegate($path, [Method::OPTIONS], $class_method_or_func, $data);
    }

    /**
     * It handles requests based on the HTTP `TRACE` method.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function trace(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_route_delegate($path, [Method::TRACE], $class_method_or_func, $data);
    }

    /**
     * It handles requests based on the HTTP `PATCH` method.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function patch(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_route_delegate($path, [Method::PATCH], $class_method_or_func, $data);
    }

    /**
     * It handles requests based a set of valid HTTP methods.
     *
     * @param array<string>          $methods
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function some(string $path, array $methods, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_route_delegate($path, $methods, $class_method_or_func, $data);
    }

    /**
     * It handles requests based on all valid HTTP methods.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function any(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_route_delegate(
            $path,
            [
                Method::GET,
                Method::HEAD,
                Method::POST,
                Method::PUT,
                Method::DELETE,
                Method::CONNECT,
                Method::OPTIONS,
                Method::TRACE,
                Method::PATCH,
            ],
            $class_method_or_func,
            $data,
        );
    }

    /**
     * It handles all `404` not found routes.
     *
     * @param \Closure|array<string> $class_method_or_func
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function not_found(\Closure|array $class_method_or_func, array $data = []): void
    {
        self::$data               = $data;
        self::$not_found_callable = $class_method_or_func;
    }

    /**
     * @param array<string>          $methods
     * @param callable|array<string> $class_method_or_func
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    private static function match_route_delegate(string $path, array $methods, callable|array $class_method_or_func, array $data = []): void
    {
        if (self::$instance === null) {
            self::new();
        }
        self::$data = $data;
        if (count($methods) === 0 || !in_array(self::$method, $methods, true)) {
            // TODO: maybe reply with a "405 Method Not Allowed"
            // but make sure to provide control for users
            self::$is_not_found = true;

            return;
        }

        list($match, $args) = self::match_path_query($path);
        self::$is_not_found = !$match;
        if (self::$is_not_found) {
            return;
        }

        // Handle class/method callable
        if (is_array($class_method_or_func)) {
            if (count($class_method_or_func) === 2) {
                list($class_name, $class_method) = $class_method_or_func;
                $class_obj                       = new $class_name();
                if (is_callable([$class_obj, $class_method])) {
                    self::call_method_array($class_obj, $class_method, $args);
                    // Terminate when route found and delegated
                    exit;
                }
                throw new \InvalidArgumentException('Provided class is not defined or its method is not callable.');
            }
            throw new \InvalidArgumentException('Provided array value is not a valid class and method pair.');
        }

        // Handle function callable
        // @phpstan-ignore-next-line
        self::call_func_array($class_method_or_func, $args);
        // Terminate when route found and delegated
        exit;
    }

    /** It creates a new singleton instance of `Ruta`. */
    private static function new(): Ruta
    {
        $uri    = urldecode($_SERVER['REQUEST_URI']);
        $method = trim($_SERVER['REQUEST_METHOD']);
        if ($uri === '') {
            throw new \InvalidArgumentException('HTTP request uri is not provided.');
        }
        if ($method === '') {
            throw new \InvalidArgumentException('HTTP request method is not provided.');
        }
        self::$uri    = $uri;
        self::$path   = self::path_as_segments($uri);
        /* @phpstan-ignore-next-line */
        self::$query  = $_GET;
        self::$method = $method;
        if (self::$instance !== null) {
            return self::$instance;
        }
        self::$instance = new Ruta();

        return self::$instance;
    }

    /**
     * @param array<string> $args
     */
    private static function call_method_array(object $class_obj, string $method, array $args = []): void
    {
        $fn          = new \ReflectionMethod($class_obj, $method);
        $method_args = [];
        foreach ($fn->getParameters() as $param) {
            $t = $param->getType();
            if ($t === null) {
                continue;
            }
            if ($t instanceof \ReflectionNamedType) {
                $name = $t->getName();
                if ($name === 'array') {
                    $method_args[] = ['args' => $args, 'data' => self::$data];
                    continue;
                }
                if ($name === 'Ruta\Request' || get_parent_class($name) === 'Ruta\Request') {
                    $method_args[] = new $name(self::$uri, self::$method, self::$path, self::$query);
                    continue;
                }
                if ($name === 'Ruta\Response' || get_parent_class($name) === 'Ruta\Response') {
                    $method_args[] = new $name();
                    continue;
                }
            }
        }
        // Pass data array to 'route_data' property
        if (property_exists($class_obj, 'route_data')) {
            $class_obj->route_data = self::$data;
        }
        // @phpstan-ignore-next-line
        call_user_func_array([$class_obj, $method], $method_args);
    }

    /**
     * @param array<string> $args
     */
    private static function call_func_array(\Closure $user_func, array $args = []): void
    {
        $fn             = new \ReflectionFunction($user_func);
        $user_func_args = [];
        $with_args      = false;
        foreach ($fn->getParameters() as $param) {
            $t = $param->getType();
            if ($t === null) {
                continue;
            }
            if ($t instanceof \ReflectionNamedType) {
                $name = $t->getName();
                if ($name === 'array') {
                    $user_func_args[] = ['args' => $args, 'data' => self::$data];
                    $with_args        = true;
                    continue;
                }
                if ($name === 'Ruta\Request' || get_parent_class($name) === 'Ruta\Request') {
                    $user_func_args[] = new $name(self::$uri, self::$method, self::$path, self::$query);
                    continue;
                }
                if ($name === 'Ruta\Response' || get_parent_class($name) === 'Ruta\Response') {
                    $user_func_args[] = new $name();
                    continue;
                }
            }
        }
        if (!$with_args) {
            $user_func_args[] = ['args' => $args, 'data' => self::$data];
        }
        call_user_func_array($user_func, $user_func_args);
    }

    /**
     * @return array{0:bool,1:string[]}
     */
    private static function match_path_query(string $path): array
    {
        $match            = true;
        $args             = [];
        $segs_def         = self::path_as_segments($path);
        $segs_def_count   = count($segs_def);
        $has_placeholder  = false;

        // TODO: check also query uri
        for ($i = 0; $i < $segs_def_count; $i++) {
            // Safety check for "undefined array index"
            if (!array_key_exists($i, self::$path)) {
                $match = false;
                break;
            }

            $seg = $segs_def[$i];

            // 1. If current segment matches then just continue
            if ($seg === self::$path[$i]) {
                continue;
            }

            // 2. Otherwise proceed with the segment validation

            // 1. Placeholders
            if (str_starts_with($seg, '{') && str_ends_with($seg, '}')) {
                $key = substr(substr($seg, 1), 0, -1);
                if ($key !== '') {
                    $args[$key]      = self::$path[$i];
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

                        if (preg_match("/$regex/", self::$path[$i]) === 1) {
                            $args[$regex_key]      = self::$path[$i];
                            $has_placeholder       = true;
                            continue;
                        }
                    }
                }
            }

            $match = false;
            break;
        }

        if ($match && !$has_placeholder && $segs_def_count < count(self::$path)) {
            $match = false;
        }

        return [$match, $args];
    }

    /**
     * @return array<string>
     */
    private static function path_as_segments(string $path): array
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

    public function __destruct()
    {
        // Handle 404 not found routes
        if (!self::$is_not_found) {
            return;
        }

        // Handle class/method callable
        if (is_array(self::$not_found_callable)) {
            if (count(self::$not_found_callable) === 2) {
                list($class_name, $method) = self::$not_found_callable;
                $class_obj                 = new $class_name();
                if (is_callable([$class_obj, $method])) {
                    // Pass also data array to 'route_data' property
                    if (property_exists($class_obj, 'route_data')) {
                        $class_obj->route_data = self::$data;
                    }
                    self::call_method_array($class_obj, $method, []);

                    return;
                }
                throw new \InvalidArgumentException('Provided class is not defined or its method is not callable.');
            }
        }

        // Handle function callable
        if (is_callable(self::$not_found_callable)) {
            // @phpstan-ignore-next-line
            self::call_func_array(self::$not_found_callable, []);

            return;
        }

        // Otherwise send default response
        $res = new Response();
        $res->status(Status::NotFound);
        $res->text(Status::text(Status::NotFound));
    }
}
