<?php
namespace Koala\Server\Exception;
/**
 * ResponseAlreadySentException
 *
 * Exception used for when a response is attempted to be sent after its already been sent
 * 
 * @uses       RuntimeException
 */
class ResponseAlreadySentException extends RuntimeException implements KoalaExceptionInterface
{
}
