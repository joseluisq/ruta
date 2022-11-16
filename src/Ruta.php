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
     * It handles HTTP `GET` method requests.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function get(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_delegate_route($path, [Method::GET], $class_method_or_func, $data);
    }

    /**
     * It handles HTTP `HEAD` method requests.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function head(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_delegate_route($path, [Method::HEAD], $class_method_or_func, $data);
    }

    /**
     * It handles HTTP `POST` method requests.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function post(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_delegate_route($path, [Method::POST], $class_method_or_func, $data);
    }

    /**
     * It handles HTTP `PUT` method requests.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function put(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_delegate_route($path, [Method::PUT], $class_method_or_func, $data);
    }

    /**
     * It handles HTTP `DELETE` method requests.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function delete(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_delegate_route($path, [Method::DELETE], $class_method_or_func, $data);
    }

    /**
     * It handles HTTP `CONNECT` method requests.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function connect(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_delegate_route($path, [Method::CONNECT], $class_method_or_func, $data);
    }

    /**
     * It handles HTTP `OPTIONS` method requests.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function options(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_delegate_route($path, [Method::OPTIONS], $class_method_or_func, $data);
    }

    /**
     * It handles HTTP `TRACE` method requests.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function trace(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_delegate_route($path, [Method::TRACE], $class_method_or_func, $data);
    }

    /**
     * It handles HTTP `PATCH` method requests.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function patch(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_delegate_route($path, [Method::PATCH], $class_method_or_func, $data);
    }

    /**
     * It handles requests based a set of standard HTTP methods.
     *
     * @param array<string>          $methods              Array of standard HTTP methods
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function some(string $path, array $methods, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_delegate_route($path, $methods, $class_method_or_func, $data);
    }

    /**
     * It handles requests for any standard HTTP method.
     *
     * @param string                 $path                 URI
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function any(string $path, callable|array $class_method_or_func, array $data = []): void
    {
        self::match_delegate_route(
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
        self::$not_found_func     = $class_method_or_func;
        self::$data               = $data;
    }

    /**
     * Middleware that handles any valid HTTP request **before** to route delegation.
     *
     * @param callable|array<string> $class_method_or_func Class method string array or callable
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    public static function before(callable|array $class_method_or_func, array $data = []): void
    {
        self::match_delegate_route(
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
