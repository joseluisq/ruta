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

/** It defines HTTP Status codes. */
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
    // public const _                 = 306; // RFC 7231, 6.4.6 (Unused)
    public const TemporaryRedirect = 307; // RFC 7231, 6.4.7
    public const PermanentRedirect = 308; // RFC 7538, 3

    public const BadRequest                       = 400; // RFC 7231, 6.5.1
    public const Unauthorized                     = 401; // RFC 7235, 3.1
    public const PaymentRequired                  = 402; // RFC 7231, 6.5.2
    public const Forbidden                        = 403; // RFC 7231, 6.5.3
    public const NotFound                         = 404; // RFC 7231, 6.5.4
    public const MethodNotAllowed                 = 405; // RFC 7231, 6.5.5
    public const NotAcceptable                    = 406; // RFC 7231, 6.5.6
    public const ProxyAuthRequired                = 407; // RFC 7235, 3.2
    public const RequestTimeout                   = 408; // RFC 7231, 6.5.7
    public const Conflict                         = 409; // RFC 7231, 6.5.8
    public const Gone                             = 410; // RFC 7231, 6.5.9
    public const LengthRequired                   = 411; // RFC 7231, 6.5.10
    public const PreconditionFailed               = 412; // RFC 7232, 4.2
    public const RequestEntityTooLarge            = 413; // RFC 7231, 6.5.11
    public const RequestURITooLong                = 414; // RFC 7231, 6.5.12
    public const UnsupportedMediaType             = 415; // RFC 7231, 6.5.13
    public const RequestedRangeNotSatisfiable     = 416; // RFC 7233, 4.4
    public const ExpectationFailed                = 417; // RFC 7231, 6.5.14
    public const Teapot                           = 418; // RFC 7168, 2.3.3
    public const MisdirectedRequest               = 421; // RFC 7540, 9.1.2
    public const UnprocessableEntity              = 422; // RFC 4918, 11.2
    public const Locked                           = 423; // RFC 4918, 11.3
    public const FailedDependency                 = 424; // RFC 4918, 11.4
    public const TooEarly                         = 425; // RFC 8470, 5.2.
    public const UpgradeRequired                  = 426; // RFC 7231, 6.5.15
    public const PreconditionRequired             = 428; // RFC 6585, 3
    public const TooManyRequests                  = 429; // RFC 6585, 4
    public const RequestHeaderFieldsTooLarge      = 431; // RFC 6585, 5
    public const UnavailableForLegalReasons       = 451; // RFC 7725, 3

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

    /**
     * It returns a description text for the HTTP status code.
     * An empty string is returned if the code is unknown.
     */
    public static function text(int $status_code): string
    {
        return self::STATUS_MAP[$status_code] ?? '';
    }
}
