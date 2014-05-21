<?php
namespace Koala\Server\Exception;

/**
 * LockedResponseException
 *
 * Exception used for when a response is attempted to be modified while its locked
 * 
 * @uses       RuntimeException
 */
class LockedResponseException extends RuntimeException implements KoalaExceptionInterface
{
}
