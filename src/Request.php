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

/** It represents a client request. */
class Request
{
    private string $proto        = 'HTTP/1.1';
    private string $content_type = '';
    private string $raw_data     = '';

    /** @var array<string> */
    private array $headers       = [];

    /**
     * @param array<string> $path
     * @param array<string> $query
     */
    public function __construct(
        private string $uri,
        private string $method,
        private array $path,
        private array $query,
    ) {
        $this->proto        = $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.1';
        $this->content_type = trim($_SERVER['HTTP_CONTENT_TYPE'] ?? '');

        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) === 'HTTP_') {
                $this->headers[str_replace(' ', '-', strtolower(str_replace('_', ' ', substr($name, 5))))] = $value;
            }
        }

        if (
            $method === Method::POST
            || $method === Method::PUT
            || $method === Method::DELETE
        ) {
            $input          = file_get_contents('php://input');
            $this->raw_data = $input === false ? '' : $input;
        }
    }

    /**
     * It gets all the request headers. Header list keys are always in lowercase.
     *
     * @return array<string>
     */
    public function headers(): array
    {
        return $this->headers;
    }

    /**
     * It gets a single header value by key. Empty string returned when not found. Header list keys are always in lowercase.
     */
    public function header(string $key): string
    {
        return $key === '' ? '' : $this->headers[$key] ?? '';
    }

    /** It gets the request protocol and version. */
    public function proto(): string
    {
        return $this->proto;
    }

    /** It gets the request uri. */
    public function uri(): string
    {
        return $this->uri;
    }

    /** It gets the request method. */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * It gets the request uri converted into an array without slash separators.
     *
     * @return array<string>
     */
    public function path(): array
    {
        return $this->path;
    }

    /**
     * It gets the request query converted into an array without ampersand separators.
     *
     * @return array<string>
     */
    public function query(): array
    {
        return $this->query;
    }

    /** It gets the request body data in its raw format. */
    public function raw(): string
    {
        return $this->raw_data;
    }

    /**
     * It gets the body data of a `multipart/form-data` content type request.
     *
     * @return array<string>
     */
    public function multipart(): array
    {
        $data = [];
        if ($this->method === Method::POST && str_starts_with($this->content_type, 'multipart/form-data')) {
            /* @phpstan-ignore-next-line */
            $data = $_POST;
        }

        return $data;
    }

    /**
     * It gets the body data of a `x-www-form-urlencoded` content type request.
     *
     * @return array<int|string, array<int, string>|string>
     */
    public function urlencoded(): array
    {
        $data = [];
        if (str_starts_with($this->content_type, 'application/x-www-form-urlencoded')) {
            parse_str($this->raw_data, $data);
        }

        return $data;
    }

    /** It gets the body data of a `xml` content type request. */
    public function xml(): \SimpleXMLElement|null
    {
        $xml = null;
        if (str_starts_with($this->content_type, 'application/xml')) {
            $r = simplexml_load_string($this->raw_data);
            if ($r instanceof \SimpleXMLElement) {
                $xml = $r;
            }
        }

        return $xml;
    }

    /** It gets the body data of a `json` content type request. */
    public function json(): mixed
    {
        $json = null;
        if (str_starts_with($this->content_type, 'application/json')) {
            $json = json_decode($this->raw_data, true);
        }

        return $json;
    }
}
