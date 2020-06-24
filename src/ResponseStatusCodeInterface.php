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

    /**
     * Array/List of all HTTP status phrases.
     *
     * @link https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     */
    public const PHRASES = [
        // Informational 1xx
        self::STATUS_CONTINUE => 'Continue',
        self::STATUS_SWITCHING_PROTOCOLS => 'Switching Protocols',
        self::STATUS_PROCESSING => 'Processing',
        self::STATUS_EARLY_HINTS => 'Early Hints',
        // Successful 2xx
        self::STATUS_OK => 'OK',
        self::STATUS_CREATED => 'Created',
        self::STATUS_ACCEPTED => 'Accepted',
        self::STATUS_NON_AUTHORITATIVE_INFORMATION => 'Non-Authoritative Information',
        self::STATUS_NO_CONTENT => 'No Content',
        self::STATUS_RESET_CONTENT => 'Reset Content',
        self::STATUS_PARTIAL_CONTENT => 'Partial Content',
        self::STATUS_MULTI_STATUS => 'Multi-Status',
        self::STATUS_ALREADY_REPORTED => 'Already Reported',
        self::STATUS_IM_USED => 'IM Used',
        // Redirection 3xx
        self::STATUS_MULTIPLE_CHOICES => 'Multiple Choices',
        self::STATUS_MOVED_PERMANENTLY => 'Moved Permanently',
        self::STATUS_FOUND => 'Found',
        self::STATUS_SEE_OTHER => 'See Other',
        self::STATUS_NOT_MODIFIED => 'Not Modified',
        self::STATUS_USE_PROXY => 'Use Proxy',
        self::STATUS_TEMPORARY_REDIRECT => 'Temporary Redirect',
        self::STATUS_PERMANENT_REDIRECT => 'Permanent Redirect',
        // Client Errors 4xx
        self::STATUS_BAD_REQUEST => 'Bad Request',
        self::STATUS_UNAUTHORIZED => 'Unauthorized',
        self::STATUS_PAYMENT_REQUIRED => 'Payment Required',
        self::STATUS_FORBIDDEN => 'Forbidden',
        self::STATUS_NOT_FOUND => 'Not Found',
        self::STATUS_METHOD_NOT_ALLOWED => 'Method Not Allowed',
        self::STATUS_NOT_ACCEPTABLE => 'Not Acceptable',
        self::STATUS_PROXY_AUTHENTICATION_REQUIRED => 'Proxy Authentication Required',
        self::STATUS_REQUEST_TIMEOUT => 'Request Timeout',
        self::STATUS_CONFLICT => 'Conflict',
        self::STATUS_GONE => 'Gone',
        self::STATUS_LENGTH_REQUIRED => 'Length Required',
        self::STATUS_PRECONDITION_FAILED => 'Precondition Failed',
        self::STATUS_PAYLOAD_TOO_LARGE => 'Payload Too Large',
        self::STATUS_URI_TOO_LONG => 'URI Too Long',
        self::STATUS_UNSUPPORTED_MEDIA_TYPE => 'Unsupported Media Type',
        self::STATUS_RANGE_NOT_SATISFIABLE => 'Range Not Satisfiable',
        self::STATUS_EXPECTATION_FAILED => 'Expectation Failed',
        self::STATUS_IM_A_TEAPOT => 'I\'m a teapot',
        self::STATUS_MISDIRECTED_REQUEST => 'Misdirected Request',
        self::STATUS_UNPROCESSABLE_ENTITY => 'Unprocessable Entity',
        self::STATUS_LOCKED => 'Locked',
        self::STATUS_FAILED_DEPENDENCY => 'Failed Dependency',
        self::STATUS_TOO_EARLY => 'Too Early',
        self::STATUS_UPGRADE_REQUIRED => 'Upgrade Required',
        self::STATUS_PRECONDITION_REQUIRED => 'Precondition Required',
        self::STATUS_TOO_MANY_REQUESTS => 'Too Many Requests',
        self::STATUS_REQUEST_HEADER_FIELDS_TOO_LARGE => 'Request Header Fields Too Large',
        self::STATUS_UNAVAILABLE_FOR_LEGAL_REASONS => 'Unavailable For Legal Reasons',
        // Server Errors 5xx
        self::STATUS_INTERNAL_SERVER_ERROR => 'Internal Server Error',
        self::STATUS_NOT_IMPLEMENTED => 'Not Implemented',
        self::STATUS_BAD_GATEWAY => 'Bad Gateway',
        self::STATUS_SERVICE_UNAVAILABLE => 'Service Unavailable',
        self::STATUS_GATEWAY_TIMEOUT => 'Gateway Timeout',
        self::STATUS_VERSION_NOT_SUPPORTED => 'HTTP Version Not Supported',
        self::STATUS_VARIANT_ALSO_NEGOTIATES => 'Variant Also Negotiates',
        self::STATUS_INSUFFICIENT_STORAGE => 'Insufficient Storage',
        self::STATUS_LOOP_DETECTED => 'Loop Detected',
        self::STATUS_NOT_EXTENDED => 'Not Extended',
        self::STATUS_NETWORK_AUTHENTICATION_REQUIRED => 'Network Authentication Required',
    ];
}
