<?php
/**
 * Klein (klein.php) - A lightning fast router for PHP
 *
 * @author      Chris O'Hara <cohara87@gmail.com>
 * @author      Trevor Suarez (Rican7) (contributor and v2 refactorer)
 * @copyright   (c) Chris O'Hara
 * @link        https://github.com/chriso/klein.php
 * @license     MIT
 */
namespace Koala\Server\Exception;

/**
 * DuplicateServiceException
 *
 * Exception used for when a service is attempted to be registered that already exists
 * 
 * @uses       Exception
 * @package    Klein\Exceptions
 */
class DuplicateServiceException extends RuntimeException implements KoalaExceptionInterface
{
}
