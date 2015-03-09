<?php
namespace Netztechniker\AtomSyndicationFormat\Content\Inline;

use Netztechniker\AtomSyndicationFormat;


/**
 * Inline Xhtml Content
 *
 * Contains the content of an entry as a single XHTML div element.
 *
 * @package Netztechniker\AtomSyndicationFormat
 * @author Ludwig Rafelsberger <info@netztechniker.at>, netztechniker.at
 *
 * @link http://atomenabled.org/developers/syndication/#contentElement
 * @link https://tools.ietf.org/html/rfc4287#section-4.1.3
 */
class Xhtml extends AtomSyndicationFormat\Content\Inline {

	// optional
	/**
	 * Type of the content encoding
	 *
	 * For XHTML this is always TYPE_XHTML.
	 *
	 * @var string
	 * @link https://tools.ietf.org/html/rfc4287#section-4.1.3.1
	 */
	protected $type = self::TYPE_XHTML;







	// ---------------------- object lifecycle methods ----------------------
	/**
	 * Create a new XHTML Inline Content
	 *
	 * @param string $content Content; must be encoded as one single XHTML div element
	 * @throws \InvalidArgumentException 1425164450 if $text is not a valid content
	 */
	public function __construct($content) {
		$this->setContent($content);
	}






	// -------------------------- accessor methods --------------------------
	/**
	 * Set Content
	 *
	 * Note that no encoding or encoding check happens here - you need to hand over a valid xhtml div element.
	 *
	 * @param string $content Content; must be encoded as one single XHTML div element
	 * @return Xhtml $this for fluent calls
	 * @throws \InvalidArgumentException 1425164450 if $text is not a valid content
	 */
	public function setContent($content) {
		if (!is_string($content)) {
			throw new \InvalidArgumentException('Argument $content is not a valid content: ' . $content, 1425164450);
		}
		$this->content = $content;
		return $this;
	}

	/**
	 * Set Type
	 *
	 * Note this method does nothing, it is here only because of inheritance. You cannot set the type of a xhtml
	 * content to anything else than 'xhtml'.
	 *
	 * @param string $type Type of the text encoding. Must be the TYPE_XHTML constant
	 * @return Xhtml $this for fluent calls
	 * @throws \InvalidArgumentException 1425164451 if $type is not TYPE_XHTML
	 */
	public function setType($type) {
		if ($type !== self::TYPE_HTML) {
			throw new \InvalidArgumentException(
				'Cannot set xhtml content type to anything but xhtml, tried ' . $type, 1425164451);
		}
		return $this;
	}

	/**
	 * Get Type
	 *
	 * @return string Type of the text encoding: self::TYPE_XHTML
	 */
	public function getType() {
		return self::TYPE_XHTML;
	}

	/**
	 * Test whether this content has the type attribute set
	 *
	 * @return boolean Always TRUE for this object type
	 */
	public function hasType() {
		return TRUE;
	}
}
