<?php
namespace Netztechniker\AtomSyndicationFormat\Content;

use Netztechniker\AtomSyndicationFormat;


/**
 * Inline Content
 *
 * Contains the content of an entry.
 *
 * @package Netztechniker\AtomSyndicationFormat
 * @author Ludwig Rafelsberger <info@netztechniker.at>, netztechniker.at
 *
 * @see http://atomenabled.org/developers/syndication/#contentElement
 * @see https://tools.ietf.org/html/rfc4287#section-4.1.3
 */
abstract class Inline extends AtomSyndicationFormat\Content {

	/** Content contains plain text with no entity escaped html */
	const TYPE_TEXT = 'text';

	/** Content contains entity escaped html */
	const TYPE_HTML = 'html';

	/** Content contains inline xhtml, wrapped in a div element */
	const TYPE_XHTML = 'xhtml';



	// required
	/**
	 * Content
	 *
	 * @var string
	 */
	protected $content;






	// -------------------------- classic methods ---------------------------
	/**
	 * Create an XML node from the content
	 *
	 * @param \DOMElement $de A pre-existing XML node (otherwise it would not be editable)
	 * @return \DOMElement A XML node representing this content
	 * @throws \InvalidArgumentException if the $content is not valid in the current context
	 */
	public function toXML(\DOMElement $de) {
		$de->nodeValue = $this->getContent();
		if ($this->hasType() && $this->getType() !== self::TYPE_TEXT) {
			$de->setAttribute('type', $this->getType());
		}
		return $de;
	}






	// -------------------------- accessor methods --------------------------
	/**
	 * Get Content
	 *
	 * @return string Content; encoded according to $this->type
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Set Content
	 *
	 * @param string $content Content; must be encoded according to $this->type
	 * @return Inline $this for fluent calls
	 * @throws \InvalidArgumentException if the $content is not valid in the current context
	 */
	abstract public function setContent($content);

	/**
	 * Test whether this content has the type attribute set or not
	 *
	 * @return TRUE if this content has the type attribute set, FALSE otherwise
	 */
	abstract public function hasType();
}
