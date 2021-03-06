<?php

namespace Charcoal\Cms;

/**
 *
 */
interface SectionInterface
{
    /**
     * @param string $sectionType The section type.
     * @return SectionInterface Chainable
     */
    public function setSectionType($sectionType);

    /**
     * @return string
     */
    public function sectionType();

    /**
     * @param mixed $title Section title (localized).
     * @return SectionInterface Chainable
     */
    public function setTitle($title);

    /**
     * @return \Charcoal\Translation\TranslationString
     */
    public function title();

    /**
     * @param mixed $subtitle Section subtitle (localized).
     * @return SectionInterface Chainable
     */
    public function setSubtitle($subtitle);

    /**
     * @return \Charcoal\Translation\TranslationString
     */
    public function subtitle();

    /**
     * @param mixed $template Section template (ident).
     * @return SectionInterface Chainable
     */
    public function setTemplateIdent($template);

    /**
     * @return mixed
     */
    public function templateIdent();

    /**
     * @param array|string $templateOptions Extra template options.
     * @return SectionInterface Chainable
     */
    public function setTemplateOptions($templateOptions);

    /**
     * @return array
     */
    public function templateOptions();
}
