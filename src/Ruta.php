<?php

// It defines HTTP Status codes.
class Status
{
    public const Continue = 100; // RFC 7231, 6.2.1
    public const SwitchingProtocols = 101; // RFC 7231, 6.2.2
    public const Processing = 102; // RFC 2518, 10.1
    public const EarlyHints = 103; // RFC 8297

    public const OK = 200; // RFC 7231, 6.3.1
    public const Created = 201; // RFC 7231, 6.3.2
    public const Accepted = 202; // RFC 7231, 6.3.3
    public const NonAuthoritativeInfo = 203; // RFC 7231, 6.3.4
    public const NoContent = 204; // RFC 7231, 6.3.5
    public const ResetContent = 205; // RFC 7231, 6.3.6
    public const PartialContent = 206; // RFC 7233, 4.1
    public const MultiStatus = 207; // RFC 4918, 11.1
    public const AlreadyReported = 208; // RFC 5842, 7.1
    public const IMUsed = 226; // RFC 3229, 10.4.1

    public const MultipleChoices = 300; // RFC 7231, 6.4.1
    public const MovedPermanently = 301; // RFC 7231, 6.4.2
    public const Found = 302; // RFC 7231, 6.4.3
    public const SeeOther = 303; // RFC 7231, 6.4.4
    public const NotModified = 304; // RFC 7232, 4.1
    public const UseProxy = 305; // RFC 7231, 6.4.5
    public const _ = 306; // RFC 7231, 6.4.6 (Unused)
    public const TemporaryRedirect = 307; // RFC 7231, 6.4.7
    public const PermanentRedirect = 308; // RFC 7538, 3

    public const BadRequest = 400; // RFC 7231, 6.5.1
    public const Unauthorized = 401; // RFC 7235, 3.1
    public const PaymentRequired = 402; // RFC 7231, 6.5.2
    public const Forbidden = 403; // RFC 7231, 6.5.3
    public const NotFound = 404; // RFC 7231, 6.5.4
    public const MethodNotAllowed = 405; // RFC 7231, 6.5.5
    public const NotAcceptable = 406; // RFC 7231, 6.5.6
    public const ProxyAuthRequired = 407; // RFC 7235, 3.2
    public const RequestTimeout = 408; // RFC 7231, 6.5.7
    public const Conflict = 409; // RFC 7231, 6.5.8
    public const Gone = 410; // RFC 7231, 6.5.9
    public const LengthRequired = 411; // RFC 7231, 6.5.10
    public const PreconditionFailed = 412; // RFC 7232, 4.2
    public const RequestEntityTooLarge = 413; // RFC 7231, 6.5.11
    public const RequestURITooLong = 414; // RFC 7231, 6.5.12
    public const UnsupportedMediaType = 415; // RFC 7231, 6.5.13
    public const RequestedRangeNotSatisfiable = 416; // RFC 7233, 4.4
    public const ExpectationFailed = 417; // RFC 7231, 6.5.14
    public const Teapot = 418; // RFC 7168, 2.3.3
    public const MisdirectedRequest = 421; // RFC 7540, 9.1.2
    public const UnprocessableEntity = 422; // RFC 4918, 11.2
    public const Locked = 423; // RFC 4918, 11.3
    public const FailedDependency = 424; // RFC 4918, 11.4
    public const TooEarly = 425; // RFC 8470, 5.2.
    public const UpgradeRequired = 426; // RFC 7231, 6.5.15
    public const PreconditionRequired = 428; // RFC 6585, 3
    public const TooManyRequests = 429; // RFC 6585, 4
    public const RequestHeaderFieldsTooLarge = 431; // RFC 6585, 5
    public const UnavailableForLegalReasons = 451; // RFC 7725, 3

    public const InternalServerError = 500; // RFC 7231, 6.6.1
    public const NotImplemented = 501; // RFC 7231, 6.6.2
    public const BadGateway = 502; // RFC 7231, 6.6.3
    public const ServiceUnavailable = 503; // RFC 7231, 6.6.4
    public const GatewayTimeout = 504; // RFC 7231, 6.6.5
    public const HTTPVersionNotSupported = 505; // RFC 7231, 6.6.6
    public const VariantAlsoNegotiates = 506; // RFC 2295, 8.1
    public const InsufficientStorage = 507; // RFC 4918, 11.5
    public const LoopDetected = 508; // RFC 5842, 7.2
    public const NotExtended = 510; // RFC 2774, 7
    public const NetworkAuthenticationRequired = 511; // RFC 6585, 6
}

// It defines HTTP request methods.
class Method
{
    public const GET = 'GET';
    public const HEAD = 'HEAD';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';
    public const CONNECT = 'CONNECT';
    public const OPTIONS = 'OPTIONS';
    public const TRACE = 'TRACE';
}

// It defines a HTTP Header map.
class Header
{
    public const Accept = 'accept';
    public const AcceptCharset = 'accept-charset';
    public const AcceptEncoding = 'accept-encoding';
    public const AcceptLanguage = 'accept-language';
    public const AcceptRanges = 'accept-ranges';
    public const AccessControlAllowCredentials = 'access-control-allow-credentials';
    public const AccessControlAllowHeaders = 'access-control-allow-headers';
    public const AccessControlAllowMethods = 'access-control-allow-methods';
    public const AccessControlAllowOrigin = 'access-control-allow-origin';
    public const AccessControlExposeHeaders = 'access-control-expose-headers';
    public const AccessControlMaxAge = 'access-control-max-age';
    public const AccessControlRequestHeaders = 'access-control-request-headers';
    public const AccessControlRequestMethod = 'access-control-request-method';
    public const Age = 'age';
    public const Allow = 'allow';
    public const Altsvc = 'alt-svc';
    public const Authorization = 'authorization';
    public const CacheControl = 'cache-control';
    public const Connection = 'connection';
    public const ContentDisposition = 'content-disposition';
    public const ContentEncoding = 'content-encoding';
    public const ContentLanguage = 'content-language';
    public const ContentLength = 'content-length';
    public const ContentLocation = 'content-location';
    public const ContentRange = 'content-range';
    public const ContentSecurityPolicy = 'content-security-policy';
    public const ContentSecurityPolicyReportOnly = 'content-security-policy-report-only';
    public const ContentType = 'content-type';
    public const Cookie = 'cookie';
    public const Dnt = 'dnt';
    public const Date = 'date';
    public const Etag = 'etag';
    public const Expect = 'expect';
    public const Expires = 'expires';
    public const Forwarded = 'forwarded';
    public const From = 'from';
    public const Host = 'host';
    public const IfMatch = 'if-match';
    public const IfModifiedSince = 'if-modified-since';
    public const IfNoneMatch = 'if-none-match';
    public const IfRange = 'if-range';
    public const IfUnmodifiedSince = 'if-unmodified-since';
    public const LastModified = 'last-modified';
    public const Link = 'link';
    public const Location = 'location';
    public const MaxForwards = 'max-forwards';
    public const Origin = 'origin';
    public const Pragma = 'pragma';
    public const ProxyAuthenticate = 'proxy-authenticate';
    public const ProxyAuthorization = 'proxy-authorization';
    public const PublicKeyPins = 'public-key-pins';
    public const PublicKeyPinsReportOnly = 'public-key-pins-report-only';
    public const Range = 'range';
    public const Referer = 'referer';
    public const ReferrerPolicy = 'referrer-policy';
    public const Refresh = 'refresh';
    public const RetryAfter = 'retry-after';
    public const SecWebsocketAccept = 'sec-websocket-accept';
    public const SecWebsocketExtensions = 'sec-websocket-extensions';
    public const SecWebsocketKey = 'sec-websocket-key';
    public const SecWebsocketProtocol = 'sec-websocket-protocol';
    public const SecWebsocketVersion = 'sec-websocket-version';
    public const Server = 'server';
    public const SetCookie = 'set-cookie';
    public const StrictTransportSecurity = 'strict-transport-security';
    public const Te = 'te';
    public const Trailer = 'trailer';
    public const TransferEncoding = 'transfer-encoding';
    public const Upgrade = 'upgrade';
    public const UpgradeInsecureRequests = 'upgrade-insecure-requests';
    public const UserAgent = 'user-agent';
    public const Vary = 'vary';
    public const Via = 'via';
    public const Warning = 'warning';
    public const WwwAuthenticate = 'www-authenticate';
    public const XContentTypeOptions = 'x-content-type-options';
    public const XDNSPrefetchControl = 'x-dns-prefetch-control';
    public const XFrameOptions = 'x-frame-options';
    public const XXSSProtection = 'x-xss-protection';
}

// It represents a client request.
class Request
{
    private string $proto = '';
    private array $headers = [];
    private string $content_type = '';
    private string $raw_data = '';

    public function __construct(
        private string $uri = '',
        private string $method = '',
        private array $path = [],
        private array $query = [],
    ) {
        $this->proto = $_SERVER['SERVER_PROTOCOL'] ?? '';
        $this->content_type = trim($_SERVER['HTTP_CONTENT_TYPE'] ?? '');
        // TODO: prepare headers
        // $req->header = [];
        switch ($method) {
            case Method::POST:
            case Method::PUT:
            case Method::DELETE:
                $this->raw_data = file_get_contents('php://input');
                break;
        }
    }

    /** It gets the request headers. */
    public function headers(): array
    {
        return $this->headers;
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

    /** It gets the request uri converted into an array without slash separators. */
    public function path(): array
    {
        return $this->path;
    }

    /** It gets the request query converted into an array without ampersand separators. */
    public function query(): array
    {
        return $this->query;
    }

    /** It gets the request body data in its raw format. */
    public function raw(): string
    {
        return $this->raw_data;
    }

    /** It gets the body data of a `multipart/form-data` content type request. */
    public function multipart(): array
    {
        $data = [];
        if (str_starts_with($this->content_type, 'multipart/form-data') && $this->method === Method::POST) {
            $data = $_POST;
        }
        return $data;
    }

    /** It gets the body data of a `x-www-form-urlencoded` content type request. */
    public function urlencoded(): array
    {
        $data = [];
        if (str_starts_with($this->content_type, 'application/x-www-form-urlencoded')) {
            parse_str($this->raw_data, $data);
        }
        return $data;
    }

    /** It gets the body data of a `xml` content type request. */
    public function xml(): SimpleXMLElement|null
    {
        $xml = null;
        if (str_starts_with($this->content_type, 'application/xml')) {
            $xml = simplexml_load_string($this->raw_data);
            if (!$xml) {
                $xml = null;
            }
        }
        return $xml;
    }

    /** It gets the body data of a `json` content type request. */
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
class Response
{
    private string $status = 'HTTP/1.1 200 OK';
    private array $headers = [];

    public function __construct(public string $method = '')
    {
    }

    /** It adds the HTTP status. */
    public function status(int $status = Status::OK)
    {
        if (isset($this->statuses[$status])) {
            $this->status = "HTTP/1.1 $status " . $this->statuses[$status];
        }
        return $this;
    }

    /** It appends a HTTP header. */
    public function header(string $key, string $value)
    {
        $key = strtolower(trim($key));
        $this->headers[$key] = $value;
        return $this;
    }

    /** It outputs a HTTP response in JSON format. */
    public function json(mixed $data, int $flags = 0, int $depth = 512)
    {
        $this->header(Header::ContentType, 'application/json');
        $data = json_encode($data, $flags, $depth);
        $this->output($data);
    }

    /** It redirects to a given URL. */
    public function redirect(string $url, int $redirect_status = Status::PermanentRedirect)
    {
        $this->status($redirect_status);
        $this->header(Header::Location, $url);
        $this->output('', false);
    }

    /** It outputs the corresponding response using given raw data. */
    private function output(string $data, bool $print_data = true)
    {
        header($this->status);
        $this->header(Header::ContentLength, strlen($data));
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        if ($print_data && $this->method != Method::HEAD) {
            echo $data;
        }
    }

    /** It creates a response that forces to download the file at a given path. */
    public function download(string $file_path, string $name = '')
    {
        if (file_exists($file_path)) {
            $this->status();
            // TODO: we want to guess the mime type
            $this->header(Header::ContentType, 'application/octet-stream');
            $filename = empty($name) ? basename($file_path) : $name;
            $this->header(Header::ContentDisposition, 'attachment; filename="' . $filename . '"');
            $this->header(Header::Expires, '0');
            $this->header(Header::CacheControl, 'must-revalidate');
            $this->header(Header::Pragma, 'public');
            $this->header(Header::ContentLength, filesize($file_path));
            header($this->status);
            foreach ($this->headers as $key => $value) {
                header("$key: $value");
            }
            if ($this->method != Method::HEAD) {
                readfile($file_path);
            }
        }
        // TODO: respond with a 404
    }

    /** It creates a response that serves a file at a given path. */
    public function file(string $base_path, string $file_path)
    {
        // Protect against path/directory traversal
        $path = [];
        $segs = explode('/', urldecode(trim($file_path)));
        foreach ($segs as $seg) {
            if (str_starts_with($seg, '..')) {
                // TODO: rejecting segment starting with '..'
                // Respond with a 404
            } elseif (str_starts_with($seg, '\\')) {
                // TODO: rejecting segment containing with backslash (\\)
                // Respond with a 404
            } else {
                array_push($path, $seg);
            }
        }
        $file_path = "$base_path/" . implode('/', $path);
        if (file_exists($file_path)) {
            $this->status();
            // TODO: we want to guess the mime type
            // $this->header(Header::ContentType, 'application/octet-stream');
            // TODO: we want to have more control over these headers
            $this->header(Header::CacheControl, 'public, max-age=0');
            $this->header(Header::ContentLength, filesize($file_path));
            header($this->status);
            foreach ($this->headers as $key => $value) {
                header("$key: $value");
            }
            if ($this->method != Method::HEAD) {
                readfile($file_path);
            }
        }
        // TODO: respond with a 404
    }
}

/** A lightweight and multi purpose HTTP routing library for PHP. */
class Ruta
{
    private static $instance;
    private static string $uri = '';
    private static string $method = '';
    private static array $path = [];
    private static array $query = [];

    /** It handles `GET` requests. */
    public static function get(string $path, callable|array $class_method_or_func)
    {
        self::match_route_and_delegate($path, Method::GET, $class_method_or_func);
    }

    /** It handles `HEAD` requests. */
    public static function head(string $path, callable|array $class_method_or_func)
    {
        self::match_route_and_delegate($path, Method::HEAD, $class_method_or_func);
    }

    /** It handles `POST` requests. */
    public static function post(string $path, callable|array $class_method_or_func)
    {
        self::match_route_and_delegate($path, Method::POST, $class_method_or_func);
    }

    /** It handles `PUT` requests. */
    public static function put(string $path, callable|array $class_method_or_func)
    {
        self::match_route_and_delegate($path, Method::PUT, $class_method_or_func);
    }

    /** It handles `DELETE` requests. */
    public static function delete(string $path, callable|array $class_method_or_func)
    {
        self::match_route_and_delegate($path, 'DELETE', $class_method_or_func);
    }

    /** It handles `CONNECT` requests. */
    public static function connect(string $path, callable|array $class_method_or_func)
    {
        self::match_route_and_delegate($path, Method::CONNECT, $class_method_or_func);
    }

    /** It handles `OPTIONS` requests. */
    public static function options(string $path, callable|array $class_method_or_func)
    {
        self::match_route_and_delegate($path, Method::OPTIONS, $class_method_or_func);
    }

    /** It handles `TRACE` requests. */
    public static function trace(string $path, callable|array $class_method_or_func)
    {
        self::match_route_and_delegate($path, Method::TRACE, $class_method_or_func);
    }

    private function __construct()
    {
    }

    /** Create a new singleton instance of `Ruta`. */
    public static function new(string $request_uri = '', string $request_method = ''): Ruta
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
        self::$path = self::parse_request_path($uri);
        self::$query = $_GET;
        self::$method = $method;
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new Ruta();
        return self::$instance;
    }

    private static function match_route_and_delegate(string $path, string $method, callable|array $class_method_or_func)
    {
        if (is_null(self::$instance)) {
            self::new();
        }
        if (self::$method !== $method) {
            return;
        }
        list($match, $args) = self::match_request_path_and_query($path);
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
                call_user_func_array($class_method, [self::create_request(), self::create_response(), $args]);
                return;
            }
            throw new InvalidArgumentException('Provided class is not defined or its method is not callable.');
        }
        $class_method_or_func(self::create_request(), self::create_response(), $args);
    }

    private static function create_request(): Request
    {
        return new Request(self::$uri, self::$method, self::$path, self::$query);
    }

    private static function create_response(): Response
    {
        return new Response(self::$method);
    }

    private static function match_request_path_and_query(string $path)
    {
        $match = true;
        $args = [];
        $segs = self::parse_request_path($path);
        $segs_count = count($segs);
        $has_placeholder = false;
        // TODO: check also query
        for ($i = 0; $i < $segs_count; $i++) {
            if (!isset(self::$path[$i])) {
                $match = false;
                break;
            }
            $seg_in = self::$path[$i];
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
        if ($match && !$has_placeholder && $segs_count < count(self::$path)) {
            $match = false;
        }
        return [$match, $args];
    }

    private static function parse_request_path(string $path): array
    {
        $path = trim(parse_url($path, PHP_URL_PATH));
        $segs = [];
        $j = 0;
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
            if (!isset($segs[$j])) {
                $slashes = 0;
                array_push($segs, '');
            }
            $segs[$j] .= $path[$i];
        }
        return $segs;
    }
}
