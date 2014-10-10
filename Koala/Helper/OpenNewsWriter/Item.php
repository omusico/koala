<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Koala\Helper\OpenNewsWriter;

use \Koala\Helper\OpenNewsWriter\SimpleXMLElement;

class Item implements \Koala\Helper\OpenNewsWriter\ItemInterface {
	/** @var string */
	protected $title;
	/** @var string */
	protected $link;
	/** @var string */
	protected $description;
	/** @var string */
	protected $text;
	/** @var array */
	protected $categories = array();
	/** @var string */
	protected $image;
	/** @var string */
	protected $headlineImg;
	/** @var string */
	protected $keywords;
	/** @var int */
	protected $pubDate;
	/** @var string */
	protected $author;
	/** @var array */
	protected $sources = array();

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
	 * Set item description
	 * @param string $description
	 * @return $this
	 */
	public function description($description) {
		$this->description = $description;
		return $this;
	}
	/**
	 * Set item text
	 * @param string $text
	 * @return $this
	 */
	public function text($text) {
		$this->text = $text;
		return $this;
	}
	/**
	 * Set item image
	 * @param string $image
	 * @return $this
	 */
	public function image($image) {
		$this->image = $image;
		return $this;
	}
	/**
	 * Set item headlineImg
	 * @param string $headlineImg
	 * @return $this
	 */
	public function headlineImg($headlineImg) {
		$this->headlineImg = $headlineImg;
		return $this;
	}
	/**
	 * Set item keywords
	 * @param string $keywords
	 * @return $this
	 */
	public function keywords($keywords) {
		$this->keywords = $keywords;
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
	 * Set the author
	 * @param string $author Email of item author
	 * @return $this
	 */
	public function author($author) {
		$this->author = $author;
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
	 * Append item to the News
	 * @param \Koala\Helper\OpenNewsWriter\OpenNewsInterface $News
	 * @return $this
	 */
	public function appendTo(OpenNewsInterface $News) {
		$News->addItem($this);
		return $this;
	}

	/**
	 * Return XML object
	 * @return \Koala\Helper\OpenNewsWriter\SimpleXMLElement
	 */
	public function asXML() {
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><item></item>', LIBXML_NOERROR|LIBXML_ERR_NONE|LIBXML_ERR_FATAL);
		$xml->addChild('title', $this->title);
		$xml->addChild('link', $this->link);
		$xml->addChild('description', $this->description);
		$xml->addChild('text', $this->text);

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
		if ($this->keywords !== null) {
			$xml->addChild('keywords', $this->keywords);
		}
		if ($this->image !== null) {
			$xml->addChild('image', $this->image);
		}
		if ($this->headlineImg !== null) {
			$xml->addChild('headlineImg', $this->headlineImg);
		}
		if ($this->pubDate !== null) {
			$xml->addChild('pubDate', date(DATE_RSS, $this->pubDate));
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
		$this->text = null;
		$this->categories = array();
		$this->image = null;
		$this->headlineImg = null;
		$this->keywords = null;
		$this->pubDate = null;
		$this->author = null;
		$this->sources = array();
	}
}