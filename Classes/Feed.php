<?php
declare(strict_types = 1);
namespace Netztechniker\AtomSyndicationFormat;

/**
 * An RFC 4287 Atom feed
 *
 * @package Netztechniker\AtomSyndicationFormat
 * @author Ludwig Rafelsberger <info@netztechniker.at>, netztechniker.at
 *
 * @link https://tools.ietf.org/html/rfc4287#section-4.1.1
 */
class Feed
{

    // required
    /**
     * Feed ID
     *
     * Identifies the feed using a universally unique and permanent URI. If you have a long-term, renewable lease
     * on your Internet domain name, then you can feel free to use your website’s address.
     *
     * @var string
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.6
     */
    protected $id;

    /**
     * Title
     *
     * A human readable title for the feed. Often the same as the title of the associated website.
     *
     * @var Text
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.14
     */
    protected $title;

    /**
     * Last modification time
     *
     * Indicates the last time the feed was modified in a significant way.
     *
     * (As I understand that definition, these "significant updates" refer to feed "properties", rather than entry
     * elements - meaning the last modification date needs no change when new entries are published, but should be
     * changed when e.g. the icon changes.)
     *
     * TODO: recheck my interpretation of the standard
     *
     * @var \DateTime
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.15
     */
    protected $updated;


    // recommended
    /**
     * Authors
     *
     * Names authors of the feed. A feed may have multiple author elements. A feed must contain at least one
     * author element unless all of the entry elements contain at least one author element.
     *
     * @var \SplObjectStorage<Person>
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.1
     */
    protected $authors;

    /**
     * Links
     *
     * Identifies related web pages and other resources. A feed should contain a link back to the feed itself (with
     * rel=self).
     *
     * @var \SplObjectStorage<Link>
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.7
     * @link https://tools.ietf.org/html/rfc5988#appendix-B
     */
    protected $links;


    // optional
    /**
     * Categories that the feed belongs to
     *
     * @var \SplObjectStorage<Category>
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.2
     */
    protected $categories;

    /**
     * Contributors to the feed
     *
     * @var \SplObjectStorage<Person>
     */
    protected $contributors;

    /**
     * Generator
     *
     * Identifies the agent used to generate a feed, for debugging and other purposes.
     *
     * @var Generator|NULL
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.4
     */
    protected $generator;

    /**
     * Icon
     *
     * IRI reference to a small image which provides iconic visual identification for the feed. Should be square.
     *
     * @var string|NULL
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.5
     */
    protected $icon;

    /**
     * Logo
     *
     * IRI reference to an image that provides visual identification for the feed. Should be twice as wide as it is
     * tall.
     *
     * @var string|NULL
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.8
     */
    protected $logo;

    /**
     * Rights
     *
     * Conveys information about rights, e.g. copyrights, held in and over the feed.
     *
     * @var Text|NULL
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.10
     */
    protected $rights;

    /**
     * Subtitle
     *
     * Human readable description or subtitle for the feed.
     *
     * @var Text|NULL
     * @link https://tools.ietf.org/html/rfc4287#section-4.2.12
     */
    protected $subtitle;


    // entries
    /**
     * Entries
     *
     * @var \SplObjectStorage<Entry>
     * @link https://tools.ietf.org/html/rfc4287#section-4.1.2
     */
    protected $entries;






    // ---------------------- object lifecycle methods ----------------------
    /**
     * Create a new RFC 4287 Atom feed
     *
     * @param string $id Feed ID. Identifies the feed using a universally unique and permanent URI.
     * @param Text $title A human readable title for the feed. Often the same as the title of the associated website.
     * @param \DateTime $updated Last modification time (only significant modifications!).
     * @param \SplObjectStorage $authors Authors of the feed
     * @param \SplObjectStorage $links Identifies related web pages and other resources. A feed should contain a
     *                                   link back to the feed itself (with rel=self).
     * @param \SplObjectStorage $categories Categories that the feed belongs to
     * @param \SplObjectStorage $contributors Contributors to the feed
     * @param Generator $generator The agent used to generate a feed, for debugging and other purposes
     * @param string $icon IRI reference to a small image which provides iconic visual identification for the feed.
     *                     Should be square.
     * @param string $logo IRI reference to an image that provides visual identification for the feed. Should be twice
     *                     as wide as it is tall.
     * @param Text $rights Information about rights, e.g. copyrights, held in and over the feed
     * @param Text $subtitle Human readable description or subtitle for the feed
     * @param \SplObjectStorage $entries Entries
     *
     * @throws \InvalidArgumentException 1425164400 if $id is not a valid Feed ID
     * @throws \InvalidArgumentException 1425164403 if $icon is set but not a valid icon
     * @throws \InvalidArgumentException 1425164405 if $logo is set but not a valid logo
     */
    public function __construct(
        string $id, Text $title, \DateTime $updated,
        \SplObjectStorage $authors = null, \SplObjectStorage $links = null,
        \SplObjectStorage $categories = null, \SplObjectStorage $contributors = null, Generator $generator = null,
        ?string $icon = null, ?string $logo = null, Text $rights = null, Text $subtitle = null,
        \SplObjectStorage $entries = null
    )
    {
        $this
            ->setId($id)
            ->setTitle($title)
            ->setUpdated($updated);
        $this->setAuthors($authors ?? new \SplObjectStorage());
        $this->setLinks($links ?? new \SplObjectStorage());
        $this->setCategories($categories ?? new \SplObjectStorage());
        $this->setContributors($contributors ?? new \SplObjectStorage());
        if (null !== $generator) {
            $this->setGenerator($generator);
        }
        if (null !== $icon) {
            $this->setIcon($icon);
        }
        if (null !== $logo) {
            $this->setLogo($logo);
        }
        if (null !== $rights) {
            $this->setRights($rights);
        }
        if (null !== $subtitle) {
            $this->setSubtitle($subtitle);
        }
        $this->setEntries($entries ?? new \SplObjectStorage());
    }







    // -------------------------- classic methods ---------------------------
    /**
     * Create an XML string from this feed
     *
     * Note that that an Atom document must be served as MIME type application/atom+xml.
     *
     * @return string An XML string representing this feed
     * @link https://tools.ietf.org/html/rfc4287#section-7
     */
    public function __toString(): string
    {
        // required
        $xml = new \DOMDocument('1.0', 'utf-8');
        $feed = $xml->createElementNS('http://www.w3.org/2005/Atom', 'feed');
        $xml->appendChild($feed);

        // recommended
        $feed->appendChild(new \DOMElement('id', $this->getId()));
        $feed->appendChild($this->getTitle()->toXML($xml->createElement('title')));
        $feed->appendChild(new \DOMElement('updated', $this->getUpdated()->format(\DateTime::ATOM)));

        foreach ($this->getAuthors() as $author) {
            /** @var Person $author */
            $feed->appendChild($author->toXML($xml->createElement('author')));
        }
        foreach ($this->getLinks() as $link) {
            /** @var Link $link */
            $feed->appendChild($link->toXML($xml->createElement(Link::TAG_NAME)));
        }

        // optional
        foreach ($this->getCategories() as $category) {
            /** @var Category $category */
            $feed->appendChild($category->toXML($xml->createElement(Category::TAG_NAME)));
        }
        foreach ($this->getContributors() as $contributor) {
            /** @var Person $contributor */
            $feed->appendChild($contributor->toXML($xml->createElement('contributor')));
        }
        if ($this->hasGenerator()) {
            $feed->appendChild($this->getGenerator()->toXML($xml->createElement(Generator::TAG_NAME)));
        }
        if ($this->hasIcon()) {
            $feed->appendChild(new \DOMElement('icon', $this->getIcon()));
        }
        if ($this->hasLogo()) {
            $feed->appendChild(new \DOMElement('logo', $this->getLogo()));
        }
        if ($this->hasRights()) {
            $feed->appendChild($this->getRights()->toXML($xml->createElement('rights')));
        }
        if ($this->hasSubtitle()) {
            $feed->appendChild($this->getSubtitle()->toXML($xml->createElement('subtitle')));
        }

        // entries
        foreach ($this->getEntries() as $entry) {
            /** @var Entry $entry */
            $feed->appendChild($entry->toXML($xml->createElement(Entry::TAG_NAME), $xml));
        }

        $xml->formatOutput = true;
        return $xml->saveXML();
    }






    // -------------------------- accessor methods --------------------------
    /**
     * Get Feed ID
     *
     * @return string Feed ID. Identifies the feed using a universally unique and permanent URI.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set Feed ID
     *
     * @param string $id Feed ID. Identifies the feed using a universally unique and permanent URI.
     *
     * @return Feed $this for fluent calls
     *
     * @throws \InvalidArgumentException 1425164400 if $id is not a valid Feed ID
     */
    public function setId(string $id): self
    {
        if ('' === $id) {
            throw new \InvalidArgumentException('Argument $id is not a valid ID: ' . $id, 1425164400);
        }
        $this->id = $id;
        return $this;
    }

    /**
     * Get Title
     *
     * @return Text A human readable title for the feed. Often the same as the title of the associated website.
     */
    public function getTitle(): Text
    {
        return $this->title;
    }

    /**
     * Set Title
     *
     * @param Text $title A human readable title for the feed. Often the same as the title of the associated website.
     *
     * @return Feed $this for fluent calls
     */
    public function setTitle(Text $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get last modification time
     *
     * @return \DateTime Last modification time (only significant modifications!).
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * Set last modification time
     *
     * @param \DateTime $updated Last modification time (only significant modifications!).
     *
     * @return Feed $this for fluent calls
     */
    public function setUpdated(\DateTime $updated): self
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * Get Authors
     *
     * @return \SplObjectStorage<Person> Authors of the feed.
     */
    public function getAuthors(): \SplObjectStorage
    {
        return $this->authors;
    }

    /**
     * Set Authors
     *
     * @param \SplObjectStorage $authors Authors of the feed
     *
     * @return Feed $this for fluent calls
     */
    public function setAuthors(\SplObjectStorage $authors): self
    {
        $this->authors = $authors;
        return $this;
    }

    /**
     * Add an author to the list of authors of the feed
     *
     * @param Person $author The author to be added to the list of authors of the feed
     *
     * @return Feed $this for fluent calls
     */
    public function addAuthor(Person $author): self
    {
        $this->authors->attach($author);
        return $this;
    }

    /**
     * Remove an author from the list of authors of the feed
     *
     * @param Person $author The author to be removed from the list of authors of the feed
     *
     * @return Feed $this for fluent calls
     */
    public function removeAuthor(Person $author): self
    {
        $this->authors->detach($author);
        return $this;
    }

    /**
     * Get Links
     *
     * @return \SplObjectStorage<Link> Related web pages and other resources
     */
    public function getLinks(): \SplObjectStorage
    {
        return $this->links;
    }

    /**
     * Set Links
     *
     * @param \SplObjectStorage $links Related web pages and other resources
     *
     * @return Feed $this for fluent calls
     */
    public function setLinks(\SplObjectStorage $links): self
    {
        $this->links = $links;
        return $this;
    }

    /**
     * Add a link
     *
     * @param Link $link The link to be added to the list of links
     *
     * @return Feed $this for fluent calls
     */
    public function addLink(Link $link): self
    {
        $this->links->attach($link);
        return $this;
    }

    /**
     * Remove a link
     *
     * @param Link $link The link to be removed from the list of links
     *
     * @return Feed $this for fluent calls
     */
    public function removeLink(Link $link): self
    {
        $this->links->detach($link);
        return $this;
    }

    /**
     * Get Categories
     *
     * @return \SplObjectStorage<Category> Categories that the feed belongs to
     */
    public function getCategories(): \SplObjectStorage
    {
        return $this->categories;
    }

    /**
     * Set Categories
     *
     * @param \SplObjectStorage $categories Categories that the feed belongs to
     *
     * @return Feed $this for fluent calls
     */
    public function setCategories(\SplObjectStorage $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * Add a category
     *
     * @param Category $category The category to be added to the list of categories
     *
     * @return Feed $this for fluent calls
     */
    public function addCategory(Category $category): self
    {
        $this->categories->attach($category);
        return $this;
    }

    /**
     * Remove a category
     *
     * @param Category $category The category to be removed from the list of categories
     *
     * @return Feed $this for fluent calls
     */
    public function removeCategory(Category $category): self
    {
        $this->categories->detach($category);
        return $this;
    }

    /**
     * Get Contributors
     *
     * @return \SplObjectStorage<Person> Contributors to the feed
     */
    public function getContributors(): \SplObjectStorage
    {
        return $this->contributors;
    }

    /**
     * Set Contributors
     *
     * @param \SplObjectStorage $contributors Contributors to the feed
     *
     * @return Feed $this for fluent calls
     */
    public function setContributors(\SplObjectStorage $contributors): self
    {
        $this->contributors = $contributors;
        return $this;
    }

    /**
     * Add a contributor
     *
     * @param Person $contributor The contributor to be added to the list of contributor
     *
     * @return Feed $this for fluent calls
     */
    public function addContributor(Person $contributor): self
    {
        $this->contributors->attach($contributor);
        return $this;
    }

    /**
     * Remove a contributor
     *
     * @param Person $contributor The contributor to be removed from the list of contributor
     *
     * @return Feed $this for fluent calls
     */
    public function removeContributor(Person $contributor): self
    {
        $this->contributors->detach($contributor);
        return $this;
    }

    /**
     * Get Generator
     *
     * @return Generator The agent used to generate a feed
     * @throws \RuntimeException 1425164401 if the feed has no generator set
     */
    public function getGenerator(): Generator
    {
        if (!$this->hasGenerator()) {
            throw new \RuntimeException('Feed has no generator', 1425164401);
        }
        return $this->generator;
    }

    /**
     * Set Generator
     *
     * @param Generator $generator The agent used to generate a feed
     *
     * @return Feed $this for fluent calls
     */
    public function setGenerator(Generator $generator): self
    {
        $this->generator = $generator;
        return $this;
    }

    /**
     * Test whether this feed has a generator set
     *
     * @return boolean TRUE if this feed has a generator set, FALSE otherwise
     */
    public function hasGenerator(): bool
    {
        return $this->generator instanceof Generator;
    }

    /**
     * Get Icon
     *
     * @return string IRI reference to a small image which provides iconic visual identification for the feed. Square.
     * @throws \RuntimeException 1425164402 if the feed has no icon set
     */
    public function getIcon(): string
    {
        if (!$this->hasIcon()) {
            throw new \RuntimeException('Feed has no icon', 1425164402);
        }
        return $this->icon;
    }

    /**
     * Set Icon
     *
     * @param string $icon IRI reference to a small image which provides iconic visual identification for the feed.
     *                     Should be square.
     *
     * @return Feed $this for fluent calls
     * @throws \InvalidArgumentException 1425164403 if $icon is not a valid icon
     */
    public function setIcon(string $icon): self
    {
        if ('' === $icon) {
            throw new \InvalidArgumentException('Argument $icon is not a valid icon: ' . $icon, 1425164403);
        }
        $this->icon = $icon;
        return $this;
    }

    /**
     * Test whether this feed has an icon set
     *
     * @return boolean TRUE if this feed has an icon set, FALSE otherwise
     */
    public function hasIcon(): bool
    {
        return is_string($this->icon) && '' !== $this->icon;
    }

    /**
     * Get Logo
     *
     * @return string IRI reference to an image that provides visual identification for the feed. Twice as wide as tall.
     * @throws \RuntimeException 1425164404 if the feed has no logo set
     */
    public function getLogo(): string
    {
        if (!$this->hasLogo()) {
            throw new \RuntimeException('Feed has no logo', 1425164404);
        }
        return $this->logo;
    }

    /**
     * Set Logo
     *
     * @param string $logo IRI reference to an image that provides visual identification for the feed. Should be twice
     *                     as wide as it is tall.
     *
     * @return Feed $this for fluent calls
     * @throws \InvalidArgumentException 1425164405 if $logo is not a valid logo
     */
    public function setLogo(string $logo): self
    {
        if ('' === $logo) {
            throw new \InvalidArgumentException('Argument $logo is not a valid logo: ' . $logo, 1425164405);
        }
        $this->logo = $logo;
        return $this;
    }

    /**
     * Test whether this feed has a logo set
     *
     * @return boolean TRUE if this feed has a logo set, FALSE otherwise
     */
    public function hasLogo(): bool
    {
        return is_string($this->logo) && '' !== $this->logo;
    }

    /**
     * Get Rights
     *
     * @return Text Information about rights, e.g. copyrights, held in and over the feed
     * @throws \RuntimeException 1425164406 if the feed has no rights information set
     */
    public function getRights(): Text
    {
        if (!$this->hasRights()) {
            throw new \RuntimeException('Feed has no rights information set', 1425164406);
        }
        return $this->rights;
    }

    /**
     * Set Rights
     *
     * @param Text $rights Information about rights, e.g. copyrights, held in and over the feed
     *
     * @return Feed $this for fluent calls
     */
    public function setRights(Text $rights): self
    {
        $this->rights = $rights;
        return $this;
    }

    /**
     * Test whether this feed has information about rights set
     *
     * @return boolean TRUE if this feed has information about rights set, FALSE otherwise
     */
    public function hasRights(): bool
    {
        return $this->rights instanceof Text;
    }

    /**
     * Get Subtitle
     *
     * @return Text Human readable description or subtitle for the feed.
     * @throws \RuntimeException 1425164407 if the feed has no subtitle set
     */
    public function getSubtitle(): Text
    {
        if (!$this->hasSubtitle()) {
            throw new \RuntimeException('Feed has no subtitle set', 1425164407);
        }
        return $this->subtitle;
    }

    /**
     * Set Subtitle
     *
     * @param Text $subtitle Human readable description or subtitle for the feed.
     *
     * @return Feed $this for fluent calls
     */
    public function setSubtitle(Text $subtitle): self
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    /**
     * Test whether this feed has its subtitle set
     *
     * @return boolean TRUE if this feed has its subtitle set, FALSE otherwise
     */
    public function hasSubtitle(): bool
    {
        return $this->subtitle instanceof Text;
    }

    /**
     * Get Entries
     *
     * @return \SplObjectStorage<Entry> Entries
     */
    public function getEntries(): \SplObjectStorage
    {
        return $this->entries;
    }

    /**
     * Set Entries
     *
     * @param \SplObjectStorage $entries Entries
     *
     * @return Feed $this for fluent calls
     */
    public function setEntries(\SplObjectStorage $entries): self
    {
        $this->entries = $entries;
        return $this;
    }

    /**
     * Add an entry
     *
     * @param Entry $entry The entry to add
     *
     * @return Feed $this for fluent calls
     */
    public function addEntry(Entry $entry): self
    {
        $this->entries->attach($entry);
        return $this;
    }

    /**
     * Remove an entry
     *
     * @param Entry $entry The entry to remove
     *
     * @return Feed $this for fluent calls
     */
    public function removeEntry(Entry $entry): self
    {
        $this->entries->detach($entry);
        return $this;
    }
}
