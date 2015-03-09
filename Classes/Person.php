<?php
namespace Netztechniker\AtomSyndicationFormat;


/**
 * Person
 *
 * Describes a person, corporation, or similar entity.
 *
 * @package Netztechniker\AtomSyndicationFormat
 * @author Ludwig Rafelsberger <info@netztechniker.at>, netztechniker.at
 * @date 2015-03-01
 *
 * @see http://atomenabled.org/developers/syndication/#person
 * @see https://tools.ietf.org/html/rfc4287#section-3.2
 */
class Person {

	// required
	/**
	 * Name
	 *
	 * Human readable name for the person
	 *
	 * @var string
	 * @see https://tools.ietf.org/html/rfc4287#section-3.2.1
	 */
	protected $name;


	// optional
	/**
	 * URI
	 *
	 * An IRI associated with the person (e.g. their website)
	 *
	 * @var string
	 * @see https://tools.ietf.org/html/rfc4287#section-3.2.2
	 * @see https://tools.ietf.org/html/rfc3987 (Internationalized Resource Identifiers IRIs)
	 */
	protected $uri;

	/**
	 * Email
	 *
	 * @var string E-mail address associated with the person
	 * @see https://tools.ietf.org/html/rfc4287#section-3.2.3
	 * @see https://tools.ietf.org/html/rfc2822
	 */
	protected $email;






	// ---------------------- object lifecycle methods ----------------------
	/**
	 * Create a new Person
	 *
	 * @param string $name Human readable name for the person
	 * @param string $uri URI identifying a website of/for the person
	 * @param string $email Email address
	 *
	 * @throws \InvalidArgumentException 1425164434 if $name is not a valid name
	 * @throws \InvalidArgumentException 1425164436 if $uri is set but not a valid IRI
	 * @throws \InvalidArgumentException 1425164438 if $email is set but not a valid email address
	 */
	public function __construct($name, $uri = NULL, $email = NULL) {
		$this->setName($name);
		if (!is_null($uri)) {
			$this->setUri($uri);
		}
		if (!is_null($email)) {
			$this->setEmail($email);
		}
	}






	// -------------------------- classic methods ---------------------------
	/**
	 * Create an XML node from the Person
	 *
	 * @param \DOMElement $de A pre-existing XML node (otherwise it would not be editable)
	 * @return \DOMElement A XML node representing this person
	 */
	public function toXML(\DOMElement $de) {
		$de->appendChild(new \DOMElement('name', $this->getName()));
		if ($this->hasUri()) {
			$de->appendChild(new \DOMElement('uri', $this->getUri()));
		}
		if ($this->hasEmail()) {
			$de->appendChild(new \DOMElement('email', $this->getEmail()));
		}
		return $de;
	}





	// -------------------------- accessor methods --------------------------
	/**
	 * Get name
	 *
	 * @return string Human readable name for the person
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Set name
	 *
	 * @param string $name Human readable name for the person
	 * @return Person $this for fluent calls
	 *
	 * @throws \InvalidArgumentException 1425164434 if $name is not a valid name
	 */
	public function setName($name) {
		if (!is_string($name) || '' === $name) {
			throw new \InvalidArgumentException('Argument $name is not a valid name: ' . $name, 1425164434);
		}
		$this->name = $name;
		return $this;
	}

	/**
	 * Get URI
	 *
	 * @return string An IRI associated with the person (e.g. their website)
	 * @throws \RuntimeException 1425164435 if the person has no URI set
	 */
	public function getUri() {
		if (!$this->hasUri()) {
			throw new \RuntimeException('Person has no URI set', 1425164435);
		}
		return $this->uri;
	}

	/**
	 * Set URI
	 *
	 * @param string $uri An IRI associated with the person (e.g. their website)
	 * @return Person $this for fluent calls
	 * @throws \InvalidArgumentException 1425164436 if $uri is not a valid IRI
	 */
	public function setUri($uri) {
		if (!is_string($uri) || '' === $uri) {
			throw new \InvalidArgumentException('Argument $uri is not a valid IRI: ' . $uri, 1425164436);
		}
		$this->uri = $uri;
		return $this;
	}

	/**
	 * Test whether this person has a uri attribute set
	 *
	 * @return TRUE if this person has a uri attribute set, FALSE otherwise
	 */
	public function hasUri() {
		return is_string($this->uri) && '' !== $this->uri;
	}

	/**
	 * Get email
	 *
	 * @return string Email address
	 * @throws \RuntimeException 1425164437 if the person has no valid email address set
	 */
	public function getEmail() {
		if (!$this->hasEmail()) {
			throw new \RuntimeException('Person has no valid email address set', 1425164437);
		}
		return $this->email;
	}

	/**
	 * Set email
	 *
	 * @param string $email Email address
	 * @return Person $this for fluent calls
	 *
	 * @throws \InvalidArgumentException 1425164438 if $email is not a valid email address
	 */
	public function setEmail($email) {
		if ($email !== filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new \InvalidArgumentException('Argument $email is not a valid email address: ' . $email, 1425164438);
		}
		$this->email = $email;
		return $this;
	}

	/**
	 * Test whether this person has a valid email address set
	 *
	 * @return TRUE if this person has a valid email address set, FALSE otherwise
	 */
	public function hasEmail() {
		return $this->email === filter_var($this->email, FILTER_VALIDATE_EMAIL);
	}
}
