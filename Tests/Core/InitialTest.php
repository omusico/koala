<?php
/**
 * @author LunnLew <lunnlew@gmail.com>
 */
class InitialTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Initial
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Initial;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Initial::initialize
     * @todo   Implement testInitialize().
     */
    public function testInitialize()
    {
        Initial::initialize(function($ins){});
        $this->assertInstanceOf('Initial',Initial::$instance[MD5('Initial')]);
    }

    /**
     * @covers Initial::getInstance
     * @todo   Implement testGetInstance().
     */
    public function testGetInstance()
    {
        $this->assertInstanceOf('Initial',Initial::getInstance());
    }
}
