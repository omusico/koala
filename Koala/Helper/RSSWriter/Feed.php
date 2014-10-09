<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Koala\Helper\RSSWriter;

use \DOMDocument;
use \Koala\Helper\RSSWriter\ChannelInterface;
use \Koala\Helper\RSSWriter\SimpleXMLElement;

class Feed implements \Koala\Helper\RSSWriter\FeedInterface {
	/** @var \Koala\Helper\RSSWriter\ChannelInterface[] */
	protected $channels = array();

	/**
	 * Add channel
	 * @param \Koala\Helper\RSSWriter\ChannelInterface $channel
	 * @return $this
	 */
	public function addChannel(ChannelInterface $channel) {
		$this->channels[] = $channel;
		return $this;
	}

	/**
	 * Render XML
	 * @return string
	 */
	public function render() {
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><rss version="2.0" />', LIBXML_NOERROR|LIBXML_ERR_NONE|LIBXML_ERR_FATAL);

		foreach ($this->channels as $channel) {
			$toDom = dom_import_simplexml($xml);
			$fromDom = dom_import_simplexml($channel->asXML());
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