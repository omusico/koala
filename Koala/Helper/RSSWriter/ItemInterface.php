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

interface ItemInterface {
	/**
	 * Set item atomlink
	 * @param array $atomlink
	 * @return $this
	 */
	public function atomlink($atomlink = array());
	/**
	 * Set item title
	 * @param string $title
	 * @return $this
	 */
	public function title($title);

	/**
	 * Set item URL
	 * @param string $link
	 * @return $this
	 */
	public function link($link);

	/**
	 * Set item description
	 * @param string $description
	 * @return $this
	 */
	public function description($description);

	/**
	 * Set item category
	 * @param string $name Category name
	 * @param string $domain Category URL
	 * @return $this
	 */
	public function category($name, $domain = null);

	/**
	 * Set GUID
	 * @param string $guid
	 * @param bool $isPermalink
	 * @return $this
	 */
	public function guid($guid, $isPermalink = false);

	/**
	 * Set published date
	 * @param int $pubDate Unix timestamp
	 * @return $this
	 */
	public function pubDate($pubDate);

	/**
	 * Set enclosure
	 * @param var $url Url to media file
	 * @param int $length Length in bytes of the media file
	 * @param var $type Media type, default is audio/mpeg
	 * @return $this
	 */
	public function enclosure($url, $length = 0, $type = 'audio/mpeg');

	/**
	 * Set the author
	 * @param string $author Email of item author
	 * @return $this
	 */
	public function author($author);
	/**
	 * Set item source
	 * @param string $name  name
	 * @param string $url URL
	 * @return $this
	 */
	public function source($name, $url = null);
	/**
	 * Set item comments
	 * @param string $comments
	 * @return $this
	 */
	public function comments($comments, $num = null);
	/**
	 * Set item content
	 * @param string $content
	 * @return $this
	 */
	public function content($content, $encoded = false);
	/**
	 * Set item dccreator
	 * @param string $dccreator
	 * @return $this
	 */
	public function dccreator($dccreator);
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