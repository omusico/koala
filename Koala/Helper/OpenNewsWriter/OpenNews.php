<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Koala\Helper\OpenNewsWriter;

use \DOMDocument;
use \Koala\Helper\OpenNewsWriter\ItemInterface;
use \Koala\Helper\OpenNewsWriter\SimpleXMLElement;

class OpenNews implements \Koala\Helper\OpenNewsWriter\OpenNewsInterface {
	/**
	 * tpl tpl
	 * @var string
	 */
	protected $tpl = '<document />';
	/** @var string */
	protected $webSite;
	/** @var string */
	protected $webMaster;
	/** @var string */
	protected $updatePeri;
	/** @var \Koala\Helper\OpenNewsWriter\ItemInterface[] */
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
	 * Set webSite
	 * @param string $webSite
	 * @return $this
	 */
	public function webSite($webSite) {
		$this->webSite = $webSite;
		return $this;
	}
	/**
	 * Set webMaster
	 * @param string $webMaster
	 * @return $this
	 */
	public function webMaster($webMaster) {
		$this->webMaster = $webMaster;
		return $this;
	}
	/**
	 * Set updatePeri
	 * @param string $updatePeri
	 * @return $this
	 */
	public function updatePeri($updatePeri) {
		$this->updatePeri = $updatePeri;
		return $this;
	}
	/**
	 * Add item
	 * @param \Koala\Helper\OpenNewsWriter\ItemInterface $item
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
		$xml->addChild('webSite', $this->webSite);
		$xml->addChild('webMaster', $this->webMaster);
		$xml->addChild('updatePeri', $this->updatePeri);

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