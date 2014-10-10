<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Koala\Helper\SitemapWriter;

use \Koala\Helper\SitemapWriter\ItemInterface;

interface SitemapInterface {
	/**
	 * Add item
	 * @param \Koala\Helper\SitemapWriter\ItemInterface $item
	 * @return $thisJ
	 */
	public function addItem(ItemInterface $item);

	/**
	 * Render XML
	 * @return string
	 */
	public function render();

	/**
	 * Render XML
	 * @return string
	 */
	public function __toString();
}