<?php
declare(strict_types = 1);
namespace Netztechniker\AtomSyndicationFormat;

/**
 * Person
 *
 * Describes a person, corporation, or similar entity.
 *
 * @package Netztechniker\AtomSyndicationFormat
 * @author Ludwig Rafelsberger <info@netztechniker.at>, netztechniker.at
 *
 * @link https://tools.ietf.org/html/rfc4287#section-3.2
 */
class Person
{

    // required
    /**
     * Name
     *
     * Human readable name for the person
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-3.2.1
     */
    protected $name;


    // optional
    /**
     * URI
     *
     * An IRI associated with the person (e.g. their website)
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-3.2.2
     * @link https://tools.ietf.org/html/rfc3987 (Internationalized Resource Identifiers IRIs)
     */
    protected $uri;

    /**
     * Email
     *
     * @var string E-mail address associated with the person
     * @link https://tools.ietf.org/html/rfc4287#section-3.2.3
     * @link https://tools.ietf.org/html/rfc2822
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
    public function __construct(string $name, ?string $uri = null, ?string $email = null)
    {
        $this->setName($name);
        if (null !== $uri) {
            $this->setUri($uri);
        }
        if (null !== $email) {
            $this->setEmail($email);
        }
    }






    // -------------------------- classic methods ---------------------------
    /**
     * Create an XML node from the Person
     *
     * @param \DOMElement $de A pre-existing XML node (otherwise it would not be editable)
     *
     * @return \DOMElement A XML node representing this person
     */
    public function toXML(\DOMElement $de): \DOMElement
    {
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name Human readable name for the person
     *
     * @return Person $this for fluent calls
     *
     * @throws \InvalidArgumentException 1425164434 if $name is not a valid name
     */
    public function setName(string $name): self
    {
        if ('' === $name) {
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
    public function getUri(): string
    {
        if (!$this->hasUri()) {
            throw new \RuntimeException('Person has no URI set', 1425164435);
        }
        return $this->uri;
    }

    /**
     * Set URI
     *
     * @param string $uri An IRI associated with the person (e.g. their website)
     *
     * @return Person $this for fluent calls
     * @throws \InvalidArgumentException 1425164436 if $uri is not a valid IRI
     */
    public function setUri(string $uri): self
    {
        if ('' === $uri) {
            throw new \InvalidArgumentException('Argument $uri is not a valid IRI: ' . $uri, 1425164436);
        }
        $this->uri = $uri;
        return $this;
    }

    /**
     * Test whether this person has a uri attribute set
     *
     * @return true if this person has a uri attribute set, false otherwise
     */
    public function hasUri(): bool
    {
        return is_string($this->uri) && '' !== $this->uri;
    }

    /**
     * Get email
     *
     * @return string Email address
     * @throws \RuntimeException 1425164437 if the person has no valid email address set
     */
    public function getEmail(): string
    {
        if (!$this->hasEmail()) {
            throw new \RuntimeException('Person has no valid email address set', 1425164437);
        }
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email Email address
     *
     * @return Person $this for fluent calls
     *
     * @throws \InvalidArgumentException 1425164438 if $email is not a valid email address
     */
    public function setEmail(string $email): self
    {
        if ($email !== filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Argument $email is not a valid email address: ' . $email, 1425164438);
        }
        $this->email = $email;
        return $this;
    }

    /**
     * Test whether this person has a valid email address set
     *
     * @return true if this person has a valid email address set, false otherwise
     */
    public function hasEmail(): bool
    {
        return $this->email === filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }
}
