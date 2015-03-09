<?php
namespace Netztechniker\Atom;


/**
 * Content
 *
 * Contains or links to the content of an entry.
 *
 * @package Netztechniker\Atom\Domain\Model
 * @author Ludwig Rafelsberger <info@netztechniker.at>, netztechniker.at
 * @date 2015-03-01
 *
 * @see http://atomenabled.org/developers/syndication/#contentElement
 * @see https://tools.ietf.org/html/rfc4287#section-4.1.3
 */
abstract class Content {

	/** Name of XML tag */
	const TAG_NAME = 'content';



	/**
	 * Type
	 *
	 * @var string
	 * @see https://tools.ietf.org/html/rfc4287#section-4.1.3.1
	 */
	protected $type;





	// -------------------------- classic methods ---------------------------
	/**
	 * Create an XML node from the content
	 *
	 * @param \DOMElement $de pre-existing XML node (otherwise it would not be editable)
	 * @return \DOMElement A XML node representing this content
	 */
	abstract public function toXML(\DOMElement $de);




	// -------------------------- accessor methods --------------------------
	/**
	 * Set Type
	 *
	 * @param string $type Type
	 *
	 * @return Content $this for fluent calls
	 * @throws \InvalidArgumentException if $type is invalid in the current context
	 */
	abstract public function setType($type);

	/**
	 * Get Type
	 *
	 * @return string Type
	 * @throws \RuntimeException if the Content has no type attribute set
	 */
	abstract public function getType();
}