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
    use RutaTrait;

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
     * @param array<string>          $methods              Array of valid HTTP methods
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function some(string $path, array $methods, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_route_delegate($path, $methods, $class_method_or_func, $data);
    }

    /**
     * It handles requests for any valid HTTP method.
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
     * Middleware that handles any valid HTTP request **before** to route delegation.
     *
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function before(callable|array $class_method_or_func, array $data = []): void
    {
        self::match_route_delegate(
            '',
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
            true,
        );
    }
}
