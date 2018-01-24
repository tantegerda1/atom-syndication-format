<?php
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
     * @param boolean $isBase64Encoded TRUE if $content is already base64 encoded, FALSE otherwise
     *
     * @throws \InvalidArgumentException 1425164444 if $content is not a valid content
     * @throws \InvalidArgumentException 1425164446 if $type is set but no valid MIME type
     */
    public function __construct($content, $type = null, $isBase64Encoded = false)
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
     * Not that the content is always stored in base64 encoding.
     *
     * @param boolean $base64Decode Whether to decode the base64-encoding of the Content (TRUE) or not (FALSE)
     *
     * @return string Content
     */
    public function getContent($base64Decode = true)
    {
        if (true === $base64Decode) {
            return base64_decode($this->content);
        } else {
            return $this->content;
        }
    }

    /**
     * Set Content
     *
     * Stores the content in base64 encoding.
     *
     * @param string $content Content
     * @param boolean $isBase64Encoded TRUE if $content is already base64 encoded, FALSE otherwise
     *
     * @return Other $this for fluent calls
     * @throws \InvalidArgumentException 1425164444 if $content is not a valid content
     */
    public function setContent($content, $isBase64Encoded = false)
    {
        if (!is_string($content)) {
            throw new \InvalidArgumentException('Argument $content is not a valid content: ' . $content, 1425164444);
        }
        if (true === $isBase64Encoded) {
            $this->content = $content;
        } else {
            $this->content = base64_encode($content);
        }

        return $this;
    }

    /**
     * Get Type
     *
     * @return string MIME Media type of the resource
     * @throws \RuntimeException 1425164445 if the content defines no MIME Media type for the resource
     */
    public function getType()
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
    public function setType($type)
    {
        if (!is_string($type) || '' === $type || 1 !== preg_match(AtomSyndicationFormat\Link::MIME_PATTERN, $type)) {
            throw new \InvalidArgumentException('Argument $type is not a valid MIME type: ' . $type, 1425164446);
        }
        $this->type = $type;

        return $this;
    }

    /**
     * Test whether this content has a MIME Media Type set or not
     *
     * @return TRUE if this content has a MIME Media Type set, FALSE otherwise
     */
    public function hasType()
    {
        return is_string($this->type) && 1 === preg_match(AtomSyndicationFormat\Link::MIME_PATTERN, $this->type);
    }
}
