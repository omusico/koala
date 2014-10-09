<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Koala\Helper\RSSWriter;

use \Koala\Helper\RSSWriter\SimpleXMLElement;

class Image implements \Koala\Helper\RSSWriter\ImageInterface {
	/** @var string */
	protected $title;
	/** @var string */
	protected $link;
	/** @var string */
	protected $url;
	/** @var string */
	protected $description;
	/** @var int */
	protected $height;
	/** @var int */
	protected $width;
	/**
	 * Set item title
	 * @param string $title
	 * @return $this
	 */
	public function title($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 * Set item link
	 * @param string $link
	 * @return $this
	 */
	public function link($link) {
		$this->link = $link;
		return $this;
	}
	/**
	 * Set item URL
	 * @param string $url
	 * @return $this
	 */
	public function url($url) {
		$this->url = $url;
		return $this;
	}
	/**
	 * Set item description
	 * @param string $description
	 * @return $this
	 */
	public function description($description) {
		$this->description = $description;
		return $this;
	}

	/**
	 * Set width
	 * @param int $width
	 * @return $this
	 */
	public function width($width) {
		$this->width = $width;
		return $this;
	}

	/**
	 * Set height
	 * @param string $height
	 * @return $this
	 */
	public function height($height) {
		$this->height = $height;
		return $this;
	}

	/**
	 * Append item to the channel
	 * @param \Koala\Helper\RSSWriter\ChannelInterface $channel
	 * @return $this
	 */
	public function appendTo(ChannelInterface $channel) {
		$channel->addImage($this);
		return $this;
	}

	/**
	 * Return XML object
	 * @return \Koala\Helper\RSSWriter\SimpleXMLElement
	 */
	public function asXML() {
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><image></image>', LIBXML_NOERROR|LIBXML_ERR_NONE|LIBXML_ERR_FATAL);
		$xml->addChild('title', $this->title);
		$xml->addChild('link', $this->link);
		$xml->addChild('description', $this->description);
		$xml->addChild('url', $this->url);
		$xml->addChild('width', $this->width);
		$xml->addChild('height', $this->height);
		return $xml;
	}
}