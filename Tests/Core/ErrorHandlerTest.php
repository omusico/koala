<?php
/**
 * @author LunnLew <lunnlew@gmail.com>
 * @todo 
 */
class ErrorHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ErrorHandler
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new ErrorHandler;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}
