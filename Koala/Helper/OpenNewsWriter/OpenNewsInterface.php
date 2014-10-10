<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Koala\Helper\OpenNewsWriter;

use \Koala\Helper\OpenNewsWriter\ItemInterface;

interface OpenNewsInterface {
	/**
	 * Set webSite
	 * @param string $webSite
	 * @return $this
	 */
	public function webSite($webSite);
	/**
	 * Set webMaster
	 * @param string $webMaster
	 * @return $this
	 */
	public function webMaster($webMaster);
	/**
	 * Set updatePeri
	 * @param string $updatePeri
	 * @return $this
	 */
	public function updatePeri($updatePeri);
	/**
	 * Add item
	 * @param \Koala\Helper\OpenNewsWriter\ItemInterface $item
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