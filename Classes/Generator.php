<?php
namespace Netztechniker\AtomSyndicationFormat;


/**
 * Generator
 *
 * Identifies the agent used to generate a feed, for debugging and other purposes.
 *
 * @package Netztechniker\AtomSyndicationFormat
 * @author Ludwig Rafelsberger <info@netztechniker.at>, netztechniker.at
 *
 * @link http://atomenabled.org/developers/syndication/#optionalFeedElements
 * @link https://tools.ietf.org/html/rfc4287#section-4.2.4
 */
class Generator {

	/** Name of XML tag */
	const TAG_NAME = 'generator';



	// required
	/**
	 * Software used to generate the feed
	 *
	 * @var string
	 */
	protected $name;


	// optional
	/**
	 * URI
	 *
	 * An IRI that is relevant to the agent.
	 *
	 * @var string
	 */
	protected $uri;

	/**
	 * Version of the generating agent
	 *
	 * @var string
	 */
	protected $version;






	// ---------------------- object lifecycle methods ----------------------
	/**
	 * Create a new Generator
	 *
	 * @param string $name Software used to generate the feed
	 * @param string $uri An IRI that is relevant to the agent.
	 * @param string $version Version of the generating agent
	 *
	 * @throws \InvalidArgumentException 1425164418 if $name is not a valid name
	 * @throws \InvalidArgumentException 1425164420 if $uri is set but not a valid IRI
	 * @throws \InvalidArgumentException 1425164422 if $version is set but not a valid version
	 */
	public function __construct($name, $uri = NULL, $version = NULL) {
		$this->setName($name);
		if (!is_null($uri)) {
			$this->setUri($uri);
		}
		if (!is_null($version)) {
			$this->setVersion($version);
		}
	}





	// -------------------------- classic methods ---------------------------
	/**
	 * Create an XML node from the generator
	 *
	 * @param \DOMElement $de A pre-existing XML node (otherwise it would not be editable)
	 * @return \DOMElement A XML node representing this generator
	 */
	public function toXML(\DOMElement $de) {
		$de->nodeValue = $this->getName();
		if ($this->hasUri()) {
			$de->setAttribute('uri', $this->getUri());
		}
		if ($this->hasVersion()) {
			$de->setAttribute('version', $this->getVersion());
		}
		return $de;
	}






	// -------------------------- accessor methods --------------------------
	/**
	 * Get Name
	 *
	 * @return string Software used to generate the feed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Set Name
	 *
	 * @param string $name Software used to generate the feed
	 * @return Generator $this for fluent calls
	 * @throws \InvalidArgumentException 1425164418 if $name is not a valid name
	 */
	public function setName($name) {
		if (!is_string($name) || '' === $name) {
			throw new \InvalidArgumentException('Argument $name is not a valid name: ' . $name, 1425164418);
		}
		$this->name = $name;
		return $this;
	}

	/**
	 * Get Uri
	 *
	 * @return string An IRI that is relevant to the agent.
	 * @throws \RuntimeException 1425164419 if the generator has no uri set
	 */
	public function getUri() {
		if (!$this->hasUri()) {
			throw new \RuntimeException('Generator has no uri set', 1425164419);
		}
		return $this->uri;
	}

	/**
	 * Set Uri
	 *
	 * @param string $uri An IRI that is relevant to the agent.
	 * @return Generator $this for fluent calls
	 * @throws \InvalidArgumentException 1425164420 if $uri is not a valid IRI
	 */
	public function setUri($uri) {
		if (!is_string($uri) || '' === $uri) {
			throw new \InvalidArgumentException('Argument $uri is not a valid IRI: ' . $uri, 1425164420);
		}
		$this->uri = $uri;
		return $this;
	}

	/**
	 * Test whether this generator has a uri attribute set
	 *
	 * @return boolean TRUE if this generator has a uri attribute set, FALSE otherwise
	 */
	public function hasUri() {
		return is_string($this->uri) && '' !== $this->uri;
	}

	/**
	 * Get Version
	 *
	 * @return string Version of the generating agent
	 * @throws \RuntimeException 1425164421 if the generator has no version set
	 */
	public function getVersion() {
		if (!$this->hasVersion()) {
			throw new \RuntimeException('Generator has no version set', 1425164421);
		}
		return $this->version;
	}

	/**
	 * Set Version
	 *
	 * @param string $version Version of the generating agent
	 * @return Generator $this for fluent calls
	 * @throws \InvalidArgumentException 1425164422 if $version is not a valid version
	 */
	public function setVersion($version) {
		if (!is_string($version) || '' === $version) {
			throw new \InvalidArgumentException('Argument $version is not a valid version: ' . $version, 1425164422);
		}
		$this->version = $version;
		return $this;
	}

	/**
	 * Test whether this generator has a version attribute set
	 *
	 * @return boolean TRUE if this generator has a version attribute set, FALSE otherwise
	 */
	public function hasVersion() {
		return is_string($this->version) && '' !== $this->version;
	}
}
