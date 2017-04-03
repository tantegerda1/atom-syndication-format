<?php
namespace Netztechniker\AtomSyndicationFormat;


/**
 * Category
 *
 * Conveys information about a category associated with an entry or feed
 *
 * @package Netztechniker\AtomSyndicationFormat
 * @author Ludwig Rafelsberger <info@netztechniker.at>, netztechniker.at
 *
 * @link http://atomenabled.org/developers/syndication/#category
 * @link https://tools.ietf.org/html/rfc4287#section-4.2.2
 */
class Category
{

    /** Name of XML tag */
    const TAG_NAME = 'category';



    // required
    /**
     * Category identification
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.2.1
     */
    protected $term;


    // optional
    /**
     * Scheme
     *
     * An IRI that identifies a categorization scheme
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.2.2
     */
    protected $scheme;

    /**
     * Human-readable label for display in end-user applications
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.2.3
     */
    protected $label;






    // ---------------------- object lifecycle methods ----------------------
    /**
     * Create a new Category
     *
     * @param string $term Category identification
     * @param string $scheme IRI that identifies a categorization scheme
     * @param string $label Human-readable label for display in end-user applications
     *
     * @throws \InvalidArgumentException 1425164413 if $term is not a valid term
     * @throws \InvalidArgumentException 1425164415 if $scheme is set but not a valid IRI
     * @throws \InvalidArgumentException 1425164417 if $label is set bot not a valid label
     */
    public function __construct($term, $scheme = null, $label = null)
    {
        $this->setTerm($term);
        if (!is_null($scheme)) {
            $this->setScheme($scheme);
        }
        if (!is_null($label)) {
            $this->setLabel($label);
        }
    }







    // -------------------------- classic methods ---------------------------
    /**
     * Create an XML node from the Category
     *
     * @param \DOMElement $de A pre-existing XML node (otherwise it would not be editable)
     *
     * @return \DOMElement A XML node representing this category
     */
    public function toXML(\DOMElement $de)
    {
        $de->setAttribute('term', $this->getTerm());
        if ($this->hasScheme()) {
            $de->setAttribute('scheme', $this->getScheme());
        }
        if ($this->hasLabel()) {
            $de->setAttribute('label', $this->getLabel());
        }

        return $de;
    }








    // -------------------------- accessor methods --------------------------
    /**
     * Get Term
     *
     * @return string Category identification
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set Term
     *
     * @param string $term Category identification
     *
     * @return Category $this for fluent calls
     * @throws \InvalidArgumentException 1425164413 if $term is not a valid term
     */
    public function setTerm($term)
    {
        if (!is_string($term) || '' === $term) {
            throw new \InvalidArgumentException('Argument $term is not a valid term: ' . $term, 1425164413);
        }
        $this->term = $term;

        return $this;
    }

    /**
     * Get Scheme
     *
     * @return string IRI that identifies a categorization scheme
     * @throws \RuntimeException 1425164414 if the category has no scheme set
     */
    public function getScheme()
    {
        if (!$this->hasScheme()) {
            throw new \RuntimeException('Category has no scheme set', 1425164414);
        }

        return $this->scheme;
    }

    /**
     * Set Scheme
     *
     * @param string $scheme IRI that identifies a categorization scheme
     *
     * @return Category $this for fluent calls
     * @throws \InvalidArgumentException 1425164415 if $scheme is not a valid IRI
     */
    public function setScheme($scheme)
    {
        if (!is_string($scheme) || '' === $scheme) {
            throw new \InvalidArgumentException('Argument $scheme is not a valid IRI: ' . $scheme, 1425164415);
        }
        $this->scheme = $scheme;

        return $this;
    }

    /**
     * Test whether this category has a scheme attribute set
     *
     * @return TRUE if this category has a scheme attribute set, FALSE otherwise
     */
    public function hasScheme()
    {
        return is_string($this->scheme) && '' !== $this->scheme;
    }

    /**
     * Get Label
     *
     * @return string Human-readable label for display in end-user applications
     * @throws \RuntimeException 1425164416 if the category has no label set
     */
    public function getLabel()
    {
        if (!$this->hasLabel()) {
            throw new \RuntimeException('Category has no label set', 1425164416);
        }

        return $this->label;
    }

    /**
     * Set Label
     *
     * @param string $label Human-readable label for display in end-user applications
     *
     * @return Category $this for fluent calls
     * @throws \InvalidArgumentException 1425164417 if $label is not a valid label
     */
    public function setLabel($label)
    {
        if (!is_string($label) || '' === $label) {
            throw new \InvalidArgumentException('Argument $label is not a valid label: ' . $label, 1425164417);
        }
        $this->label = $label;

        return $this;
    }

    /**
     * Test whether this category has a human-readable label set
     *
     * @return TRUE if this category has a human-readable label set, FALSE otherwise
     */
    public function hasLabel()
    {
        return is_string($this->label) && '' !== $this->label;
    }
}
