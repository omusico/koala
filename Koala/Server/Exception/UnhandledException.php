<?php
namespace Koala\Server\Exception;

/**
 * UnhandledException
 *
 * Exception used for when a exception isn't correctly handled by the Klein error callbacks
 * 
 * @uses       Exception
 */
class UnhandledException extends RuntimeException implements KoalaExceptionInterface
{
}
