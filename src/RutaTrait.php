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

trait RutaTrait
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
        if (!$is_middleware) {
            $path = trim($path);
            if ($path === '') {
                throw new \InvalidArgumentException('Provided path can not be empty.');
            }
            if (!str_starts_with($path, '/')) {
                throw new \InvalidArgumentException('Provided path should start with a slash (/).');
            }
        }

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

        $match = false;
        $args  = [];
        if (!$is_middleware) {
            // Check incoming path/query
            $result               = RutaUtils::match_path_query($path, self::$path);
            $match                = $result[0];
            $args                 = $result[1];
            self::$is_not_found   = !$match;
            if (self::$is_not_found) {
                return;
            }
        }

        // Handle class/method callable
        if (is_array($class_method_or_func)) {
            if (count($class_method_or_func) === 2) {
                list($class_name, $class_method) = $class_method_or_func;
                $class_obj                       = new $class_name();
                if (is_callable([$class_obj, $class_method])) {
                    self::call_method_array($class_obj, $class_method, $args, $is_middleware);

                    // If was a middleware then just return.
                    if ($is_middleware) {
                        return;
                    }

                    // Otherwise exit the route when found and if its callback was delegated
                    exit;
                }
                throw new \InvalidArgumentException('Provided class is not defined or its method is not callable.');
            }
            throw new \InvalidArgumentException('Provided array value is not a valid class/method pair.');
        }

        // Handle function callable
        // @phpstan-ignore-next-line
        self::call_func_array($class_method_or_func, $args, $is_middleware);

        // If middleware then just return.
        // Otherwise exit the route when found and if its callback was delegated
        if ($is_middleware) {
            return;
        }

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
        self::$path   = RutaUtils::path_segments($uri);
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
    private static function call_method_array(
        object $class_obj,
        string $method,
        array $args = [],
        bool $is_middleware = false,
    ): void {
        $fn          = new \ReflectionMethod($class_obj, $method);
        $method_args = [];
        foreach ($fn->getParameters() as $param) {
            $t = $param->getType();
            if ($t === null) {
                continue;
            }
            if ($t instanceof \ReflectionNamedType) {
                $tname = $t->getName();
                if ($tname === 'array') {
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
                if ($tname === 'Ruta\Request' || get_parent_class($tname) === 'Ruta\Request') {
                    $method_args[] = new $tname(self::$uri, self::$method, self::$path, self::$query);
                    continue;
                }
                if ($tname === 'Ruta\Response' || get_parent_class($tname) === 'Ruta\Response') {
                    $method_args[] = new $tname();
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
    private static function call_func_array(\Closure $user_func, array $args = [], bool $is_middleware = false): void
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
                $tname = $t->getName();
                if ($tname === 'array') {
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
                if ($tname === 'Ruta\Request' || get_parent_class($tname) === 'Ruta\Request') {
                    $user_func_args[] = new $tname(self::$uri, self::$method, self::$path, self::$query);
                    continue;
                }
                if ($tname === 'Ruta\Response' || get_parent_class($tname) === 'Ruta\Response') {
                    $user_func_args[] = new $tname();
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
        // Handle 404 not found routes
        if (!self::$is_not_found) {
            return;
        }

        // Handle class/method callable
        if (is_array(self::$not_found_callable) && count(self::$not_found_callable) === 2) {
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

        // Handle function callable
        if (is_callable(self::$not_found_callable)) {
            // @phpstan-ignore-next-line
            self::call_func_array(self::$not_found_callable, []);

            return;
        }

        // Otherwise send default response
        (new Response())
            ->status(Status::NotFound)
            ->text(Status::text(Status::NotFound));
    }
}
