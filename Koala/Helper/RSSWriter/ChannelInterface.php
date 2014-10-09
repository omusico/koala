<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Koala\Helper\RSSWriter;

use \Koala\Helper\RSSWriter\FeedInterface;
use \Koala\Helper\RSSWriter\ItemInterface;

interface ChannelInterface {
	/**
	 * Set channel title
	 * @param string $title
	 * @return $this
	 */
	public function title($title);

	/**
	 * Set channel URL
	 * @param string $link
	 * @return $this
	 */
	public function link($link);

	/**
	 * Set channel description
	 * @param string $description
	 * @return $this
	 */
	public function description($description);
	/**
	 * Set channel category
	 * @param string $name
	 */
	public function category($name, $domain = null);
	/**
	 * Set channel cloud
	 * @param  array $attrs
	 */
	public function cloud($attrs = array());
	/**
	 * Set channel docs
	 * @param string $docs
	 */
	public function docs($docs);
	/**
	 * Set channel generator
	 * @param string $generator
	 */
	public function generator($generator);
	/**
	 * Set channel managingEditor
	 * @param string $managingEditor
	 */
	public function managingEditor($managingEditor);
	/**
	 * Set channel rating
	 * @param string $rating
	 */
	public function rating($rating);
	/**
	 * Set channel webMaster
	 * @param string $webMaster
	 */
	public function webMaster($webMaster);
	/**
	 * Set ISO639 language code
	 *
	 * The language the channel is written in. This allows aggregators to group all
	 * Italian language sites, for example, on a single page. A list of allowable
	 * values for this element, as provided by Netscape, is here. You may also use
	 * values defined by the W3C.
	 *
	 * @param string $language
	 * @return $this
	 */
	public function language($language);

	/**
	 * Set channel copyright
	 * @param string $copyright
	 * @return $this
	 */
	public function copyright($copyright);

	/**
	 * Set channel published date
	 * @param int $pubDate Unix timestamp
	 * @return $this
	 */
	public function pubDate($pubDate);

	/**
	 * Set channel last build date
	 * @param int $lastBuildDate Unix timestamp
	 * @return $this
	 */
	public function lastBuildDate($lastBuildDate);

	/**
	 * Set channel ttl (minutes)
	 * @param int $ttl
	 * @return $this
	 */
	public function ttl($ttl);

	/**
	 * Add item object
	 * @param \Koala\Helper\RSSWriter\ItemInterface $item
	 * @return $this
	 */
	public function addItem(ItemInterface $item);

	/**
	 * Append to feed
	 * @param \Koala\Helper\RSSWriter\FeedInterface $feed
	 * @return $this
	 */
	public function appendTo(FeedInterface $feed);

	/**
	 * Return XML object
	 * @return \Koala\Helper\RSSWriter\SimpleXMLElement
	 */
	public function asXML();
}