<?php
namespace Koala\Server\Exception;
/**
 * DispatchHaltedException
 *
 * Exception used to halt a route callback from executing in a dispatch loop
 * 
 * @uses       RuntimeException
 */
class DispatchHaltedException extends RuntimeException implements KoalaExceptionInterface
{

    /**
     * Constants
     */

    /**
     * Skip this current match/callback
     *
     * @const int
     */
    const SKIP_THIS = 1;

    /**
     * Skip the next match/callback
     *
     * @const int
     */
    const SKIP_NEXT = 2;

    /**
     * Skip the rest of the matches
     *
     * @const int
     */
    const SKIP_REMAINING = 0;


    /**
     * Properties
     */

    /**
     * The number of next matches to skip on a "next" skip
     *
     * @var int
     * @access protected
     */
    protected $number_of_skips = 1;


    /**
     * Methods
     */

    /**
     * Gets the number of matches to skip on a "next" skip
     *
     * @return int
     */
    public function getNumberOfSkips()
    {
        return $this->number_of_skips;
    }
    
    /**
     * Sets the number of matches to skip on a "next" skip
     *
     * @param int $number_of_skips
     * @access public
     * @return DispatchHaltedException
     */
    public function setNumberOfSkips($number_of_skips)
    {
        $this->number_of_skips = (int) $number_of_skips;

        return $this;
    }
}
