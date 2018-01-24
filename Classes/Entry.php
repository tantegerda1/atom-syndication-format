<?php
namespace Netztechniker\AtomSyndicationFormat;


/**
 * An RFC 4287 Atom feed entry
 *
 * @package Netztechniker\AtomSyndicationFormat
 * @author Ludwig Rafelsberger <info@netztechniker.at>, netztechniker.at
 * @date 2015-03-01
 *
 * @link https://tools.ietf.org/html/rfc4287#section-4.1.2
 */
class Entry
{

    /** Name of XML tag */
    const TAG_NAME = 'entry';



    // required
    /**
     * Entry ID
     *
     * Identifies the entry using a universally unique and permanent URI. Two entries in a feed can have the same id if
     * they represent the same entry at different points in time
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.6
     */
    protected $id;

    /**
     * Title
     *
     * A human readable title for the entry.
     *
     * @var Text
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.14
     */
    protected $title;

    /**
     * Last modification time
     *
     * Indicates the last time the entry was modified in a significant way. This value need not change after a typo is
     * fixed, only after a substantial modification.
     *
     * @var \DateTime
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.15
     */
    protected $updated;


    // recommended
    /**
     * Authors
     *
     * Names authors of the entry. An entry may have multiple author elements. An entry must contain at least one
     * author element unless there is an author element in the enclosing feed, or there is an author element in the
     * enclosed source element.
     *
     * @var \SplObjectStorage<Person>
     * @link https://tools.ietf.org/html/rfc4287#section-4.1.2
     */
    protected $authors;

    /**
     * Content
     *
     * Contains or links to the complete content of the entry. Content must be provided if there is no alternate link,
     * and should be provided if there is no summary.
     *
     * @var Content
     */
    protected $content;

    /**
     * Links
     *
     * Identifies related web pages and other resources. An entry must contain an alternate link if there is no content.
     *
     * @var \SplObjectStorage<Link>
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.7
     * @link https://tools.ietf.org/html/rfc5988#appendix-B
     */
    protected $links;

    /**
     * Summary
     *
     * Conveys a short summary, abstract, or excerpt of the entry. Summary should be provided if there either is no
     * content provided for the entry, or that content is not an inline type or it the content is of inline type other.
     *
     * @var Text
     */
    protected $summary;


    // optional
    /**
     * Categories that the entry belongs to
     *
     * @var \SplObjectStorage<Category>
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.2
     */
    protected $categories;

    /**
     * Contributors to the entry
     *
     * @var \SplObjectStorage<Person>
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.3
     */
    protected $contributors;

    /**
     * Time of the initial creation or first availability of the entry
     *
     * @var \DateTime
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.9
     */
    protected $published;

    /**
     * Source feed
     *
     * If an entry is copied from one feed into another feed, then the source feed‘s metadata (all child elements of
     * feed other than the entry elements) should be preserved if the source feed contains any of the child elements
     * author, contributor, rights, or category and those child elements are not present in the source entry.
     *
     * @var Feed
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.11
     */
    protected $source;

    /**
     * Rights
     *
     * Conveys information about rights, e.g. copyrights, held in and over the entry.
     *
     * @var Text
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.10
     */
    protected $rights;







    // ---------------------- object lifecycle methods ----------------------
    /**
     * Create a new Entry
     *
     * @param string $id Feed ID. Identifies the feed using a universally unique and permanent URI. Two entries in a
     *                   feed can have the same id if they represent the same entry at different points in time.
     * @param Text $title A human readable title for the entry
     * @param \DateTime $updated Last modification time (only significant modifications!)
     * @param \SplObjectStorage $authors Authors of the entry
     * @param Content $content Contains or links to the complete content of the entry
     * @param \SplObjectStorage $links Identifies related web pages and other resources. An entry must contain an
     *                                 alternate link if there is no content.
     * @param Text $summary Short summary, abstract or excerpt of the entry
     * @param \SplObjectStorage $categories Categories that the entry belongs to
     * @param \SplObjectStorage $contributors Contributors to the entry
     * @param \DateTime $published Time of the initial creation or first availability of the entry
     * @param Feed $source Source feed this entry is copied from
     * @param Text $rights information about rights, e.g. copyrights, held in and over the entry
     *
     * @throws \InvalidArgumentException 1425164408 if $id is not a valid Entry ID
     */
    public function __construct(
        $id, Text $title, \DateTime $updated,
        \SplObjectStorage $authors = null, Content $content = null, \SplObjectStorage $links = null,
        Text $summary = null,
        \SplObjectStorage $categories = null, \SplObjectStorage $contributors = null, \DateTime $published = null,
        Feed $source = null, Text $rights = null
    )
    {
        $this
            ->setId($id)
            ->setTitle($title)
            ->setUpdated($updated);
        $this->setAuthors(!is_null($authors) ? $authors : new \SplObjectStorage());
        if (!is_null($content)) {
            $this->setContent($content);
        }
        $this->setLinks(!is_null($links) ? $links : new \SplObjectStorage());
        if (!is_null($summary)) {
            $this->setSummary($summary);
        }
        $this->setCategories(!is_null($categories) ? $categories : new \SplObjectStorage());
        $this->setContributors(!is_null($contributors) ? $contributors : new \SplObjectStorage());
        if (!is_null($published)) {
            $this->setPublished($published);
        }
        if (!is_null($source)) {
            $this->setSource($source);
        }
        if (!is_null($rights)) {
            $this->rights = $rights;
        }
    }






    // -------------------------- classic methods ---------------------------
    /**
     * Create an XML node from the entry
     *
     * TODO: strip down and export source feed
     *
     * @param \DOMElement $entry A pre-existing XML node (otherwise it would not be editable)
     * @param \DOMDocument $xml A pre-existing DOM Document to create new editable nodes
     *
     * @return \DOMElement A XML node representing this entry
     */
    public function toXML(\DOMElement $entry, \DOMDocument $xml)
    {

        // required
        $entry->appendChild(new \DOMElement('id', $this->getId()));
        $entry->appendChild(new \DOMElement('updated', $this->getUpdated()->format(\DateTime::ATOM)));
        $entry->appendChild($this->getTitle()->toXML($xml->createElement('title')));

        // recommended
        foreach ($this->getAuthors() as $author) {
            /** @var Person $author */
            $entry->appendChild($author->toXML($xml->createElement('author')));
        }
        if ($this->hasContent()) {
            $entry->appendChild($this->getContent()->toXML($xml->createElement(Content::TAG_NAME)));
        }
        foreach ($this->getLinks() as $link) {
            /** @var Link $link */
            $entry->appendChild($link->toXML($xml->createElement(Link::TAG_NAME)));
        }
        if ($this->hasSummary()) {
            $entry->appendChild($this->getSummary()->toXML($xml->createElement('summary')));
        }

        // optional
        foreach ($this->getCategories() as $category) {
            /** @var Category $category */
            $entry->appendChild($category->toXML($xml->createElement(Category::TAG_NAME)));
        }
        foreach ($this->getContributors() as $contributor) {
            /** @var Person $contributor */
            $entry->appendChild($contributor->toXML($xml->createElement('contributor')));
        }
        if ($this->hasPublished()) {
            $entry->appendChild(new \DOMElement('published', $this->getPublished()->format(\DateTime::ATOM)));
        }
        // TODO source
        if ($this->hasRights()) {
            $entry->appendChild($this->getRights()->toXML($xml->createElement('rights')));
        }

        return $entry;
    }








    // -------------------------- accessor methods --------------------------
    /**
     * Get Entry ID
     *
     * @return string Entry ID. Identifies the entry using a universally unique and permanent URI.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Entry ID
     *
     * @param string $id Entry ID. Identifies the entry using a universally unique and permanent URI.
     *
     * @return Entry $this for fluent calls
     *
     * @throws \InvalidArgumentException 1425164408 if $id is not a valid Entry ID
     */
    public function setId($id)
    {
        if (!is_string($id) || '' === $id) {
            throw new \InvalidArgumentException('Argument $id is not a valid ID: ' . $id, 1425164408);
        }
        $this->id = $id;

        return $this;
    }

    /**
     * Get Title
     *
     * @return Text A human readable title for the entry. Often the same as the title of the associated website.
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set Title
     *
     * @param Text $title A human readable title for the entry. Often the same as the title of the associated website.
     *
     * @return Entry $this for fluent calls
     */
    public function setTitle(Text $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get last modification time
     *
     * @return \DateTime Last modification time (only significant modifications!).
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set last modification time
     *
     * @param \DateTime $updated Last modification time (only significant modifications!).
     *
     * @return Entry $this for fluent calls
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get Authors
     *
     * @return \SplObjectStorage<Person> Authors of the entry.
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Set Authors
     *
     * @param \SplObjectStorage $authors Authors of the entry
     *
     * @return Entry $this for fluent calls
     */
    public function setAuthors(\SplObjectStorage $authors)
    {
        $this->authors = $authors;

        return $this;
    }

    /**
     * Add an author to the list of authors of the entry
     *
     * @param Person $author The author to be added to the list of authors of the entry
     *
     * @return Entry $this for fluent calls
     */
    public function addAuthor(Person $author)
    {
        $this->authors->attach($author);

        return $this;
    }

    /**
     * Remove an author from the list of authors of the entry
     *
     * @param Person $author The author to be removed from the list of authors of the entry
     *
     * @return Entry $this for fluent calls
     */
    public function removeAuthor(Person $author)
    {
        $this->authors->detach($author);

        return $this;
    }

    /**
     * Get Content
     *
     * @return Content Contains or links to the complete content of the entry.
     * @throws \RuntimeException 1425164409 if the entry has no content set
     */
    public function getContent()
    {
        if (!$this->hasContent()) {
            throw new \RuntimeException('Entry has no content', 1425164409);
        }

        return $this->content;
    }

    /**
     * Set Content
     *
     * @param Content $content Content
     *
     * @return Entry $this for fluent calls
     */
    public function setContent(Content $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Test whether this entry has content
     *
     * @return boolean TRUE if this entry has content set, FALSE otherwise
     */
    public function hasContent()
    {
        return $this->content instanceof Content;
    }

    /**
     * Get Links
     *
     * @return \SplObjectStorage<Link> Related web pages and other resources
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set Links
     *
     * @param \SplObjectStorage $links Related web pages and other resources
     *
     * @return Entry $this for fluent calls
     */
    public function setLinks(\SplObjectStorage $links)
    {
        $this->links = $links;

        return $this;
    }

    /**
     * Add a link
     *
     * @param Link $link The link to be added to the list of links
     *
     * @return Entry $this for fluent calls
     */
    public function addLink(Link $link)
    {
        $this->links->attach($link);

        return $this;
    }

    /**
     * Remove a link
     *
     * @param Link $link The link to be removed from the list of links
     *
     * @return Entry $this for fluent calls
     */
    public function removeLink(Link $link)
    {
        $this->links->detach($link);

        return $this;
    }

    /**
     * Get Summary
     *
     * @return Text A short summary, abstract, or excerpt of the entry.
     * @throws \RuntimeException 1425164410 if the entry has no summary set
     */
    public function getSummary()
    {
        if (!$this->hasSummary()) {
            throw new \RuntimeException('Entry has no summary set', 1425164410);
        }

        return $this->summary;
    }

    /**
     * Set Summary
     *
     * @param Text $summary A short summary, abstract, or excerpt of the entry
     *
     * @return Entry $this for fluent calls
     */
    public function setSummary(Text $summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Test whether this entry has a summary set
     *
     * @return boolean TRUE if this entry has a summary set, FALSE otherwise
     */
    public function hasSummary()
    {
        return $this->summary instanceof Text;
    }

    /**
     * Get Categories
     *
     * @return \SplObjectStorage<Category> Categories that the entry belongs to
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set Categories
     *
     * @param \SplObjectStorage $categories Categories that the entry belongs to
     *
     * @return Entry $this for fluent calls
     */
    public function setCategories(\SplObjectStorage $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Add a category
     *
     * @param Category $category The category to be added to the list of categories
     *
     * @return Entry $this for fluent calls
     */
    public function addCategory(Category $category)
    {
        $this->categories->attach($category);

        return $this;
    }

    /**
     * Remove a category
     *
     * @param Category $category The category to be removed from the list of categories
     *
     * @return Entry $this for fluent calls
     */
    public function removeCategory(Category $category)
    {
        $this->categories->detach($category);

        return $this;
    }

    /**
     * Get Contributors
     *
     * @return \SplObjectStorage<Person> Contributors to the entry
     */
    public function getContributors()
    {
        return $this->contributors;
    }

    /**
     * Set Contributors
     *
     * @param \SplObjectStorage $contributors Contributors to the entry
     *
     * @return Entry $this for fluent calls
     */
    public function setContributors(\SplObjectStorage $contributors)
    {
        $this->contributors = $contributors;

        return $this;
    }

    /**
     * Add a contributor
     *
     * @param Person $contributor The contributor to be added to the list of contributor
     *
     * @return Entry $this for fluent calls
     */
    public function addContributor(Person $contributor)
    {
        $this->contributors->attach($contributor);

        return $this;
    }

    /**
     * Remove a contributor
     *
     * @param Person $contributor The contributor to be removed from the list of contributor
     *
     * @return Entry $this for fluent calls
     */
    public function removeContributor(Person $contributor)
    {
        $this->contributors->detach($contributor);

        return $this;
    }

    /**
     * Get Time of the initial creation or first availability of the entry
     *
     * @return \DateTime Time of the initial creation or first availability of the entry
     * @throws \RuntimeException 1425164411 if this entry has no time of initial creation or first availability set
     */
    public function getPublished()
    {
        if (!$this->hasPublished()) {
            throw new \RuntimeException('Entry has no time of initial creation set', 1425164411);
        }

        return $this->published;
    }

    /**
     * Set Published
     *
     * @param \DateTime $published Time of the initial creation or first availability of the entry
     *
     * @return Entry $this for fluent calls
     */
    public function setPublished(\DateTime $published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Test whether this entry has a time of the initial creation or first availability of the entry set
     *
     * @return boolean TRUE if the entry has time of the initial creation or first availability set, FALSE otherwise
     */
    public function hasPublished()
    {
        return $this->published instanceof \DateTime;
    }

    /**
     * Get Source
     *
     * @return Feed Source feed this entry is copied from
     * @throws \RuntimeException 1425164412 if this entry has no source feed set
     */
    public function getSource()
    {
        if (!$this->hasSource()) {
            throw new \RuntimeException('Entry has no source feed set', 1425164412);
        }

        return $this->source;
    }

    /**
     * Set Source
     *
     * @param Feed $source Source feed this entry is copied from
     *
     * @return Entry $this for fluent calls
     */
    public function setSource(Feed $source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Test whether this entry has a source feed set
     *
     * @return boolean TRUE if the entry has a source feed set, FALSE otherwise
     */
    public function hasSource()
    {
        return $this->source instanceof Feed;
    }

    /**
     * Get Rights
     *
     * @return Text Information about rights, e.g. copyrights, held in and over the entry
     * @throws \RuntimeException 1425164413 if the entry has no rights information set
     */
    public function getRights()
    {
        if (!$this->hasRights()) {
            throw new \RuntimeException('Feed has no rights information set', 1425164413);
        }

        return $this->rights;
    }

    /**
     * Set Rights
     *
     * @param Text $rights Information about rights, e.g. copyrights, held in and over the entry
     *
     * @return Entry $this for fluent calls
     */
    public function setRights(Text $rights)
    {
        $this->rights = $rights;

        return $this;
    }

    /**
     * Test whether this feed has information about rights set
     *
     * @return boolean TRUE if this feed has information about rights set, FALSE otherwise
     */
    public function hasRights()
    {
        return $this->rights instanceof Text;
    }
}
