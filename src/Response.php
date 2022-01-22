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

/** It represents a server response. */
final class Response
{
    private string $status = '';

    /**
     * @var array<string>
     */
    private array $headers = [];

    public string $method = '';

    /** It adds or updates the HTTP status. */
    public function status(int $status_code): Response
    {
        $status_str = Status::text($status_code);
        if ($status_str !== '') {
            $this->status = "HTTP/1.1 $status_code $status_str";
        }

        return $this;
    }

    /** It adds or updates an HTTP header. Key is always converted to lowercase. */
    public function header(string $key, string $value): Response
    {
        $key = trim($key);
        if ($key !== '') {
            // TODO: Add only valid char keys
            $key                 = strtolower($key);
            $this->headers[$key] = trim($value);
        }

        return $this;
    }

    /** It sends an HTTP response in plain text format. */
    public function text(string $data): void
    {
        $this->header(Header::ContentType, 'text/plain;charset=utf-8');
        $this->output($data);
    }

    /** It sends an HTTP response in JSON format. */
    public function json(mixed $data, int $flags = 0, int $depth = 512): void
    {
        $this->header(Header::ContentType, 'application/json;charset=utf-8');
        // @phpstan-ignore-next-line
        $json = json_encode($data, $flags, $depth);
        if ($json !== false) {
            $this->output($json);
        }
    }

    /** It sends an HTTP response in XML format. */
    public function xml(string $data): void
    {
        $this->header(Header::ContentType, 'application/xml;charset=utf-8');
        $this->output($data);
    }

    /** It sends an HTTP response in HTML format. */
    public function html(string $data): void
    {
        $this->header(Header::ContentType, 'text/html;charset=utf-8');
        $this->output($data);
    }

    /** It redirects to a given URL. */
    public function redirect(string $url_to, int $redirect_status = Status::PermanentRedirect): void
    {
        $this->status($redirect_status);
        $this->header(Header::Location, $url_to);
        $this->header(Header::ContentLength, '0');
        $this->apply_status_headers();
    }

    /** It outputs the corresponding response using a given raw data. */
    private function output(string $data): void
    {
        $this->header(Header::ContentLength, (string) strlen($data));
        $this->apply_status_headers();
        if ($this->method != Method::HEAD) {
            echo $data;
        }
    }

    /** It applies the current HTTP status and the available headers. */
    private function apply_status_headers(): void
    {
        // Apply HTTP status
        if ($this->status === '') {
            $this->status(Status::OK);
        }
        header($this->status);
        $this->status = '';

        // Apply HTTP common/custom headers
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        $this->headers = [];
    }
}
