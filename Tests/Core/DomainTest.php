<?php
/**
 * @author LunnLew <lunnlew@gmail.com>
 * @todo 
 */
class DomainTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Domain
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Domain;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Domain::Dispatch
     * @todo   Implement testDispatch().
     */
    public function testDispatch()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}
