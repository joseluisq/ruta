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

trait RouteTrait
{
    private static Route|null $instance = null;

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
     * @var \Closure|array<string>|null
     */
    private static null|\Closure|array $not_found_func;

    private static bool $is_not_found = false;

    /** It creates a new singleton instance of `Route`. */
    private static function new(): Route
    {
        $uri    = urldecode($_SERVER['REQUEST_URI']);
        $method = trim($_SERVER['REQUEST_METHOD']);
        if ($uri === '') {
            throw new \InvalidArgumentException('The HTTP request uri is not provided.');
        }
        if ($method === '') {
            throw new \InvalidArgumentException('The HTTP request method is not provided.');
        }
        self::$uri    = $uri;
        self::$path   = RouteUtils::path_segments($uri);
        /* @phpstan-ignore-next-line */
        self::$query  = $_GET;
        self::$method = $method;
        if (self::$instance !== null) {
            return self::$instance;
        }
        self::$instance = new Route();

        return self::$instance;
    }

    /**
     * @param array<string>          $methods
     * @param callable|array<string> $class_method_or_func
     * @param array<string>          $data                 Additional data that will be passed to `$class_method_or_func`
     */
    private static function match_delegate_route(
        string $path,
        array $methods,
        callable|array $class_method_or_func,
        array $data = [],
        bool $is_middleware = false,
    ): void {
        // Path validation
        if (!$is_middleware) {
            $path = trim($path);
            if ($path === '') {
                throw new \InvalidArgumentException('The provided route path can not be empty.');
            }
            if (!str_starts_with($path, '/')) {
                throw new \InvalidArgumentException('The provided route path should start with a slash (/).');
            }
        }

        if (self::$instance === null) {
            self::new();
        }

        self::$data = $data;

        // Check for standard HTTP methods
        if (count($methods) === 0 || !in_array(self::$method, $methods, true)) {
            // TODO: maybe reply with a "405 Method Not Allowed"
            // but make sure to provide control for users
            self::$is_not_found = true;

            return;
        }

        // Match incoming path/query request
        $match = false;
        $args  = [];
        if (!$is_middleware) {
            $result               = RouteUtils::match_path_query($path, self::$path);
            $match                = $result[0];
            $args                 = $result[1];
            self::$is_not_found   = !$match;
            if (self::$is_not_found) {
                return;
            }
        }

        // Delegate class/method callable
        if (is_array($class_method_or_func)) {
            if (count($class_method_or_func) === 2) {
                list($class_name, $class_method) = $class_method_or_func;
                $class_obj                       = new $class_name();
                if (is_callable([$class_obj, $class_method])) {
                    self::call_class_method($class_obj, $class_method, $args, $is_middleware);

                    // If it was a middleware then just return which lets routes to continue
                    if ($is_middleware) {
                        return;
                    }

                    // Otherwise, when the route is found and delegated then just terminate the script
                    exit;
                }
                throw new \InvalidArgumentException('The provided class is not defined or its method is not callable.');
            }
            throw new \InvalidArgumentException('The provided array value is not a valid class/method pair.');
        }

        // Delegate function callable
        // @phpstan-ignore-next-line
        if (!is_callable($class_method_or_func)) {
            throw new \InvalidArgumentException('The provided function is not defined or not callable.');
        }

        // @phpstan-ignore-next-line
        self::call_func($class_method_or_func, $args, $is_middleware);

        // If it was a middleware then just return which lets routes to continue
        if ($is_middleware) {
            return;
        }

        // Otherwise, when the route is found and delegated then just terminate the script
        exit;
    }

    /**
     * @param array<string> $args
     */
    private static function call_class_method(
        object $class_obj,
        string $method,
        array $args = [],
        bool $is_middleware = false,
    ): void {
        $func              = new \ReflectionMethod($class_obj, $method);
        $method_args       = [];
        foreach ($func->getParameters() as $param) {
            $type = $param->getType();
            if ($type === null) {
                continue;
            }
            if ($type instanceof \ReflectionNamedType) {
                $type_name = $type->getName();
                if ($type_name === 'array') {
                    if ($is_middleware) {
                        $method_args[] = self::$data;
                    } else {
                        $method_args[] = match ($param->getName()) {
                            'args'  => $args,
                            'data'  => self::$data,
                            default => ['args' => $args, 'data' => self::$data],
                        };
                    }
                    continue;
                }
                if ($type_name === 'Ruta\Request' || get_parent_class($type_name) === 'Ruta\Request') {
                    $method_args[] = new $type_name(self::$uri, self::$method, self::$path, self::$query);
                    continue;
                }
                if ($type_name === 'Ruta\Response' || get_parent_class($type_name) === 'Ruta\Response') {
                    $method_args[] = new $type_name();
                    continue;
                }
            }
        }
        // Pass the data array to the 'route_data' property
        if (property_exists($class_obj, 'route_data')) {
            $class_obj->route_data = self::$data;
        }
        // @phpstan-ignore-next-line
        call_user_func_array([$class_obj, $method], $method_args);
    }

    /**
     * @param array<string> $args
     */
    private static function call_func(\Closure $user_func, array $args = [], bool $is_middleware = false): void
    {
        $func             = new \ReflectionFunction($user_func);
        $user_func_args   = [];
        $with_args        = false;
        foreach ($func->getParameters() as $param) {
            $type = $param->getType();
            if ($type === null) {
                continue;
            }
            if ($type instanceof \ReflectionNamedType) {
                $type_name = $type->getName();
                if ($type_name === 'array') {
                    if ($is_middleware) {
                        $user_func_args[] = self::$data;
                    } else {
                        $user_func_args[] = match ($param->getName()) {
                            'args'  => $args,
                            'data'  => self::$data,
                            default => ['args' => $args, 'data' => self::$data],
                        };
                    }
                    $with_args = true;
                    continue;
                }
                if ($type_name === 'Ruta\Request' || get_parent_class($type_name) === 'Ruta\Request') {
                    $user_func_args[] = new $type_name(self::$uri, self::$method, self::$path, self::$query);
                    continue;
                }
                if ($type_name === 'Ruta\Response' || get_parent_class($type_name) === 'Ruta\Response') {
                    $user_func_args[] = new $type_name();
                    continue;
                }
            }
        }
        if (!$with_args) {
            if ($is_middleware) {
                $user_func_args[] = self::$data;
            } else {
                $user_func_args[] = ['args' => $args, 'data' => self::$data];
            }
        }
        call_user_func_array($user_func, $user_func_args);
    }

    public function __destruct()
    {
        // If there is no a "404 not found" route defined then just return
        if (!self::$is_not_found) {
            return;
        }

        if (self::$not_found_func !== null) {
            // Delegate class/method callable
            if (is_array(self::$not_found_func)) {
                if (count(self::$not_found_func) === 2) {
                    list($class_name, $method) = self::$not_found_func;
                    $class_obj                 = new $class_name();

                    if (is_callable([$class_obj, $method])) {
                        // Pass also data array to 'route_data' property
                        if (property_exists($class_obj, 'route_data')) {
                            $class_obj->route_data = self::$data;
                        }

                        self::call_class_method($class_obj, $method, []);

                        // When method delegated then just terminate the script
                        exit;
                    }
                    throw new \InvalidArgumentException('Provided class is not defined or its method is not callable.');
                }
                throw new \InvalidArgumentException('Provided array value is not a valid class/method pair.');
            }

            // Delegate function callable
            if (is_callable(self::$not_found_func)) {
                self::call_func(self::$not_found_func, []);
                // When function delegated then just terminate the script
                exit;
            }
            throw new \InvalidArgumentException('The provided function is not defined or not callable.');
        }

        // Otherwise send default response
        (new Response())
            ->status(Status::NotFound)
            ->text(Status::text(Status::NotFound));
    }
}
