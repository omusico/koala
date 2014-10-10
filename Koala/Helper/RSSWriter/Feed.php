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
	/**
	 * rss tpl
	 * @var string
	 */
	protected $rss = '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" xmlns:wp="http://wordpress.org/export/1.0/" />';
	/** @var \Koala\Helper\RSSWriter\ChannelInterface[] */
	protected $channels = array();
	/**
	 * [__construct description]
	 * @param string $rss
	 */
	public function __construct($rss = null) {
		if ($rss !== null) {
			$this->rss = $rss;
		}
	}
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
		$xml = new SimpleXMLElement($this->rss, LIBXML_NOERROR|LIBXML_ERR_NONE|LIBXML_ERR_FATAL);

		foreach ($this->channels as $channel) {
			$toDom = dom_import_simplexml($xml);
			$fromDom = dom_import_simplexml($channel->asXML());
			$toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
		}

		$dom = new DOMDocument('1.0', 'UTF-8');
		$dom->appendChild($dom->importNode(dom_import_simplexml($xml), true));
		$dom->formatOutput = true;
		return str_replace(array('<::', '</::'), array('<', '</'), $dom->saveXML());
	}

	/**
	 * Render XML
	 * @return string
	 */
	public function __toString() {
		return $this->render();
	}
}