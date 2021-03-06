<?php

namespace Charcoal\Cms;

// Intra-module (`charcoal-cms`) dependencies
use \Charcoal\Cms\AbstractFaq;

/**
 *
 */
final class Faq extends AbstractFaq
{
    /**
     * CategorizableTrait > categoryType()
     *
     * @return string
     */
    public function categoryType()
    {
        return 'charcoal/cms/faq-category';

    }
}
