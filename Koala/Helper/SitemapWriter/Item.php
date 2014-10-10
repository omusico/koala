<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Koala\Helper\SitemapWriter;

use \Koala\Helper\SitemapWriter\SimpleXMLElement;

class Item implements \Koala\Helper\SitemapWriter\ItemInterface {
	/** @var string */
	protected $loc;
	/** @var string */
	protected $lastmod;
	/** @var string */
	protected $changefreq = 'daily';//always、hourly、daily、weekly、monthly、yearly、never
	/** @var string */
	protected $priority = '1.0';//0.0-1.0
	/**
	 * Set item loc
	 * @param string $loc
	 * @return $this
	 */
	public function loc($loc) {
		$this->loc = $loc;
		return $this;
	}
	/**
	 * Set item lastmod
	 * @param string $lastmod
	 * @return $this
	 */
	public function lastmod($lastmod) {
		$this->lastmod = $lastmod;
		return $this;
	}
	/**
	 * Set item changefreq
	 * @param string $changefreq
	 * @return $this
	 */
	public function changefreq($changefreq) {
		$this->changefreq = $changefreq;
		return $this;
	}
	/**
	 * Set item priority
	 * @param string $priority
	 * @return $this
	 */
	public function priority($priority) {
		$this->priority = $priority;
		return $this;
	}
	/**
	 * Append item to the sitemap
	 * @param \Koala\Helper\SitemapWriter\SitemapInterface $sitemap
	 * @return $this
	 */
	public function appendTo(SitemapInterface $sitemap) {
		$sitemap->addItem($this);
		return $this;
	}

	/**
	 * Return XML object
	 * @return \Koala\Helper\SitemapWriter\SimpleXMLElement
	 */
	public function asXML() {
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><url></url>', LIBXML_NOERROR|LIBXML_ERR_NONE|LIBXML_ERR_FATAL);
		$xml->addChild('loc', $this->loc);
		$xml->addChild('lastmod', $this->lastmod);
		$xml->addChild('changefreq', $this->changefreq);
		$xml->addChild('priority', $this->priority);
		return $xml;
	}
	/**
	 * [clearAttr description]
	 * @return
	 */
	public function clearAttr() {
		$this->loc = null;
		$this->lastmod = null;
		$this->changefreq = 'daily';
		$this->priority = '1.0';
	}
}