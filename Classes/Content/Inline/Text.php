<?php
declare(strict_types = 1);
namespace Netztechniker\AtomSyndicationFormat\Content\Inline;

use Netztechniker\AtomSyndicationFormat;


/**
 * Inline Text Content
 *
 * Contains the content of an entry as inline text - either plain text or entity encoded html.
 *
 * @package Netztechniker\AtomSyndicationFormat
 * @author Ludwig Rafelsberger <info@netztechniker.at>, netztechniker.at
 *
 * @link https://tools.ietf.org/html/rfc4287#section-4.1.3
 */
class Text extends AtomSyndicationFormat\Content\Inline
{

    // optional
    /**
     * Type of the content encoding
     *
     * Must be one of the TYPE_TEXT or TYPE_HTML constants. If not set, TYPE_TEXT is assumed.
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-4.1.3.1
     */
    protected $type = self::TYPE_TEXT;







    // ---------------------- object lifecycle methods ----------------------
    /**
     * Create a new Text Inline Content
     *
     * @param string $content Content; must be encoded according to $type.
     * @param string $type Type of the text encoding; one of the TYPE_TEXT of TYPE_HTML constants. If not set,
     *                     TYPE_TEXT is assumed.
     *
     * @throws \InvalidArgumentException 1425164447 if $content is not a valid content
     * @throws \InvalidArgumentException 1425164449 if $type is set but not a valid type
     */
    public function __construct(string $content, ?string $type = null)
    {
        $this->setContent($content);
        if (null !== $type) {
            $this->setType($type);
        }
    }






    // -------------------------- accessor methods --------------------------
    /**
     * Set Content
     *
     * @param string $content Content; encoded according to $this->type
     *
     * @return Text $this for fluent calls
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get Type
     *
     * @return string Type of the text encoding; one of the TYPE_TEXT or TYPE_HTML constants
     * @throws \RuntimeException 1425164448 if the content has no type set
     */
    public function getType(): string
    {
        if (!$this->hasType()) {
            throw new \RuntimeException('Inline text content has no type set', 1425164448);
        }

        return $this->type;
    }

    /**
     * Set Type
     *
     * @param string $type Type of the text encoding; one of the TYPE_TEXT or TYPE_HTML constants
     *
     * @return Text $this for fluent calls
     *
     * @throws \InvalidArgumentException 1425164449 if $type is not a valid type
     */
    public function setType(string $type): self
    {
        if (!in_array($type, [self::TYPE_TEXT, self::TYPE_HTML])) {
            throw new \InvalidArgumentException('Argument $type is not a valid encoding type: ' . $type, 1425164449);
        }
        $this->type = $type;

        return $this;
    }

    /**
     * Test whether this content has the type attribute set or not
     *
     * @return TRUE if this content has the type attribute set, FALSE otherwise
     */
    public function hasType(): bool
    {
        return is_string($this->type) && in_array($this->type, [self::TYPE_TEXT, self::TYPE_HTML]);
    }
}
