<?php
namespace Netztechniker\AtomSyndicationFormat\Content;

use Netztechniker\AtomSyndicationFormat;


/**
 * OutOfLine Content
 *
 * Links to the content of an entry
 *
 * @package Netztechniker\Atom
 * @author Ludwig Rafelsberger <info@netztechniker.at>, netztechniker.at
 *
 * @see http://atomenabled.org/developers/syndication/#contentElement
 * @see https://tools.ietf.org/html/rfc4287#section-4.1.3
 */
class OutOfLine extends AtomSyndicationFormat\Content {

	// required
	/**
	 * IRI of the referenced resource
	 *
	 * @var string
	 * @see https://tools.ietf.org/html/rfc4287#section-4.1.3.2
	 * @see https://tools.ietf.org/html/rfc3987
	 */
	protected $src;


	// recommended
	/**
	 * MIME Media type of the resource
	 *
	 * @var string
	 * @see https://tools.ietf.org/html/rfc4287#section-4.1.3.1
	 * @see https://tools.ietf.org/html/rfc4287#ref-MIMEREG
	 */
	protected $type;






	// ---------------------- object lifecycle methods ----------------------
	/**
	 * Create a new OutOfLine Content
	 *
	 * @param string $src IRI of the referenced resource
	 * @param string $type MIME Media type of the resource
	 *
	 * @throws \InvalidArgumentException 1425164442 if $src is not a valid IRI
	 * @throws \InvalidArgumentException 1425164444 if $type is set but no valid MIME type
	 */
	public function __construct($src, $type = NULL) {
		$this->setSrc($src);
		if (!is_null($type)) {
			$this->setType($type);
		}
	}






	// -------------------------- classic methods ---------------------------
	/**
	 * Create an XML node from the content
	 *
	 * @param \DOMElement $de A pre-existing XML node (otherwise it would not be editable)
	 * @return \DOMElement A XML node representing this content
	 */
	public function toXML(\DOMElement $de) {
		$de->setAttribute('src', $this->getSrc());
		if ($this->hasType()) {
			$de->setAttribute('type', $this->getType());
		}
		return $de;
	}





	// -------------------------- accessor methods --------------------------
	/**
	 * Get Src
	 *
	 * @return string IRI of the referenced resource
	 */
	public function getSrc() {
		return $this->src;
	}

	/**
	 * Set Src
	 *
	 * @param string $src IRI of the referenced resource
	 * @return OutOfLine $this for fluent calls
	 * @throws \InvalidArgumentException 1425164442 if $src is not a valid IRI
	 */
	public function setSrc($src) {
		if (!is_string($src) || '' === $src) {
			throw new \InvalidArgumentException('Argument $src is not a valid IRI: ' . $src, 1425164442);
		}
		$this->src = $src;
		return $this;
	}

	/**
	 * Get Type
	 *
	 * @return string MIME Media type of the resource
	 * @throws \RuntimeException 1425164443 if the content defines no MIME Media type for the resource
	 */
	public function getType() {
		if (!$this->hasType()) {
			throw new \RuntimeException('OutOfLine content has no MIME Media Type set', 1425164443);
		}
		return $this->type;
	}

	/**
	 * Set Type
	 *
	 * @param string $type MIME Media type of the resource
	 * @return OutOfLine $this for fluent calls
	 * @throws \InvalidArgumentException 1425164444 if $type is no valid MIME type
	 */
	public function setType($type) {
		if (!is_string($type) || '' === $type || 1 !== preg_match(AtomSyndicationFormat\Link::MIME_PATTERN, $type)) {
			throw new \InvalidArgumentException('Argument $type is not a valid MIME type: ' . $type, 1425164444);
		}
		$this->type = $type;
		return $this;
	}

	/**
	 * Test whether this content has a MIME Media Type set or not
	 *
	 * @return TRUE if this content has a MIME Media Type set, FALSE otherwise
	 */
	public function hasType() {
		return is_string($this->type) && 1 === preg_match(AtomSyndicationFormat\Link::MIME_PATTERN, $this->type);
	}
}
