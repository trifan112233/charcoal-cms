<?php

namespace Charcoal\Cms;

// Module `charcoal-base` dependencies
use \Charcoal\Object\Content;
use \Charcoal\Object\CategoryInterface;
use \Charcoal\Object\CategoryTrait;

/**
 * News category
 */
final class NewsCategory extends Content implements CategoryInterface
{
    use CategoryTrait;

    /**
     * CategoryTrait > itemType()
     *
     * @return string
     */
    public function itemType()
    {
        return 'charcoal/cms/news';
    }

    /**
     * @return Collection
     */
    public function loadCategoryItems()
    {
        return [];
    }
}
