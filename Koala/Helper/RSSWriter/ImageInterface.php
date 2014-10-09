<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Koala\Helper\RSSWriter;

use \Koala\Helper\RSSWriter\ChannelInterface;
use \Koala\Helper\RSSWriter\SimpleXMLElement;

interface ImageInterface {
	/**
	 * Set item title
	 * @param string $title
	 * @return $this
	 */
	public function title($title);

	/**
	 * Set item link
	 * @param string $link
	 * @return $this
	 */
	public function link($link);
	/**
	 * Set item URL
	 * @param string $url
	 * @return $this
	 */
	public function url($url);
	/**
	 * Set item description
	 * @param string $description
	 * @return $this
	 */
	public function description($description);

	/**
	 * Set width
	 * @param int $width
	 * @return $this
	 */
	public function width($width);

	/**
	 * Set height
	 * @param string $height
	 * @return $this
	 */
	public function height($height);

	/**
	 * Append item to the channel
	 * @param \Koala\Helper\RSSWriter\ChannelInterface $channel
	 * @return $this
	 */
	public function appendTo(ChannelInterface $channel);

	/**
	 * Return XML object
	 * @return \Koala\Helper\RSSWriter\SimpleXMLElement
	 */
	public function asXML();
}