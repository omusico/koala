<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Koala\Helper\RSSWriter;

use \Koala\Helper\RSSWriter\SimpleXMLElement;

class Item implements \Koala\Helper\RSSWriter\ItemInterface {
	/** @var string */
	protected $title;
	/** @var string */
	protected $link;
	/** @var string */
	protected $description;
	/** @var array */
	protected $categories = array();
	/** @var string */
	protected $guid;
	/** @var bool */
	protected $isPermalink;
	/** @var int */
	protected $pubDate;
	/** @var array */
	protected $enclosure;
	/** @var string */
	protected $author;
	/** @var string */
	protected $comments;
	/** @var string */
	protected $contents;
	/** @var string */
	protected $dccreator;
	/** @var array */
	protected $sources = array();
	/** @var array */
	protected $atomlink = array();
	/**
	 * Set channel atomlink
	 * @param array $atomlink
	 * @return $this
	 */
	public function atomlink($atomlink = array()) {
		$this->atomlink = $atomlink;
		return $this;
	}
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
	 * Set item URL
	 * @param string $link
	 * @return $this
	 */
	public function link($link) {
		$this->link = $link;
		return $this;
	}

	/**
	 * Set item comments
	 * @param string $comments
	 * @return $this
	 */
	public function comments($comments, $num = null) {
		$this->comments = array($comments, $num);
		return $this;
	}
	/**
	 * Set item content
	 * @param string $content
	 * @return $this
	 */
	public function content($content, $encoded = false) {
		$this->contents = array($content, $encoded);
		return $this;
	}
	/**
	 * Set item dccreator
	 * @param string $dccreator
	 * @return $this
	 */
	public function dccreator($dccreator) {
		$this->dccreator = $dccreator;
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
	 * Set item category
	 * @param string $name   Category name
	 * @param string $domain Category URL
	 * @return $this
	 */
	public function category($name, $domain = null) {
		$this->categories[] = array($name, $domain);
		return $this;
	}
	/**
	 * Set item source
	 * @param string $name  name
	 * @param string $url URL
	 * @return $this
	 */
	public function source($name, $url = null) {
		$this->sources[] = array($name, $url);
		return $this;
	}

	/**
	 * Set GUID
	 * @param string $guid
	 * @param bool   $isPermalink
	 * @return $this
	 */
	public function guid($guid, $isPermalink = false) {
		$this->guid = $guid;
		$this->isPermalink = $isPermalink;
		return $this;
	}

	/**
	 * Set published date
	 * @param int $pubDate Unix timestamp
	 * @return $this
	 */
	public function pubDate($pubDate) {
		$this->pubDate = $pubDate;
		return $this;
	}

	/**
	 * Set enclosure
	 * @param var $url Url to media file
	 * @param int $length Length in bytes of the media file
	 * @param var $type Media type, default is audio/mpeg
	 * @return $this
	 */
	public function enclosure($url, $length = 0, $type = 'audio/mpeg') {
		$this->enclosure = array('url' => $url, 'length' => $length, 'type' => $type);
		return $this;
	}

	/**
	 * Set the author
	 * @param string $author Email of item author
	 * @return $this
	 */
	public function author($author) {
		$this->author = $author;
		return $this;
	}

	/**
	 * Append item to the channel
	 * @param \Koala\Helper\RSSWriter\ChannelInterface $channel
	 * @return $this
	 */
	public function appendTo(ChannelInterface $channel) {
		$channel->addItem($this);
		return $this;
	}

	/**
	 * Return XML object
	 * @return \Koala\Helper\RSSWriter\SimpleXMLElement
	 */
	public function asXML() {
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><item></item>', LIBXML_NOERROR|LIBXML_ERR_NONE|LIBXML_ERR_FATAL);
		$xml->addChild('title', $this->title);
		$xml->addChild('link', $this->link);
		$xml->addChild('description', $this->description);

		foreach ($this->categories as $category) {
			$element = $xml->addChild('category', $category[0]);

			if (isset($category[1])) {
				$element->addAttribute('domain', $category[1]);
			}
		}
		foreach ($this->sources as $source) {
			$element = $xml->addChild('source', $source[0]);

			if (isset($source[1])) {
				$element->addAttribute('url', $source[1]);
			}
		}
		if ($this->guid) {
			$guid = $xml->addChild('guid', $this->guid);

			if ($this->isPermalink) {
				$guid->addAttribute('isPermaLink', 'true');
			}
		}
		if (!empty($this->atomlink)) {
			$element = $xml->addChild('::atom:link', null);
			foreach ($this->atomlink as $attr => $value) {
				$element->addAttribute($attr, $value);
			}
		}
		if ($this->pubDate !== null) {
			$xml->addChild('pubDate', date(DATE_RSS, $this->pubDate));
		}
		if ($this->dccreator !== null) {
			$xml->addChild('::dc:creator', $this->dccreator);
		}
		if (!empty($this->comments)) {
			$xml->addChild('comments', $this->comments[0]);
			if (isset($this->comments[1])) {
				$xml->addChild("::slash:comments", $this->comments[1]);
			}
		}
		if (!empty($this->contents)) {
			if ($this->contents[1]) {
				$xml->addChild('::content:encoded', $this->contents[0]);
			} else {
				$xml->addChild('content', $this->contents[0]);
			}
		}

		if (is_array($this->enclosure) && (count($this->enclosure) == 3)) {
			$element = $xml->addChild('enclosure');
			$element->addAttribute('url', $this->enclosure['url']);
			$element->addAttribute('type', $this->enclosure['type']);

			if ($this->enclosure['length']) {
				$element->addAttribute('length', $this->enclosure['length']);
			}
		}

		if (!empty($this->author)) {
			$xml->addChild('author', $this->author);
		}

		return $xml;
	}
	/**
	 * [clearAttr description]
	 * @return
	 */
	public function clearAttr() {
		$this->title = null;
		$this->link = null;
		$this->description = null;
		$this->categories = array();
		$this->guid = null;
		$this->isPermalink = null;
		$this->pubDate = null;
		$this->enclosure = null;
		$this->author = null;
		$this->comments = null;
		$this->dccreator = null;
		$this->contents = array();
		$this->sources = array();
		$this->atomlink = array();
	}
}