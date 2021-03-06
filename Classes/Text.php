<?php
declare(strict_types = 1);
namespace Netztechniker\AtomSyndicationFormat;

/**
 * An Atom Text
 *
 * Contain human-readable text - usually in small quantities - and definition about how it is encoded.
 *
 * @package Netztechniker\AtomSyndicationFormat
 * @author Ludwig Rafelsberger <info@netztechniker.at>, netztechniker.at
 *
 * @link https://tools.ietf.org/html/rfc4287#section-3.1
 */
class Text
{

    /** This text contains plain text with no entity escaped html */
    public const TYPE_TEXT = 'text';

    /** This text contains entity escaped html */
    public const TYPE_HTML = 'html';

    /** This element contains inline xhtml, wrapped in a div element */
    public const TYPE_XHTML = 'xhtml';




    // required
    /**
     * Text
     *
     * @var string
     */
    protected $text;


    // optional
    /**
     * Type of the text encoding
     *
     * Must be one of the TYPE_* constants. If not set, TYPE_TEXT is assumed.
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-3.1.1
     */
    protected $type = self::TYPE_TEXT;







    // ---------------------- object lifecycle methods ----------------------

    /**
     * Create a new Text
     *
     * @param string $text Text
     * @param string $type Type of the text encoding; one of the TYPE_* constants
     *
     * @throws \InvalidArgumentException 1425164439 if $text is not a valid text
     * @throws \InvalidArgumentException 1425164441 if $type is set but not a valid type
     */
    public function __construct(string $text, ?string $type = null)
    {
        $this->setText($text);
        if (null !== $type) {
            $this->setType($type);
        }
    }





    // -------------------------- classic methods ---------------------------
    /**
     * Create an XML node from the text
     *
     * @param \DOMElement $de A pre-existing XML node (otherwise it would not be editable)
     *
     * @return \DOMElement A XML node representing this text
     */
    public function toXML(\DOMElement $de): \DOMElement
    {
        $de->nodeValue = $this->getText();
        if ($this->hasType() && self::TYPE_TEXT !== $this->getType()) {
            $de->setAttribute('type', $this->getType());
        }

        return $de;
    }





    // -------------------------- accessor methods --------------------------
    /**
     * Get Text
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Set Text
     *
     * @param string $text Text
     *
     * @return Text $this for fluent calls
     * @throws \InvalidArgumentException 1425164439 if $text is not a valid text
     */
    public function setText(string $text): self
    {
        if (!is_string($text)) {
            throw new \InvalidArgumentException('Argument $text is not a valid text: ' . $text, 1425164439);
        }
        $this->text = $text;
        return $this;
    }

    /**
     * Get Type
     *
     * @return string Type of the text encoding; one of the TYPE_* constants
     * @throws \RuntimeException 1425164440 if the text has no type set
     */
    public function getType(): string
    {
        if (!$this->hasType()) {
            throw new \RuntimeException('Generator has no type set', 1425164440);
        }
        return $this->type;
    }

    /**
     * Set Type
     *
     * @param string $type Type of the text encoding; must be one of the TYPE_* constants
     *
     * @return Text $this for fluent calls
     * @throws \InvalidArgumentException 1425164441 if $type is not a valid type
     */
    public function setType(string $type): self
    {
        if (!in_array($type, [self::TYPE_TEXT, self::TYPE_HTML, self::TYPE_XHTML], true)) {
            throw new \InvalidArgumentException('Argument $type is not a valid encoding type: ' . $type, 1425164441);
        }
        $this->type = $type;
        return $this;
    }

    /**
     * Test whether this text has a type attribute set
     *
     * @return bool true if this text has a type attribute set, false otherwise
     */
    public function hasType(): bool
    {
        return is_string($this->type) && in_array($this->type, [self::TYPE_TEXT, self::TYPE_HTML, self::TYPE_XHTML], true);
    }
}
