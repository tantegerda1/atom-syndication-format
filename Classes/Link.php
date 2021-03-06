<?php
declare(strict_types = 1);
namespace Netztechniker\AtomSyndicationFormat;

/**
 * Link
 *
 * Patterned after html’s link element.
 *
 * @package Netztechniker\AtomSyndicationFormat
 * @author Ludwig Rafelsberger <info@netztechniker.at>, netztechniker.at
 *
 * @link https://tools.ietf.org/html/rfc4287#section-4.2.7
 */
class Link
{

    /** Name of XML tag */
    public const TAG_NAME = 'link';

    /** An alternate representation of the entry or feed, for example a permalink to the html version of the entry,
     * or the front page of the weblog */
    public const REL_ALTERNATE = 'alternate';

    /** a related resource which is potentially large in size and might require special handling, for example an audio
     * or video recording */
    public const REL_ENCLOSURE = 'enclosure';

    /** A document related to the entry or feed */
    public const REL_RELATED = 'related';

    /** The feed or entry itself */
    public const REL_SELF = 'self';

    /** The source of the information provided in the entry */
    public const REL_VIA = 'via';

    /** Pattern to match a RFC 4288 MIME type
     *
     * @link https://tools.ietf.org/html/rfc4288#section-4.2
     */
    public const MIME_PATTERN = '%^[[:alpha:][:digit:]!#\\$&\\.\\+\\-\\^_]{1,127}/[[:alpha:][:digit:]!#\\$&\\.\\+\\-\\^_]{1,127}$%';

    /** Pattern to match a RFC 3066 Language Tag */
    public const LANG_PATTERN = '/^[[:alpha:]]{1,8}(\\-[[:alpha:][:digit:]]{1,8})?$/';




    // required
    /**
     * IRI of the referenced resource (typically a Web page)
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.7.1
     * @link https://tools.ietf.org/html/rfc3987
     */
    protected $href;


    // optional
    /**
     * Link relationship type
     *
     * It can be a full URI (for extensibility), or one of REL_* constants
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.7.2
     */
    protected $rel;

    /**
     * MIME Media type of the resource
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.7.3
     * @link https://tools.ietf.org/html/rfc4287#ref-MIMEREG
     */
    protected $type;

    /**
     * Language of the referenced resource
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.7.4
     * @link https://tools.ietf.org/html/rfc3066
     */
    protected $hreflang;

    /**
     * Human readable information about the link, typically for display purposes
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.7.5
     */
    protected $title;

    /**
     * Length of the resource (bytes)
     *
     * Note that the length attribute does not override the actual content length of the representation as reported
     * by the underlying protocol
     *
     * @var int
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.7.6
     */
    protected $length;







    // ---------------------- object lifecycle methods ----------------------
    /**
     * Create a new Link
     *
     * @param string $href IRI of the referenced resource (typically a Web page)
     * @param string $rel Link relationship type, can be a full URI (for extensibility) or one of REL_* constants
     * @param string $type MIME Media type of the resource
     * @param string $hreflang Language of the referenced resource
     * @param string $title Human readable information about the link, typically for display purposes.
     * @param int $length Length of the resource (bytes)
     *
     * @throws \InvalidArgumentException 1425164423 if $href is not a valid IRI
     * @throws \InvalidArgumentException 1425164425 if $rel is set but no valid link relationship type
     * @throws \InvalidArgumentException 1425164427 if $type is set but no valid MIME type
     * @throws \InvalidArgumentException 1425164429 if $hreflang is set but no valid RFC 3066 language tag
     * @throws \InvalidArgumentException 1425164431 if $title is set but no valid title
     * @throws \InvalidArgumentException 1425164433 if $length is set but not a valid length
     */
    public function __construct(string $href, ?string $rel = null, ?string $type = null, ?string $hreflang = null, ?string $title = null, ?int $length = null)
    {
        $this->setHref($href);
        if (null !== $rel) {
            $this->setRel($rel);
        }
        if (null !== $type) {
            $this->setType($type);
        }
        if (null !== $hreflang) {
            $this->setHreflang($hreflang);
        }
        if (null !== $title) {
            $this->setTitle($title);
        }
        if (null !== $length) {
            $this->setLength($length);
        }
    }






    // -------------------------- classic methods ---------------------------
    /**
     * Create an XML node from the link
     *
     * @param \DOMElement $de A pre-existing XML node (otherwise it would not be editable)
     *
     * @return \DOMElement A XML node representing this link
     */
    public function toXML(\DOMElement $de): \DOMElement
    {

        // required
        $de->setAttribute('href', $this->getHref());

        // optional
        if ($this->hasRel() && self::REL_ALTERNATE !== $this->getRel()) {
            $de->setAttribute('rel', $this->getRel());
        }
        if ($this->hasType()) {
            $de->setAttribute('type', $this->getType());
        }
        if ($this->hasHreflang()) {
            $de->setAttribute('hreflang', $this->getHreflang());
        }
        if ($this->hasTitle()) {
            $de->setAttribute('title', $this->getTitle());
        }
        if ($this->hasLength()) {
            $de->setAttribute('length', (string)$this->getLength());
        }

        return $de;
    }



    // -------------------------- accessor methods --------------------------
    /**
     * Get Href
     *
     * @return string IRI of the referenced resource (typically a Web page)
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * Set Href
     *
     * @param string $href IRI of the referenced resource (typically a Web page)
     *
     * @return Link $this for fluent calls
     * @throws \InvalidArgumentException 1425164423 if $href is not a valid IRI
     */
    public function setHref(string $href): self
    {
        if ('' === $href) {
            throw new \InvalidArgumentException('Argument $href is not a valid IRI: ' . $href, 1425164423);
        }
        $this->href = $href;
        return $this;
    }

    /**
     * Get Link relationship type
     *
     * @return string Link relationship type, can be a full URI (for extensibility) or one of REL_* constants
     * @throws \RuntimeException 1425164424 if the link has no rel attribute set
     */
    public function getRel(): string
    {
        if (!$this->hasRel()) {
            throw new \RuntimeException('Link has no rel attribute set', 1425164424);
        }
        return $this->rel;
    }

    /**
     * Set Link relationship type
     *
     * @param string $rel Link relationship type, can be a full URI (for extensibility) or one of REL_* constants
     *
     * @return Link $this for fluent calls
     * @throws \InvalidArgumentException 1425164425 if $rel is no valid link relationship type
     */
    public function setRel(string $rel): self
    {
        if ('' === $rel) {
            throw new \InvalidArgumentException(
                'Argument $rel is not a valid link relationship type: ' . $rel, 1425164425);
        }
        switch ($rel) {
            case self::REL_ALTERNATE:
            case self::REL_ENCLOSURE:
            case self::REL_RELATED:
            case self::REL_SELF:
            case self::REL_VIA:
                break;
            default:
                // no further investigation: extensibility allows IRIs and future IANA-registered simple types here
        }
        $this->rel = $rel;
        return $this;
    }

    /**
     * Test whether this link has a rel attribute or not
     *
     * @return true if this link has a rel attribute, false otherwise
     */
    public function hasRel(): bool
    {
        return is_string($this->rel) && '' !== $this->rel;
    }

    /**
     * Get Type
     *
     * @return string MIME Media type of the resource
     * @throws \RuntimeException 1425164426 if the link has no MIME Media Type set
     */
    public function getType(): string
    {
        if (!$this->hasType()) {
            throw new \RuntimeException('Link has no MIME Media Type set', 1425164426);
        }
        return $this->type;
    }

    /**
     * Set Type
     *
     * @param string $type MIME Media type of the resource
     *
     * @return Link $this for fluent calls
     * @throws \InvalidArgumentException 1425164427 if $type is no valid MIME type
     */
    public function setType(string $type): self
    {
        if ('' === $type || 1 !== preg_match(self::MIME_PATTERN, $type)) {
            throw new \InvalidArgumentException('Argument $type is not a valid MIME type: ' . $type, 1425164427);
        }
        $this->type = $type;
        return $this;
    }

    /**
     * Test whether this link has a MIME Media Type set or not
     *
     * @return true if this link has a MIME Media Type set, false otherwise
     */
    public function hasType(): bool
    {
        return is_string($this->type) && 1 === preg_match(self::MIME_PATTERN, $this->type);
    }

    /**
     * Get Language of the referenced resource
     *
     * @return string Language of the referenced resource, a RFC3066 language tag
     * @throws \RuntimeException 1425164428 if the link does not define the language of the reference
     */
    public function getHreflang(): string
    {
        if (!$this->hasHreflang()) {
            throw new \RuntimeException('Link does not define the language of the reference', 1425164428);
        }
        return $this->hreflang;
    }

    /**
     * Set Language of the referenced resource
     *
     * @param string $hreflang Language of the referenced resource, must be a RFC3066 language tag
     *
     * @return Link $this for fluent calls
     * @throws \InvalidArgumentException 1425164429 if $hreflang is no valid RFC 3066 language tag
     */
    public function setHreflang(string $hreflang): self
    {
        if ('' === $hreflang || 1 !== preg_match(self::LANG_PATTERN, $hreflang)) {
            throw new \InvalidArgumentException(
                'Argument $hreflang is not a valid language tag: ' . $hreflang, 1425164429);
        }
        $this->hreflang = $hreflang;
        return $this;
    }

    /**
     * Test whether this link defines the language of the reference or not
     *
     * @return true if this link defines the language of the reference, false otherwise
     */
    public function hasHreflang(): bool
    {
        return is_string($this->hreflang) && '' === $this->hreflang && 1 === preg_match(self::LANG_PATTERN, $this->hreflang);
    }

    /**
     * Get Title
     *
     * @return string Human-readable information about the link
     * @throws \RuntimeException 1425164430 if the link has no title set
     */
    public function getTitle(): string
    {
        if (!$this->hasTitle()) {
            throw new \RuntimeException('Link has no title set', 1425164430);
        }
        return $this->title;
    }

    /**
     * Set Title
     *
     * @param string $title Human-readable information about the link
     *
     * @return Link $this for fluent calls
     * @throws \InvalidArgumentException 1425164431 if $title is no valid title
     */
    public function setTitle(string $title): self
    {
        if ('' === $title) {
            throw new \InvalidArgumentException('Argument $title is not a valid title: ' . $title, 1425164431);
        }
        $this->title = $title;
        return $this;
    }

    /**
     * Test whether this link has a title attribute set or not
     *
     * @return true if this link has a title attribute set, false otherwise
     */
    public function hasTitle(): bool
    {
        return is_string($this->title) && '' !== $this->title;
    }

    /**
     * Get Length
     *
     * @return int Length of the resource (bytes)
     * @throws \RuntimeException 1425164432 if the link does not specify a length
     */
    public function getLength(): int
    {
        if (!$this->hasLength()) {
            throw new \RuntimeException('Link has no length specified', 1425164432);
        }
        return $this->length;
    }

    /**
     * Set Length
     *
     * @param int $length Length of the resource (bytes)
     *
     * @return Link $this for fluent calls
     * @throws \InvalidArgumentException 1425164433 if $length is not a valid length
     */
    public function setLength(int $length): self
    {
        if ($length < 0 || $length > PHP_INT_MAX) {
            throw new \InvalidArgumentException('Argument $length is not a valid length: ' . $length, 1425164433);
        }
        $this->length = $length;
        return $this;
    }

    /**
     * Test whether this link has a length specified or not
     *
     * @return true if this link has a length specified, false otherwise
     */
    public function hasLength(): bool
    {
        return is_int($this->length) && $this->length >= 0 && $this->length < PHP_INT_MAX;
    }
}
