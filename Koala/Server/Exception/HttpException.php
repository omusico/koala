<?php
namespace Koala\Server\Exception;

/**
 * HttpException
 *
 * An HTTP error exception
 */
class HttpException extends RuntimeException implements HttpExceptionInterface
{

    /**
     * Methods
     */

    /**
     * Create an HTTP exception from nothing but an HTTP code
     *
     * @param int $code
     * @static
     * @access public
     * @return HttpException
     */
    public static function createFromCode($code)
    {
        return new static(null, (int) $code);
    }
}
