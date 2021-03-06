<?php

namespace Charcoal\Cms\Section;

use \Charcoal\Cms\AbstractSection;

/**
 * Content section
 */
class ContentSection extends AbstractSection
{
    /**
     * @return string
     */
    public function sectionType()
    {
        return AbstractSection::TYPE_CONTENT;
    }
}
