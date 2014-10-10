<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Koala\Helper\SitemapWriter;

use \DOMDocument;
use \Koala\Helper\SitemapWriter\ItemInterface;
use \Koala\Helper\SitemapWriter\SimpleXMLElement;

class Sitemap implements \Koala\Helper\SitemapWriter\SitemapInterface {
	/**
	 * tpl tpl
	 * @var string
	 */
	protected $tpl = '<urlset />';
	/** @var \Koala\Helper\SitemapWriter\ItemInterface[] */
	protected $items = array();
	/**
	 * [__construct description]
	 * @param string $tpl
	 */
	public function __construct($tpl = null) {
		if ($tpl !== null) {
			$this->tpl = $tpl;
		}
	}
	/**
	 * Add item
	 * @param \Koala\Helper\SitemapWriter\ItemInterface $item
	 * @return $this
	 */
	public function addItem(ItemInterface $item) {
		$this->items[] = $item;
		return $this;
	}

	/**
	 * Render XML
	 * @return string
	 */
	public function render() {
		$xml = new SimpleXMLElement($this->tpl, LIBXML_NOERROR|LIBXML_ERR_NONE|LIBXML_ERR_FATAL);

		foreach ($this->items as $item) {
			$toDom = dom_import_simplexml($xml);
			$fromDom = dom_import_simplexml($item->asXML());
			$toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
		}

		$dom = new DOMDocument('1.0', 'UTF-8');
		$dom->appendChild($dom->importNode(dom_import_simplexml($xml), true));
		$dom->formatOutput = true;
		return $dom->saveXML();
	}

	/**
	 * Render XML
	 * @return string
	 */
	public function __toString() {
		return $this->render();
	}
}