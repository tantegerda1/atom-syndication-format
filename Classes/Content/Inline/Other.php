<?php
declare(strict_types = 1);
namespace Netztechniker\AtomSyndicationFormat\Content\Inline;

use Netztechniker\AtomSyndicationFormat;

/**
 * Other Inline Content
 *
 * @package Netztechniker\Atom
 * @author Ludwig Rafelsberger <info@netztechniker.at>, netztechniker.at
 *
 * @link https://tools.ietf.org/html/rfc4287#section-4.1.3
 */
class Other extends AtomSyndicationFormat\Content\Inline
{

    // recommended
    /**
     * MIME Media type of the content
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-4.1.3.1
     * @link https://tools.ietf.org/html/rfc4287#ref-MIMEREG
     */
    protected $type;





    /**
     * Create a new Other Inline Content
     *
     * @param string $content Content
     * @param string $type MIME Media type of the content
     * @param bool $isBase64Encoded true if $content is already base64 encoded, false otherwise
     *
     * @throws \InvalidArgumentException 1425164444 if $content is not a valid content
     * @throws \InvalidArgumentException 1425164446 if $type is set but no valid MIME type
     */
    public function __construct(string $content, ?string $type = null, ?bool $isBase64Encoded = false)
    {
        $this->setContent($content, $isBase64Encoded);
        if (null !== $type) {
            $this->setType($type);
        }
    }





    // -------------------------- accessor methods --------------------------
    /**
     * Get Content
     *
     * Note that the content is always stored in base64 encoding.
     *
     * @param bool $base64Decode Whether to decode the base64-encoding of the Content (true) or not (false)
     *
     * @return string Content
     */
    public function getContent(?bool $base64Decode = true): string
    {
        return $base64Decode
            ? base64_decode($this->content)
            : $this->content;
    }

    /**
     * Set Content
     *
     * Stores the content in base64 encoding.
     *
     * @param string $content Content
     * @param bool $isBase64Encoded true if $content is already base64 encoded, false otherwise
     *
     * @return Other $this for fluent calls
     */
    public function setContent(string $content, ?bool $isBase64Encoded = false): self
    {
        $this->content = $isBase64Encoded
            ? $content
            : base64_encode($content);

        return $this;
    }

    /**
     * Get Type
     *
     * @return string MIME Media type of the resource
     * @throws \RuntimeException 1425164445 if the content defines no MIME Media type for the resource
     */
    public function getType(): string
    {
        if (!$this->hasType()) {
            throw new \RuntimeException('Inline other content has no MIME Media Type set', 1425164445);
        }

        return $this->type;
    }

    /**
     * Set Type
     *
     * @param string $type MIME Media type of the resource
     *
     * @return Other $this for fluent calls
     * @throws \InvalidArgumentException 1425164446 if $type is no valid MIME type
     */
    public function setType(string $type): self
    {
        if ('' === $type || 1 !== preg_match(AtomSyndicationFormat\Link::MIME_PATTERN, $type)) {
            throw new \InvalidArgumentException('Argument $type is not a valid MIME type: ' . $type, 1425164446);
        }
        $this->type = $type;

        return $this;
    }

    /**
     * Test whether this content has a MIME Media Type set or not
     *
     * @return true if this content has a MIME Media Type set, false otherwise
     */
    public function hasType(): bool
    {
        return is_string($this->type) && 1 === preg_match(AtomSyndicationFormat\Link::MIME_PATTERN, $this->type);
    }
}
