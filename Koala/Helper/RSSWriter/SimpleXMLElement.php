<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Koala\Helper\RSSWriter;

class SimpleXMLElement extends \SimpleXMLElement {
	public function addChild($name, $value = null, $namespace = null) {
		if ($value !== null and is_string($value) === true) {
			$value = str_replace(array('&', '<', '>'), array('&amp;', '&lt;', '&gt;'), $value);
		}
		//<![CDATA[ ?
		return parent::addChild($name, $value, $namespace);
	}
}