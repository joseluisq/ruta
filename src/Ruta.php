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

// It defines HTTP Status codes.
final class Status
{
    public const Continue           = 100; // RFC 7231, 6.2.1
    public const SwitchingProtocols = 101; // RFC 7231, 6.2.2
    public const Processing         = 102; // RFC 2518, 10.1
    public const EarlyHints         = 103; // RFC 8297

    public const OK                   = 200; // RFC 7231, 6.3.1
    public const Created              = 201; // RFC 7231, 6.3.2
    public const Accepted             = 202; // RFC 7231, 6.3.3
    public const NonAuthoritativeInfo = 203; // RFC 7231, 6.3.4
    public const NoContent            = 204; // RFC 7231, 6.3.5
    public const ResetContent         = 205; // RFC 7231, 6.3.6
    public const PartialContent       = 206; // RFC 7233, 4.1
    public const MultiStatus          = 207; // RFC 4918, 11.1
    public const AlreadyReported      = 208; // RFC 5842, 7.1
    public const IMUsed               = 226; // RFC 3229, 10.4.1

    public const MultipleChoices   = 300; // RFC 7231, 6.4.1
    public const MovedPermanently  = 301; // RFC 7231, 6.4.2
    public const Found             = 302; // RFC 7231, 6.4.3
    public const SeeOther          = 303; // RFC 7231, 6.4.4
    public const NotModified       = 304; // RFC 7232, 4.1
    public const UseProxy          = 305; // RFC 7231, 6.4.5
    public const _                 = 306; // RFC 7231, 6.4.6 (Unused)
    public const TemporaryRedirect = 307; // RFC 7231, 6.4.7
    public const PermanentRedirect = 308; // RFC 7538, 3

    public const BadRequest                   = 400; // RFC 7231, 6.5.1
    public const Unauthorized                 = 401; // RFC 7235, 3.1
    public const PaymentRequired              = 402; // RFC 7231, 6.5.2
    public const Forbidden                    = 403; // RFC 7231, 6.5.3
    public const NotFound                     = 404; // RFC 7231, 6.5.4
    public const MethodNotAllowed             = 405; // RFC 7231, 6.5.5
    public const NotAcceptable                = 406; // RFC 7231, 6.5.6
    public const ProxyAuthRequired            = 407; // RFC 7235, 3.2
    public const RequestTimeout               = 408; // RFC 7231, 6.5.7
    public const Conflict                     = 409; // RFC 7231, 6.5.8
    public const Gone                         = 410; // RFC 7231, 6.5.9
    public const LengthRequired               = 411; // RFC 7231, 6.5.10
    public const PreconditionFailed           = 412; // RFC 7232, 4.2
    public const RequestEntityTooLarge        = 413; // RFC 7231, 6.5.11
    public const RequestURITooLong            = 414; // RFC 7231, 6.5.12
    public const UnsupportedMediaType         = 415; // RFC 7231, 6.5.13
    public const RequestedRangeNotSatisfiable = 416; // RFC 7233, 4.4
    public const ExpectationFailed            = 417; // RFC 7231, 6.5.14
    public const Teapot                       = 418; // RFC 7168, 2.3.3
    public const MisdirectedRequest           = 421; // RFC 7540, 9.1.2
    public const UnprocessableEntity          = 422; // RFC 4918, 11.2
    public const Locked                       = 423; // RFC 4918, 11.3
    public const FailedDependency             = 424; // RFC 4918, 11.4
    public const TooEarly                     = 425; // RFC 8470, 5.2.
    public const UpgradeRequired              = 426; // RFC 7231, 6.5.15
    public const PreconditionRequired         = 428; // RFC 6585, 3
    public const TooManyRequests              = 429; // RFC 6585, 4
    public const RequestHeaderFieldsTooLarge  = 431; // RFC 6585, 5
    public const UnavailableForLegalReasons   = 451; // RFC 7725, 3

    public const InternalServerError           = 500; // RFC 7231, 6.6.1
    public const NotImplemented                = 501; // RFC 7231, 6.6.2
    public const BadGateway                    = 502; // RFC 7231, 6.6.3
    public const ServiceUnavailable            = 503; // RFC 7231, 6.6.4
    public const GatewayTimeout                = 504; // RFC 7231, 6.6.5
    public const HTTPVersionNotSupported       = 505; // RFC 7231, 6.6.6
    public const VariantAlsoNegotiates         = 506; // RFC 2295, 8.1
    public const InsufficientStorage           = 507; // RFC 4918, 11.5
    public const LoopDetected                  = 508; // RFC 5842, 7.2
    public const NotExtended                   = 510; // RFC 2774, 7
    public const NetworkAuthenticationRequired = 511; // RFC 6585, 6

    private const STATUS_MAP = [
        Status::Continue           => 'Continue',
        Status::SwitchingProtocols => 'Switching Protocols',
        Status::Processing         => 'Processing',
        Status::EarlyHints         => 'Early Hints',

        Status::OK                   => 'OK',
        Status::Created              => 'Created',
        Status::Accepted             => 'Accepted',
        Status::NonAuthoritativeInfo => 'Non-Authoritative Information',
        Status::NoContent            => 'No Content',
        Status::ResetContent         => 'Reset Content',
        Status::PartialContent       => 'Partial Content',
        Status::MultiStatus          => 'Multi-Status',
        Status::AlreadyReported      => 'Already Reported',
        Status::IMUsed               => 'IM Used',

        Status::MultipleChoices   => 'Multiple Choices',
        Status::MovedPermanently  => 'Moved Permanently',
        Status::Found             => 'Found',
        Status::SeeOther          => 'See Other',
        Status::NotModified       => 'Not Modified',
        Status::UseProxy          => 'Use Proxy',
        Status::TemporaryRedirect => 'Temporary Redirect',
        Status::PermanentRedirect => 'Permanent Redirect',

        Status::BadRequest                   => 'Bad Request',
        Status::Unauthorized                 => 'Unauthorized',
        Status::PaymentRequired              => 'Payment Required',
        Status::Forbidden                    => 'Forbidden',
        Status::NotFound                     => 'Not Found',
        Status::MethodNotAllowed             => 'Method Not Allowed',
        Status::NotAcceptable                => 'Not Acceptable',
        Status::ProxyAuthRequired            => 'Proxy Authentication Required',
        Status::RequestTimeout               => 'Request Timeout',
        Status::Conflict                     => 'Conflict',
        Status::Gone                         => 'Gone',
        Status::LengthRequired               => 'Length Required',
        Status::PreconditionFailed           => 'Precondition Failed',
        Status::RequestEntityTooLarge        => 'Request Entity Too Large',
        Status::RequestURITooLong            => 'Request URI Too Long',
        Status::UnsupportedMediaType         => 'Unsupported Media Type',
        Status::RequestedRangeNotSatisfiable => 'Requested Range Not Satisfiable',
        Status::ExpectationFailed            => 'Expectation Failed',
        Status::Teapot                       => 'I\'m a teapot',
        Status::MisdirectedRequest           => 'Misdirected Request',
        Status::UnprocessableEntity          => 'Unprocessable Entity',
        Status::Locked                       => 'Locked',
        Status::FailedDependency             => 'Failed Dependency',
        Status::TooEarly                     => 'Too Early',
        Status::UpgradeRequired              => 'Upgrade Required',
        Status::PreconditionRequired         => 'Precondition Required',
        Status::TooManyRequests              => 'Too Many Requests',
        Status::RequestHeaderFieldsTooLarge  => 'Request Header Fields Too Large',
        Status::UnavailableForLegalReasons   => 'Unavailable For Legal Reasons',

        Status::InternalServerError           => 'Internal Server Error',
        Status::NotImplemented                => 'Not Implemented',
        Status::BadGateway                    => 'Bad Gateway',
        Status::ServiceUnavailable            => 'Service Unavailable',
        Status::GatewayTimeout                => 'Gateway Timeout',
        Status::HTTPVersionNotSupported       => 'HTTP Version Not Supported',
        Status::VariantAlsoNegotiates         => 'Variant Also Negotiates',
        Status::InsufficientStorage           => 'Insufficient Storage',
        Status::LoopDetected                  => 'Loop Detected',
        Status::NotExtended                   => 'Not Extended',
        Status::NetworkAuthenticationRequired => 'Network Authentication Required',
    ];

    // It returns a text for the HTTP status code.
    // An empty string is returned if the code is unknown.
    public static function text(int $status_code): string
    {
        return self::STATUS_MAP[$status_code] ?? '';
    }
}

// It defines HTTP request methods.
final class Method
{
    public const GET     = 'GET';
    public const HEAD    = 'HEAD';
    public const POST    = 'POST';
    public const PUT     = 'PUT';
    public const DELETE  = 'DELETE';
    public const CONNECT = 'CONNECT';
    public const OPTIONS = 'OPTIONS';
    public const TRACE   = 'TRACE';
}

// It defines an HTTP Header map.
final class Header
{
    public const Accept                          = 'accept';
    public const AcceptCharset                   = 'accept-charset';
    public const AcceptEncoding                  = 'accept-encoding';
    public const AcceptLanguage                  = 'accept-language';
    public const AcceptRanges                    = 'accept-ranges';
    public const AccessControlAllowCredentials   = 'access-control-allow-credentials';
    public const AccessControlAllowHeaders       = 'access-control-allow-headers';
    public const AccessControlAllowMethods       = 'access-control-allow-methods';
    public const AccessControlAllowOrigin        = 'access-control-allow-origin';
    public const AccessControlExposeHeaders      = 'access-control-expose-headers';
    public const AccessControlMaxAge             = 'access-control-max-age';
    public const AccessControlRequestHeaders     = 'access-control-request-headers';
    public const AccessControlRequestMethod      = 'access-control-request-method';
    public const Age                             = 'age';
    public const Allow                           = 'allow';
    public const Altsvc                          = 'alt-svc';
    public const Authorization                   = 'authorization';
    public const CacheControl                    = 'cache-control';
    public const Connection                      = 'connection';
    public const ContentDisposition              = 'content-disposition';
    public const ContentEncoding                 = 'content-encoding';
    public const ContentLanguage                 = 'content-language';
    public const ContentLength                   = 'content-length';
    public const ContentLocation                 = 'content-location';
    public const ContentRange                    = 'content-range';
    public const ContentSecurityPolicy           = 'content-security-policy';
    public const ContentSecurityPolicyReportOnly = 'content-security-policy-report-only';
    public const ContentType                     = 'content-type';
    public const Cookie                          = 'cookie';
    public const Dnt                             = 'dnt';
    public const Date                            = 'date';
    public const Etag                            = 'etag';
    public const Expect                          = 'expect';
    public const Expires                         = 'expires';
    public const Forwarded                       = 'forwarded';
    public const From                            = 'from';
    public const Host                            = 'host';
    public const IfMatch                         = 'if-match';
    public const IfModifiedSince                 = 'if-modified-since';
    public const IfNoneMatch                     = 'if-none-match';
    public const IfRange                         = 'if-range';
    public const IfUnmodifiedSince               = 'if-unmodified-since';
    public const LastModified                    = 'last-modified';
    public const Link                            = 'link';
    public const Location                        = 'location';
    public const MaxForwards                     = 'max-forwards';
    public const Origin                          = 'origin';
    public const Pragma                          = 'pragma';
    public const ProxyAuthenticate               = 'proxy-authenticate';
    public const ProxyAuthorization              = 'proxy-authorization';
    public const PublicKeyPins                   = 'public-key-pins';
    public const PublicKeyPinsReportOnly         = 'public-key-pins-report-only';
    public const Range                           = 'range';
    public const Referer                         = 'referer';
    public const ReferrerPolicy                  = 'referrer-policy';
    public const Refresh                         = 'refresh';
    public const RetryAfter                      = 'retry-after';
    public const SecWebsocketAccept              = 'sec-websocket-accept';
    public const SecWebsocketExtensions          = 'sec-websocket-extensions';
    public const SecWebsocketKey                 = 'sec-websocket-key';
    public const SecWebsocketProtocol            = 'sec-websocket-protocol';
    public const SecWebsocketVersion             = 'sec-websocket-version';
    public const Server                          = 'server';
    public const SetCookie                       = 'set-cookie';
    public const StrictTransportSecurity         = 'strict-transport-security';
    public const Te                              = 'te';
    public const Trailer                         = 'trailer';
    public const TransferEncoding                = 'transfer-encoding';
    public const Upgrade                         = 'upgrade';
    public const UpgradeInsecureRequests         = 'upgrade-insecure-requests';
    public const UserAgent                       = 'user-agent';
    public const Vary                            = 'vary';
    public const Via                             = 'via';
    public const Warning                         = 'warning';
    public const WwwAuthenticate                 = 'www-authenticate';
    public const XContentTypeOptions             = 'x-content-type-options';
    public const XDNSPrefetchControl             = 'x-dns-prefetch-control';
    public const XFrameOptions                   = 'x-frame-options';
    public const XXSSProtection                  = 'x-xss-protection';
}

// It represents a client request.
final class Request
{
    private string $proto        = '';

    /**
     * @var array<string>
     */
    private array $headers       = [];

    private string $content_type = '';
    private string $raw_data     = '';

    /**
     * @param string        $uri
     * @param string        $method
     * @param array<string> $path
     * @param array<string> $query
     */
    public function __construct(
        private string $uri = '',
        private string $method = '',
        private array $path = [],
        private array $query = [],
    ) {
        $this->proto        = $_SERVER['SERVER_PROTOCOL'] ?? '';
        $this->content_type = trim($_SERVER['HTTP_CONTENT_TYPE'] ?? '');

        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) === 'HTTP_') {
                $this->headers[str_replace(' ', '-', strtolower(str_replace('_', ' ', substr($name, 5))))] = $value;
            }
        }

        switch ($method) {
            case Method::POST:
            case Method::PUT:
            case Method::DELETE:
                $this->raw_data = file_get_contents('php://input');
                break;
        }
    }

    /**
     * It gets all the request headers.
     *
     * @return array<string>
     */
    public function headers(): array
    {
        return $this->headers;
    }

    /** It gets a single header value by key. It returns an empty string when not found. */
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
        if (str_starts_with($this->content_type, 'multipart/form-data') && $this->method === Method::POST) {
            $data = $_POST;
        }

        return $data;
    }

    /**
     * It gets the body data of a `x-www-form-urlencoded` content type request.
     *
     * @return array<string>
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
            $xml = simplexml_load_string($this->raw_data) ?: null;
        }

        return $xml;
    }

    /** It gets the body data of a `json` content type request.
     *
     * @return string|array<string>|null
     */
    public function json(): string|array|null
    {
        $json = null;
        if (str_starts_with($this->content_type, 'application/json')) {
            $json = json_decode($this->raw_data, true);
        }

        return $json;
    }
}

// It represents a server response.
final class Response
{
    private string $status = '';

    /**
     * @var array<string>
     */
    private array $headers = [];

    public string $method = '';

    /** It adds or updates the HTTP status. */
    public function status(int $status_code = Status::OK): Response
    {
        $status_str = Status::text($status_code);
        if (!empty($status_str)) {
            $this->status = "HTTP/1.1 $status_code $status_str";
        }

        return $this;
    }

    /** It adds or updates an HTTP header. */
    public function header(string $key, string $value): Response
    {
        $key = trim($key);
        if (!empty($key)) {
            // TODO: Add only valid char keys
            $key                 = strtolower($key);
            $this->headers[$key] = trim($value);
        }

        return $this;
    }

    /** It outputs an HTTP response in plain text format. */
    public function text(string $data): void
    {
        $this->header(Header::ContentType, 'text/plain;charset=utf-8');
        $this->output($data);
    }

    /** It outputs an HTTP response in JSON format. */
    public function json(mixed $data, int $flags = 0, int $depth = 512): void
    {
        $this->header(Header::ContentType, 'application/json;charset=utf-8');
        $this->output(json_encode($data, $flags, $depth));
    }

    /** It outputs an HTTP response in XML format. */
    public function xml(string $data): void
    {
        $this->header(Header::ContentType, 'application/xml;charset=utf-8');
        $this->output($data);
    }

    /** It outputs an HTTP response in HTML format. */
    public function html(string $data): void
    {
        $this->header(Header::ContentType, 'text/html;charset=utf-8');
        $this->output($data);
    }

    /** It redirects to a given URL. */
    public function redirect(string $url, int $redirect_status = Status::PermanentRedirect): void
    {
        $this->status($redirect_status);
        $this->header(Header::Location, $url);
        $this->header(Header::ContentLength, '0');
        $this->apply_status_headers();
    }

    /** It outputs the corresponding response using a given raw data. */
    private function output(string $data)
    {
        $this->header(Header::ContentLength, (string) strlen($data));
        $this->apply_status_headers();
        if ($this->method != Method::HEAD) {
            echo $data;
        }
    }

    /** It creates a response that forces to download the file at a given path. */
    public function download(string $base_path, string $file_path, string $name = ''): void
    {
        $file_path = self::sanitize_path($base_path, $file_path);
        if (empty($file_path)) {
            $this->status(Status::NotFound);
            $this->apply_status_headers();

            return;
        }
        if (is_file($file_path)) {
            $this->status();
            $this->header(Header::ContentType, self::guess_mime_type($file_path));
            $filename = empty($name) ? basename($file_path) : $name;
            $this->header(Header::ContentDisposition, 'attachment; filename="' . $filename . '"');
            $this->header(Header::Expires, '0');
            $this->header(Header::CacheControl, 'must-revalidate');
            $this->header(Header::Pragma, 'public');
            $this->header(Header::ContentLength, (string) filesize($file_path) ?: 0);
            $this->apply_status_headers();
            if ($this->method != Method::HEAD) {
                readfile($file_path);
            }

            return;
        }
        // Otherwise respond with a 404
        $this->status(Status::NotFound);
        $this->apply_status_headers();
    }

    /** It creates a response that serves a file at a given path. */
    public function file(string $base_path, string $file_path): void
    {
        $file_path = self::sanitize_path($base_path, $file_path);
        if (empty($file_path)) {
            $this->status(Status::NotFound);
            $this->apply_status_headers();

            return;
        }
        if (is_file($file_path)) {
            $this->header(Header::ContentType, self::guess_mime_type($file_path));
            // TODO: we want to have more flexibility over these cache-control headers
            $this->header(Header::CacheControl, 'public, max-age=0');
            $this->header(Header::ContentLength, (string) filesize($file_path) ?: 0);
            $this->apply_status_headers();
            if ($this->method != Method::HEAD) {
                readfile($file_path);
            }

            return;
        }
        // Otherwise respond with a 404
        $this->status(Status::NotFound);
        $this->apply_status_headers();
    }

    /** It applies the current HTTP status and the available headers. */
    private function apply_status_headers(): void
    {
        // Apply HTTP status
        if (empty($this->status)) {
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

    /** It sanitizes a specific file path protecting it against path/directory traversal. */
    private static function sanitize_path(string $base_path, string $file_path): string|null
    {
        $path = [];
        $segs = explode('/', urldecode(trim($file_path)));
        foreach ($segs as $seg) {
            if (str_starts_with($seg, '..')) {
                // Rejecting segment starting with '..'
                return null;
            } elseif (str_starts_with($seg, '\\')) {
                // Rejecting segment containing with backslash (\\)
                return null;
            } else {
                array_push($path, $seg);
            }
        }

        return "$base_path/" . implode('/', $path);
    }

    /** It guesses the mime type of an existing file or returns a default `application/octet-stream` instead. */
    private static function guess_mime_type(string $file_path): string
    {
        return mime_content_type($file_path) ?: 'application/octet-stream';
    }
}

/** A lightweight and multi purpose HTTP routing library for PHP. */
final class Ruta
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
     * @var \Closure|array<string>
     */
    private static \Closure|array $not_found_class_method_or_func;

    private static bool $is_not_found = false;

    /**
     * It handles `GET` requests.
     *
     * @param callable|array<string> $class_method_or_func
     */
    public static function get(string $path, callable|array $class_method_or_func): void
    {
        self::match_route_delegate($path, Method::GET, $class_method_or_func);
    }

    /**
     * It handles `HEAD` requests.
     *
     * @param callable|array<string> $class_method_or_func
     */
    public static function head(string $path, callable|array $class_method_or_func): void
    {
        self::match_route_delegate($path, Method::HEAD, $class_method_or_func);
    }

    /**
     * It handles `POST` requests.
     *
     * @param callable|array<string> $class_method_or_func
     */
    public static function post(string $path, callable|array $class_method_or_func): void
    {
        self::match_route_delegate($path, Method::POST, $class_method_or_func);
    }

    /**
     * It handles `PUT` requests.
     *
     * @param callable|array<string> $class_method_or_func
     */
    public static function put(string $path, callable|array $class_method_or_func): void
    {
        self::match_route_delegate($path, Method::PUT, $class_method_or_func);
    }

    /**
     * It handles `DELETE` requests.
     *
     * @param callable|array<string> $class_method_or_func
     */
    public static function delete(string $path, callable|array $class_method_or_func): void
    {
        self::match_route_delegate($path, 'DELETE', $class_method_or_func);
    }

    /**
     * It handles `CONNECT` requests.
     *
     * @param callable|array<string> $class_method_or_func
     */
    public static function connect(string $path, callable|array $class_method_or_func): void
    {
        self::match_route_delegate($path, Method::CONNECT, $class_method_or_func);
    }

    /**
     * It handles `OPTIONS` requests.
     *
     * @param callable|array<string> $class_method_or_func
     */
    public static function options(string $path, callable|array $class_method_or_func): void
    {
        self::match_route_delegate($path, Method::OPTIONS, $class_method_or_func);
    }

    /**
     * It handles `TRACE` requests.
     *
     * @param callable|array<string> $class_method_or_func
     */
    public static function trace(string $path, callable|array $class_method_or_func): void
    {
        self::match_route_delegate($path, Method::TRACE, $class_method_or_func);
    }

    /**
     * It handles 404 not found routes.
     *
     * @param callable|array<string> $class_method_or_func
     */
    public static function not_found(callable|array $class_method_or_func): void
    {
        self::$not_found_class_method_or_func = $class_method_or_func;
    }

    /** Create a new singleton instance of `Ruta`. */
    public static function new(string $request_uri = '', string $request_method = ''): Ruta
    {
        if (empty($request_uri) && array_key_exists('REQUEST_URI', $_SERVER)) {
            $request_uri = $_SERVER['REQUEST_URI'];
        }
        if (empty($request_method) && array_key_exists('REQUEST_METHOD', $_SERVER)) {
            $request_method = $_SERVER['REQUEST_METHOD'];
        }
        $uri    = trim(urldecode($request_uri));
        $method = trim($request_method);
        if (empty($uri)) {
            throw new \InvalidArgumentException('HTTP request uri is not provided.');
        }
        if (empty($method)) {
            throw new \InvalidArgumentException('HTTP request method is not provided.');
        }
        self::$uri    = $uri;
        self::$path   = self::path_as_segments($uri);
        self::$query  = $_GET;
        self::$method = $method;
        if (self::$instance !== null) {
            return self::$instance;
        }
        $inst           = new Ruta();
        self::$instance = $inst;

        return $inst;
    }

    /**
     * @param callable|array<string> $class_method_or_func
     */
    private static function match_route_delegate(string $path, string $method, callable|array $class_method_or_func): void
    {
        if (self::$instance === null) {
            self::new();
        }
        if (self::$method !== $method) {
            // TODO: maybe reply with a "405 Method Not Allowed"
            // but make suer to provide control for users
            self::$is_not_found = true;

            return;
        }
        list($match, $args) = self::match_path_query($path);
        self::$is_not_found = !$match;
        if (!$match) {
            return;
        }

        // Handle class/method callable
        if (is_array($class_method_or_func)) {
            if (!count($class_method_or_func) === 2) {
                throw new \InvalidArgumentException('Provided value is not a valid class and method pair.');
            }
            list($class_name, $method) = $class_method_or_func;
            $class_obj                 = new $class_name();
            if (is_callable([$class_obj, $method], false)) {
                self::call_user_method_array($class_obj, $method, $args);
                // Terminate when route found and delegated
                exit;
            }
            throw new \InvalidArgumentException('Provided class is not defined or its method is not callable.');
        }

        // Handle function callable
        self::call_user_func_array($class_method_or_func, $args);
        // Terminate when route found and delegated
        exit;
    }

    /**
     * @param array<string> $args
     */
    private static function call_user_method_array(object $class_obj, string $method, array $args = []): void
    {
        $fn          = new \ReflectionMethod($class_obj, $method);
        $method_args = [];
        foreach ($fn->getParameters() as $param) {
            $t = $param->getType();
            if ($t === null) {
                continue;
            }
            if ($t instanceof \ReflectionNamedType) {
                switch ($t->getName()) {
                    case 'Ruta\Request':
                        $method_args[] = self::new_request();
                        break;
                    case 'Ruta\Response':
                        $method_args[] = self::new_response();
                        break;
                    case 'array':
                        $method_args[] = $args;
                        break;
                }
            }
        }
        call_user_func_array([$class_obj, $method], $method_args);
    }

    /**
     * @param array<string> $args
     */
    private static function call_user_func_array(callable $user_func, array $args = []): void
    {
        $fn             = new \ReflectionFunction($user_func);
        $user_func_args = [];
        foreach ($fn->getParameters() as $param) {
            $t = $param->getType();
            if ($t === null) {
                continue;
            }
            if ($t instanceof \ReflectionNamedType) {
                switch ($t->getName()) {
                    case 'Ruta\Request':
                        $user_func_args[] = self::new_request();
                        break;
                    case 'Ruta\Response':
                        $user_func_args[] = self::new_response();
                        break;
                    case 'array':
                        $user_func_args[] = $args;
                        break;
                }
            }
        }
        call_user_func_array($user_func, $user_func_args);
    }

    private static function new_request(): Request
    {
        return new Request(self::$uri, self::$method, self::$path, self::$query);
    }

    private static function new_response(): Response
    {
        return new Response(self::$method);
    }

    /**
     * @return array<array<string>>
     */
    private static function match_path_query(string $path): array
    {
        $match           = true;
        $args            = [];
        $segs_def        = self::path_as_segments($path);
        $segs_def_count  = count($segs_def);
        $has_placeholder = false;

        // TODO: check also query uri
        for ($i = 0; $i < $segs_def_count; $i++) {
            if (!array_key_exists($i, self::$path)) {
                $match = false;
                break;
            }
            $seg_in  = self::$path[$i];
            $seg_def = $segs_def[$i];
            if ($seg_def !== $seg_in) {
                // 1. placeholder
                if (str_starts_with($seg_def, '{') && str_ends_with($seg_def, '}')) {
                    $key = trim(substr(substr($seg_def, 0), 0, -1));
                    if (!empty($key)) {
                        $args[$key]      = $seg_in;
                        $has_placeholder = true;
                        continue;
                    }
                }
                $match = false;
                break;
            }
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
        $path    = trim(parse_url($path, PHP_URL_PATH));
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
        if (is_array(self::$not_found_class_method_or_func)) {
            // Handle class/method callable
            if (count(self::$not_found_class_method_or_func) !== 2) {
                throw new \InvalidArgumentException('Provided value is not a valid class and method pair.');
            }
            list($class_name, $method) = self::$not_found_class_method_or_func;
            $class_obj                 = new $class_name();
            if (is_callable([$class_obj, $method], false)) {
                self::call_user_method_array($class_obj, $method);

                return;
            }
            throw new \InvalidArgumentException('Provided class is not defined or its method is not callable.');
        } elseif (is_callable(self::$not_found_class_method_or_func)) {
            // Handle function callable
            self::call_user_func_array(self::$not_found_class_method_or_func);
        } else {
            $res = self::new_response();
            $res->status(Status::NotFound);
            $res->text(Status::text(Status::NotFound));
        }
    }
}
