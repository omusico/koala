<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Helper\RSSWriter;

use \Koala\Helper\RSSWriter\SimpleXMLElement;

class Channel implements \Koala\Helper\RSSWriter\ChannelInterface {
	/** @var string */
	protected $title;
	/** @var string */
	protected $link;
	/** @var string */
	protected $description;
	/** @var array */
	protected $categories = array();
	/** @var string */
	protected $clouds = array();
	/** @var string */
	protected $docs;
	/** @var string */
	protected $generator;
	/** @var string */
	protected $managingEditor;
	/** @var string */
	protected $rating;
	/** @var string */
	protected $webMaster;
	/** @var string */
	protected $language;
	/** @var string */
	protected $copyright;
	/** @var int */
	protected $pubDate;
	/** @var int */
	protected $lastBuildDate;
	/** @var int */
	protected $ttl;
	/** @var array */
	protected $skipDays = array();
	/** @var array */
	protected $skipHours = array();
	/** @var array */
	protected $textInput = array();
	/** @var array */
	protected $atomlink = array();
	/** @var \Koala\Helper\RSSWriter\ItemInterface[] */
	protected $items = array();
	/** @var \Koala\Helper\RSSWriter\ImageInterface[] */
	protected $images = array();

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
	 * Set channel title
	 * @param string $title
	 * @return $this
	 */
	public function title($title) {
		$this->title = $title;
		return $this;
	}
	/**
	 * Set channel URL
	 * @param string $link
	 * @return $this
	 */
	public function link($link) {
		$this->link = $link;
		return $this;
	}
	/**
	 * Set channel description
	 * @param string $description
	 * @return $this
	 */
	public function description($description) {
		$this->description = $description;
		return $this;
	}
	/**
	 * Set channel category
	 * @param string $name
	 */
	public function category($name, $domain = null) {
		$this->categories[] = array($name, $domain);
		return $this;
	}
	/**
	 * Set channel cloud
	 * @param  array $attrs
	 */
	public function cloud($attrs = array()) {
		$this->clouds = $attrs;
		return $this;
	}
	/**
	 * Set channel docs
	 * @param string $docs
	 */
	public function docs($docs) {
		$this->docs = $docs;
		return $this;
	}
	/**
	 * Set channel generator
	 * @param string $generator
	 */
	public function generator($generator) {
		$this->generator = $generator;
		return $this;
	}
	/**
	 * Set channel managingEditor
	 * @param string $managingEditor
	 */
	public function managingEditor($managingEditor) {
		$this->managingEditor = $managingEditor;
		return $this;
	}
	/**
	 * Set channel rating
	 * @param string $rating
	 */
	public function rating($rating) {
		$this->rating = $rating;
		return $this;
	}
	/**
	 * Set channel webMaster
	 * @param string $webMaster
	 */
	public function webMaster($webMaster) {
		$this->webMaster = $webMaster;
		return $this;
	}
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
	public function language($language) {
		$this->language = $language;
		return $this;
	}
	/**
	 * Set channel copyright
	 * @param string $copyright
	 * @return $this
	 */
	public function copyright($copyright) {
		$this->copyright = $copyright;
		return $this;
	}
	/**
	 * Set channel published date
	 * @param int $pubDate Unix timestamp
	 * @return $this
	 */
	public function pubDate($pubDate) {
		$this->pubDate = $pubDate;
		return $this;
	}
	/**
	 * Set channel last build date
	 * @param int $lastBuildDate Unix timestamp
	 * @return $this
	 */
	public function lastBuildDate($lastBuildDate) {
		$this->lastBuildDate = $lastBuildDate;
		return $this;
	}
	/**
	 * Set channel ttl (minutes)
	 * @param int $ttl
	 * @return $this
	 */
	public function ttl($ttl) {
		$this->ttl = $ttl;
		return $this;
	}
	/**
	 * Set channel skipHours (minutes)
	 * @param array $hours
	 * @return $this
	 */
	public function skipHours($hours = array()) {
		$this->skipHours = array_merge($this->skipHours, $hours);
		return $this;
	}
	/**
	 * Set channel skipDays (days)
	 * @param array $days
	 * @return $this
	 */
	public function skipDays($days = array()) {
		$this->skipDays = array_merge($this->skipDays, $days);
		return $this;
	}
	/**
	 * Set channel textInput
	 * @param array $textInput
	 * @return $this
	 */
	public function textInput($textInput = array()) {
		$this->textInput = $textInput;
		return $this;
	}
	/**
	 * Add item object
	 * @param \Koala\Helper\RSSWriter\ItemInterface $item
	 * @return $this
	 */
	public function addItem(ItemInterface $item) {
		$this->items[] = $item;
		return $this;
	}
	/**
	 * Add image object
	 * @param \Koala\Helper\RSSWriter\ImageInterface $image
	 * @return $this
	 */
	public function addImage(ImageInterface $image) {
		$this->images[] = $image;
		return $this;
	}
	/**
	 * Append to feed
	 * @param \Koala\Helper\RSSWriter\FeedInterface $feed
	 * @return $this
	 */
	public function appendTo(FeedInterface $feed) {
		$feed->addChannel($this);
		return $this;
	}
	/**
	 * Return XML object
	 * @return \Koala\Helper\RSSWriter\SimpleXMLElement
	 */
	public function asXML() {
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><channel></channel>', LIBXML_NOERROR|LIBXML_ERR_NONE|LIBXML_ERR_FATAL);
		$xml->addChild('title', $this->title);
		$xml->addChild('link', $this->link);
		$xml->addChild('description', $this->description);

		foreach ($this->categories as $category) {
			$element = $xml->addChild('category', $category[0]);

			if (isset($category[1])) {
				$element->addAttribute('domain', $category[1]);
			}
		}
		if (!empty($this->clouds)) {
			$element = $xml->addChild('cloud', null);
			foreach ($this->clouds as $attr => $value) {
				$element->addAttribute($attr, $value);
			}
		}
		if (!empty($this->atomlink)) {
			$element = $xml->addChild('::atom:link', null);
			foreach ($this->atomlink as $attr => $value) {
				$element->addAttribute($attr, $value);
			}
		}
		if ($this->docs !== null) {
			$xml->addChild('docs', $this->docs);
		}
		if ($this->generator !== null) {
			$xml->addChild('generator', $this->generator);
		}
		if ($this->managingEditor !== null) {
			$xml->addChild('managingEditor', $this->managingEditor);
		}
		if ($this->rating !== null) {
			$xml->addChild('rating', $this->rating);
		}
		if ($this->webMaster !== null) {
			$xml->addChild('webMaster', $this->webMaster);
		}
		if ($this->language !== null) {
			$xml->addChild('language', $this->language);
		}
		if ($this->copyright !== null) {
			$xml->addChild('copyright', $this->copyright);
		}
		if ($this->pubDate !== null) {
			$xml->addChild('pubDate', date(DATE_RSS, $this->pubDate));
		}
		if ($this->lastBuildDate !== null) {
			$xml->addChild('lastBuildDate', date(DATE_RSS, $this->lastBuildDate));
		}
		if ($this->ttl !== null) {
			$xml->addChild('ttl', $this->ttl);
		}
		if (!empty($this->skipDays)) {
			$element = $xml->addChild('skipDays', null);
			foreach ($this->skipDays as $day) {
				$element->addChild('day', $day);
			}
		}
		if (!empty($this->skipHours)) {
			$element = $xml->addChild('skipHours', null);
			foreach ($this->skipHours as $hour) {
				$element->addChild('hour', $hour);
			}
		}
		if (!empty($this->textInput)) {
			$element = $xml->addChild('textInput', null);
			foreach ($this->textInput as $node => $name) {
				$element->addChild($node, $name);
			}
		}
		foreach ($this->images as $item) {
			$toDom = dom_import_simplexml($xml);
			$fromDom = dom_import_simplexml($item->asXML());
			$toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
		}
		foreach ($this->items as $item) {
			$toDom = dom_import_simplexml($xml);
			$fromDom = dom_import_simplexml($item->asXML());
			$toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
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
		$this->clouds = array();
		$this->docs = null;
		$this->generator = null;
		$this->managingEditor = null;
		$this->rating = null;
		$this->webMaster = null;
		$this->language = null;
		$this->copyright = null;
		$this->pubDate = null;
		$this->lastBuildDate = null;
		$this->ttl = null;
		$this->skipDays = array();
		$this->skipHours = array();
		$this->textInput = array();
		$this->atomlink = array();
		/** @var \Koala\Helper\RSSWriter\ItemInterface[] */
		$this->items = array();
		/** @var \Koala\Helper\RSSWriter\ImageInterface[] */
		$this->images = array();
	}
}