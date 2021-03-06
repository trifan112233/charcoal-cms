<?php

namespace Charcoal\Cms;

use \Charcoal\Translation\TranslationString;

/**
 * Default implementation, as Trait, of the SearchableInterface
 */
trait SearchableTrait
{
    /**
     * @var array $searchProperties
     */
    private $searchProperties = [];

    /**
     * @var TranslationString $searchKeywords
     */
    private $searchKeywords;

    /**
     * @param array $properties The properties to search into.
     * @return SearchableInterface Chainable
     */
    public function setSearchProperties(array $properties)
    {
        $this->searchProperties = $properties;
        return $this;
    }

    /**
     * @return array
     */
    public function searchProperties()
    {
        return $this->searchProperties;
    }

    /**
     * @param mixed $keywords The search keywords (localized).
     * @return SearchableInterface Chainable
     */
    public function setSearchKeywords($keywords)
    {
        $this->searchKeywords = new TranslationString($keywords);
        return $this;
    }

    /**
     * @return TranslationString
     */
    public function searchKeywords()
    {
        return $this->searchKeywords;
    }
}
