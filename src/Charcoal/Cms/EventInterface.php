<?php

namespace Charcoal\Cms;

/**
 *
 */
interface EventInterface
{
    /**
     * @param mixed $title News title (localized).
     * @return \Charcoal\Translation\TranslationString
     */
    public function setTitle($title);

    /**
     * @return \Charcoal\Translation\TranslationString
     */
    public function title();

    /**
     * @param mixed $subtitle News subtitle (localized).
     * @return NewsInterface Chainable
     */
    public function setSubtitle($subtitle);

    /**
     * @return \Charcoal\Translation\TranslationString
     */
    public function subtitle();

    /**
     * @param mixed $content News content (localized).
     * @return NewsInterface Chainable
     */
    public function setContent($content);

    /**
     * @return \Charcoal\Translation\TranslationString
     */
    public function content();

    /**
     * @param string|\DateTime $startDate Event starting date.
     * @return EventInterface Chainable
     */
    public function setStartDate($startDate);

    /**
     * @return \DateTime|null
     */
    public function startDate();

    /**
     * @param string|\DateTime $endDate Event end date.
     * @return EventInterface Chainable
     */
    public function setEndDate($endDate);

    /**
     * @return \DateTime|null
     */
    public function endDate();
}
