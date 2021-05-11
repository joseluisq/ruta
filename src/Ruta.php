<?php

// TODO: complete the request object
class Request {
    public string $method = '';
	public string $uri = '';
	public array $path = [];
	public array $query = [];
	public string $proto = '';
	public array $headers = [];
	public string $content_type = '';
	public string $raw = '';

    public function __construct(string $method, array $path, array $query, string $uri) {
        $this->method = $method;
        $this->path = $path;
        $this->query = $query;
        $this->proto = $_SERVER['SERVER_PROTOCOL'] ?? '';
        $this->uri = $uri;
        $this->content_type = trim($_SERVER['HTTP_CONTENT_TYPE'] ?? '');
        // TODO: prepare headers
        // $req->header = [];
        switch ($method) {
            case 'POST':
            case 'PUT':
            case 'DELETE':
                $this->raw = file_get_contents('php://input');
                break;
        }
    }

    /** It gets the request body data in raw format. */
    public function raw(): string {
        return $this->raw;
    }

    /** It gets the body data of a `multipart/form-data` content type request. */
    public function multipart(): array {
        $data = [];
        if (str_starts_with($this->content_type, 'multipart/form-data') && $this->method === 'POST') {
            $data = $_POST;
        }
        return $data;
    }

    /** It gets the body data of a `x-www-form-urlencoded` content type request. */
    public function urlencoded(): array {
        $data = [];
        if (str_starts_with($this->content_type, 'application/x-www-form-urlencoded')) {
            parse_str($this->raw, $data);
        }
        return $data;
    }

    /** It gets the body data of a `xml` content type request. */
    public function xml(): SimpleXMLElement|null {
        $xml = null;
        if (str_starts_with($this->content_type, 'application/xml')) {
            $xml = simplexml_load_string($this->raw);
            if (!$xml) {
                $xml = null;
            }
        }
        return $xml;
    }

    /** It gets the body data of a `json` content type request. */
    public function json(): string|array|null {
        $json = null;
        if (str_starts_with($this->content_type, 'application/json')) {
            $json = json_decode($this->raw, true);
        }
        return $json;
    }

    /** It gets the request query data. */
    public function query(): array {
        return $this->query;
    }
}

// TODO: complete the response object
class Response {
    private string $status = 'HTTP/1.1 200 OK';
    private array $statuses = [
        100 => 'Continue', // RFC 7231, 6.2.1
        101 => 'SwitchingProtocols', // RFC 7231, 6.2.2
        102 => 'Processing', // RFC 2518, 10.1
        103 => 'EarlyHints', // RFC 8297
        200 => 'OK', // RFC 7231, 6.3.1
        201 => 'Created', // RFC 7231, 6.3.2
        202 => 'Accepted', // RFC 7231, 6.3.3
        203 => 'NonAuthoritativeInfo', // RFC 7231, 6.3.4
        204 => 'NoContent', // RFC 7231, 6.3.5
        205 => 'ResetContent', // RFC 7231, 6.3.6
        206 => 'PartialContent', // RFC 7233, 4.1
        207 => 'MultiStatus', // RFC 4918, 11.1
        208 => 'AlreadyReported', // RFC 5842, 7.1
        226 => 'IMUsed', // RFC 3229, 10.4.1
        300 => 'MultipleChoices', // RFC 7231, 6.4.1
        301 => 'MovedPermanently', // RFC 7231, 6.4.2
        302 => 'Found', // RFC 7231, 6.4.3
        303 => 'SeeOther', // RFC 7231, 6.4.4
        304 => 'NotModified', // RFC 7232, 4.1
        305 => 'UseProxy', // RFC 7231, 6.4.5
        306 => '_', // RFC 7231, 6.4.6 (Unused)
        307 => 'TemporaryRedirect', // RFC 7231, 6.4.7
        308 => 'PermanentRedirect', // RFC 7538, 3
        400 => 'BadRequest', // RFC 7231, 6.5.1
        401 => 'Unauthorized', // RFC 7235, 3.1
        402 => 'PaymentRequired', // RFC 7231, 6.5.2
        403 => 'Forbidden', // RFC 7231, 6.5.3
        404 => 'NotFound', // RFC 7231, 6.5.4
        405 => 'MethodNotAllowed', // RFC 7231, 6.5.5
        406 => 'NotAcceptable', // RFC 7231, 6.5.6
        407 => 'ProxyAuthRequired', // RFC 7235, 3.2
        408 => 'RequestTimeout', // RFC 7231, 6.5.7
        409 => 'Conflict', // RFC 7231, 6.5.8
        410 => 'Gone', // RFC 7231, 6.5.9
        411 => 'LengthRequired', // RFC 7231, 6.5.10
        412 => 'PreconditionFailed', // RFC 7232, 4.2
        413 => 'RequestEntityTooLarge', // RFC 7231, 6.5.11
        414 => 'RequestURITooLong', // RFC 7231, 6.5.12
        415 => 'UnsupportedMediaType', // RFC 7231, 6.5.13
        416 => 'RequestedRangeNotSatisfiable', // RFC 7233, 4.4
        417 => 'ExpectationFailed', // RFC 7231, 6.5.14
        418 => 'Teapot', // RFC 7168, 2.3.3
        421 => 'MisdirectedRequest', // RFC 7540, 9.1.2
        422 => 'UnprocessableEntity', // RFC 4918, 11.2
        423 => 'Locked', // RFC 4918, 11.3
        424 => 'FailedDependency', // RFC 4918, 11.4
        425 => 'TooEarly', // RFC 8470, 5.2.
        426 => 'UpgradeRequired', // RFC 7231, 6.5.15
        428 => 'PreconditionRequired', // RFC 6585, 3
        429 => 'TooManyRequests', // RFC 6585, 4
        431 => 'RequestHeaderFieldsTooLarge', // RFC 6585, 5
        451 => 'UnavailableForLegalReasons', // RFC 7725, 3
        500 => 'InternalServerError', // RFC 7231, 6.6.1
        501 => 'NotImplemented', // RFC 7231, 6.6.2
        502 => 'BadGateway', // RFC 7231, 6.6.3
        503 => 'ServiceUnavailable', // RFC 7231, 6.6.4
        504 => 'GatewayTimeout', // RFC 7231, 6.6.5
        505 => 'HTTPVersionNotSupported', // RFC 7231, 6.6.6
        506 => 'VariantAlsoNegotiates', // RFC 2295, 8.1
        507 => 'InsufficientStorage', // RFC 4918, 11.5
        508 => 'LoopDetected', // RFC 5842, 7.2
        510 => 'NotExtended', // RFC 2774, 7
        511 => 'NetworkAuthenticationRequired', // RFC 6585, 6
    ];
    private array $headers = [];

    /** It adds the HTTP status. */
    public function status(int $status = 200) {
        if (isset($this->statuses[$status])) {
            $this->status = "HTTP/1.1 $status " . $this->statuses[$status];
        }
        return $this;
    }

    /** It appends a HTTP header. */
    public function header(string $key, string $value) {
        $key = strtolower(trim($key));
        $this->headers[$key] = $value;
        return $this;
    }
    
    /** It outputs a HTTP response in JSON format. */
    public function json(string|array|null $data, int $flags = 0, int $depth = 512) {
        $this->header('content-type', 'application/json');
        $data = json_encode($data, $flags, $depth);
        $this->output($data);
    }

    /** It creates a response that forces to download the file at a given path. */
    public function download(string $file_path, string $name = '') {
        // TODO: implement donwload response
    }

    /** It outputs the corresponding response using given raw data. */
    private function output(string $data) {
        header($this->status);
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        echo $data;
    }
}

/** A lightweight and multi purpose HTTP routing library for PHP. */
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
        self::$req_query = $_GET;
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
                call_user_func_array($class_method, [self::get_request(), self::get_response(), $args]);
                return;
            }
            throw new InvalidArgumentException('Provided class is not defined or its method is not callable.');
        }
        $class_method_or_func(self::get_request(), self::get_response(), $args);
    }

    private static function get_request() {
        return new Request(self::$req_method, self::$req_path, self::$req_query, self::$uri);
    }

    private static function get_response() {
        // TODO: prepare a response object
        $res = new Response();
        return $res;
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
