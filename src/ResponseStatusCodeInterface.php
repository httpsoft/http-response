<?php

declare(strict_types=1);

namespace HttpSoft\Response;

interface ResponseStatusCodeInterface
{
    // Informational 1xx

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.2.1
     */
    public const STATUS_CONTINUE = 100;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.2.2
     */
    public const STATUS_SWITCHING_PROTOCOLS = 101;

    /**
     * @link https://tools.ietf.org/html/rfc2518#section-10.1
     */
    public const STATUS_PROCESSING = 102;

    /**
     * @link https://tools.ietf.org/html/rfc8297#section-2
     */
    public const STATUS_EARLY_HINTS = 103;

    // Successful 2xx

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.3.1
     */
    public const STATUS_OK = 200;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.3.2
     */
    public const STATUS_CREATED = 201;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.3.3
     */
    public const STATUS_ACCEPTED = 202;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.3.4
     */
    public const STATUS_NON_AUTHORITATIVE_INFORMATION = 203;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.3.5
     */
    public const STATUS_NO_CONTENT = 204;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.3.6
     */
    public const STATUS_RESET_CONTENT = 205;

    /**
     * @link https://tools.ietf.org/html/rfc7233#section-4.1
     */
    public const STATUS_PARTIAL_CONTENT = 206;

    /**
     * @link https://tools.ietf.org/html/rfc4918#section-11.1
     */
    public const STATUS_MULTI_STATUS = 207;

    /**
     * @link https://tools.ietf.org/html/rfc5842#section-7.1
     */
    public const STATUS_ALREADY_REPORTED = 208;

    /**
     * @link https://tools.ietf.org/html/rfc3229#section-10.4.1
     */
    public const STATUS_IM_USED = 226;

    // Redirection 3xx

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.4.1
     */
    public const STATUS_MULTIPLE_CHOICES = 300;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.4.2
     */
    public const STATUS_MOVED_PERMANENTLY = 301;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.4.3
     */
    public const STATUS_FOUND = 302;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.4.4
     */
    public const STATUS_SEE_OTHER = 303;

    /**
     * @link https://tools.ietf.org/html/rfc7232#section-4.1
     */
    public const STATUS_NOT_MODIFIED = 304;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.4.5
     */
    public const STATUS_USE_PROXY = 305;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.4.7
     */
    public const STATUS_TEMPORARY_REDIRECT = 307;

    /**
     * @link https://tools.ietf.org/html/rfc7238#section-3
     */
    public const STATUS_PERMANENT_REDIRECT = 308;

    // Client Errors 4xx

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.1
     */
    public const STATUS_BAD_REQUEST = 400;

    /**
     * @link https://tools.ietf.org/html/rfc7235#section-3.1
     */
    public const STATUS_UNAUTHORIZED = 401;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.2
     */
    public const STATUS_PAYMENT_REQUIRED = 402;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.3
     */
    public const STATUS_FORBIDDEN = 403;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.4
     */
    public const STATUS_NOT_FOUND = 404;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.5
     */
    public const STATUS_METHOD_NOT_ALLOWED = 405;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.6
     */
    public const STATUS_NOT_ACCEPTABLE = 406;

    /**
     * @link https://tools.ietf.org/html/rfc7235#section-3.2
     */
    public const STATUS_PROXY_AUTHENTICATION_REQUIRED = 407;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.7
     */
    public const STATUS_REQUEST_TIMEOUT = 408;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.8
     */
    public const STATUS_CONFLICT = 409;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.9
     */
    public const STATUS_GONE = 410;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.10
     */
    public const STATUS_LENGTH_REQUIRED = 411;

    /**
     * @link https://tools.ietf.org/html/rfc7232#section-4.2
     */
    public const STATUS_PRECONDITION_FAILED = 412;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.11
     */
    public const STATUS_PAYLOAD_TOO_LARGE = 413;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.12
     */
    public const STATUS_URI_TOO_LONG = 414;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.13
     */
    public const STATUS_UNSUPPORTED_MEDIA_TYPE = 415;

    /**
     * @link https://tools.ietf.org/html/rfc7233#section-4.4
     */
    public const STATUS_RANGE_NOT_SATISFIABLE = 416;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.14
     */
    public const STATUS_EXPECTATION_FAILED = 417;

    /**
     * @link https://tools.ietf.org/html/rfc2324#section-2.3.2
     */
    public const STATUS_IM_A_TEAPOT = 418;

    /**
     * @link https://tools.ietf.org/html/rfc7540#section-9.1.2
     */
    public const STATUS_MISDIRECTED_REQUEST = 421;

    /**
     * @link https://tools.ietf.org/html/rfc4918#section-11.2
     */
    public const STATUS_UNPROCESSABLE_ENTITY = 422;

    /**
     * @link https://tools.ietf.org/html/rfc4918#section-11.3
     */
    public const STATUS_LOCKED = 423;

    /**
     * @link https://tools.ietf.org/html/rfc4918#section-11.4
     */
    public const STATUS_FAILED_DEPENDENCY = 424;

    /**
     * @link https://tools.ietf.org/html/draft-ietf-httpbis-replay-04#section-5.2
     */
    public const STATUS_TOO_EARLY = 425;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.5.15
     */
    public const STATUS_UPGRADE_REQUIRED = 426;

    /**
     * @link https://tools.ietf.org/html/rfc6585#section-3
     */
    public const STATUS_PRECONDITION_REQUIRED = 428;

    /**
     * @link https://tools.ietf.org/html/rfc6585#section-4
     */
    public const STATUS_TOO_MANY_REQUESTS = 429;

    /**
     * @link https://tools.ietf.org/html/rfc6585#section-5
     */
    public const STATUS_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;

    /**
     * @link https://tools.ietf.org/html/rfc7725#section-3
     */
    public const STATUS_UNAVAILABLE_FOR_LEGAL_REASONS = 451;

    // Server Errors 5xx

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.6.1
     */
    public const STATUS_INTERNAL_SERVER_ERROR = 500;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.6.2
     */
    public const STATUS_NOT_IMPLEMENTED = 501;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.6.3
     */
    public const STATUS_BAD_GATEWAY = 502;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.6.4
     */
    public const STATUS_SERVICE_UNAVAILABLE = 503;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.6.5
     */
    public const STATUS_GATEWAY_TIMEOUT = 504;

    /**
     * @link https://tools.ietf.org/html/rfc7231#section-6.6.6
     */
    public const STATUS_VERSION_NOT_SUPPORTED = 505;

    /**
     * @link https://tools.ietf.org/html/rfc2295#section-8.1
     */
    public const STATUS_VARIANT_ALSO_NEGOTIATES = 506;

    /**
     * @link https://tools.ietf.org/html/rfc4918#section-11.5
     */
    public const STATUS_INSUFFICIENT_STORAGE = 507;

    /**
     * @link https://tools.ietf.org/html/rfc5842#section-7.2
     */
    public const STATUS_LOOP_DETECTED = 508;

    /**
     * @link https://tools.ietf.org/html/rfc2774#section-7
     */
    public const STATUS_NOT_EXTENDED = 510;

    /**
     * @link https://tools.ietf.org/html/rfc6585#section-6
     */
    public const STATUS_NETWORK_AUTHENTICATION_REQUIRED = 511;
}
