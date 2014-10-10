<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Koala\Helper\OpenNewsWriter;

use \Koala\Helper\OpenNewsWriter\OpenNewsInterface;
use \Koala\Helper\OpenNewsWriter\SimpleXMLElement;

interface ItemInterface {
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
	 * Set item text
	 * @param string $text
	 * @return $this
	 */
	public function text($text);
	/**
	 * Set item image
	 * @param string $image
	 * @return $this
	 */
	public function image($image);
	/**
	 * Set item headlineImg
	 * @param string $headlineImg
	 * @return $this
	 */
	public function headlineImg($headlineImg);
	/**
	 * Set item keywords
	 * @param string $keywords
	 * @return $this
	 */
	public function keywords($keywords);
	/**
	 * Set published date
	 * @param int $pubDate Unix timestamp
	 * @return $this
	 */
	public function pubDate($pubDate);

	/**
	 * Set the author
	 * @param string $author Email of item author
	 * @return $this
	 */
	public function author($author);
	/**
	 * Set item category
	 * @param string $name   Category name
	 * @param string $domain Category URL
	 * @return $this
	 */
	public function category($name, $domain = null);
	/**
	 * Set item source
	 * @param string $name  name
	 * @param string $url URL
	 * @return $this
	 */
	public function source($name, $url = null);
	/**
	 * Append item to the sitemap
	 * @param \Koala\Helper\OpenNewsWriter\OpenNewsInterface $sitemap
	 * @return $this
	 */
	public function appendTo(OpenNewsInterface $sitemap);

	/**
	 * Return XML object
	 * @return \Koala\Helper\OpenNewsWriter\SimpleXMLElement
	 */
	public function asXML();
}