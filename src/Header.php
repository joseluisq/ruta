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

/** It defines HTTP headers. */
class Header
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
    public const AltSvc                          = 'alt-svc';
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
    public const XDnsPrefetchControl             = 'x-dns-prefetch-control';
    public const XFrameOptions                   = 'x-frame-options';
    public const XXssProtection                  = 'x-xss-protection';
}
