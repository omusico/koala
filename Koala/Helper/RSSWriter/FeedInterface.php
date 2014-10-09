<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Koala\Helper\RSSWriter;

use \Koala\Helper\RSSWriter\ChannelInterface;

interface FeedInterface {
	/**
	 * Add channel
	 * @param \Koala\Helper\RSSWriter\ChannelInterface $channel
	 * @return $thisJ
	 */
	public function addChannel(ChannelInterface $channel);

	/**
	 * Render XML
	 * @return string
	 */
	public function render();

	/**
	 * Render XML
	 * @return string
	 */
	public function __toString();
}