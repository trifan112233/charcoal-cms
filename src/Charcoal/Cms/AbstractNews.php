<?php

namespace Charcoal\Cms;

use \DateTime;
use \DateTimeInterface;
use \InvalidArgumentException;

use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface;

// Dependencies from `charcoal-translation`
use \Charcoal\Translation\TranslationString;

// Dependencies from `charcoal-base`
use \Charcoal\Object\Content;
use \Charcoal\Object\CategorizableInterface;
use \Charcoal\Object\CategorizableTrait;
use \Charcoal\Object\PublishableInterface;
use \Charcoal\Object\PublishableTrait;
use \Charcoal\Object\RoutableInterface;
use \Charcoal\Object\RoutableTrait;

// Intra-module (`charcoal-cms`) dependencies
use \Charcoal\Cms\MetatagInterface;
use \Charcoal\Cms\NewsInterface;
use \Charcoal\Cms\SearchableInterface;
use \Charcoal\Cms\SearchableTrait;

/**
 * News
 */
abstract class AbstractNews extends Content implements
    CategorizableInterface,
    MetatagInterface,
    NewsInterface,
    PublishableInterface,
    RoutableInterface,
    SearchableInterface
{
    use CategorizableTrait;
    use PublishableTrait;
    use MetatagTrait;
    use RoutableTrait;
    use SearchableTrait;

    /**
     * @var TranslationString $title
     */
    private $title;

    /**
     * @var TranslationString $title
     */
    private $subtitle;

    /**
     * @var TranslationString $title
     */
    private $summary;

    /**
     * @var TranslationString $content
     */
    private $content;

    /**
     * @var TranslationString $image
     */
    private $image;

    /**
     * @var DateTime $newsDate
     */
    private $newsDate;

    /**
     * @var TranslationString $infoUrl
     */
    private $infoUrl;

    /**
     * @param mixed $title The news title (localized).
     * @return NewsInterface Chainable
     */
    public function setTitle($title)
    {
        $this->title = new TranslationString($title);
        return $this;
    }

    /**
     * @return TranslationString
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @param mixed $subtitle The news subtitle (localized).
     * @return NewsInterface Chainable
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = new TranslationString($subtitle);
        return $this;
    }

    /**
     * @return TranslationString
     */
    public function subtitle()
    {
        return $this->subtitle;
    }

    /**
     * @param mixed $summary The news summary (localized).
     * @return NewsInterface Chainable
     */
    public function setSummary($summary)
    {
        $this->summary = new TranslationString($summary);
        return $this;
    }

    /**
     * @return TranslationString
     */
    public function summary()
    {
        return $this->summary;
    }

    /**
     * @param mixed $content The news content (localized).
     * @return NewsInterface Chainable
     */
    public function setContent($content)
    {
        $this->content = new TranslationString($content);
        return $this;
    }

    /**
     * @return TranslationString
     */
    public function content()
    {
        return $this->content;
    }

    /**
     * @param mixed $image The section main image (localized).
     * @return NewsInterface Chainable
     */
    public function setImage($image)
    {
        $this->image = new TranslationString($image);
        return $this;
    }

    /**
     * @return TranslationString
     */
    public function image()
    {
        return $this->image;
    }

    /**
     * @param mixed $template The section template (ident).
     * @return NewsInterface Chainable
     */
    public function setTemplateIdent($template)
    {
        $this->templateIdent = $template;
        return $this;
    }

    /**
     * @return mixed
     */
    public function templateIdent()
    {
        if (!$this->templateIdent) {
            $metadata = $this->metadata();
            return $metadata['template_ident'];
        }
        return $this->templateIdent;
    }

    /**
     * @param array|string $templateOptions Extra template options, if any.
     * @return NewsInterface Chainable
     */
    public function setTemplateOptions($templateOptions)
    {
        $this->templateOptions = $templateOptions;
        return $this;
    }

    /**
     * @return array
     */
    public function templateOptions()
    {
        if (!$this->templateOptions) {
            $metadata = $this->metadata();
            return $metadata['template_options'];
        }
        return $this->templateOptions;
    }

    /**
     * @param mixed $newsDate The news date.
     * @throws InvalidArgumentException If the timestamp is invalid.
     * @return NewsInterface Chainable
     */
    public function setNewsDate($newsDate)
    {
        if ($newsDate === null) {
            $this->newsDate = null;
            return $this;
        }
        if (is_string($newsDate)) {
            $newsDate = new DateTime($newsDate);
        }
        if (!($newsDate instanceof DateTimeInterface)) {
            throw new InvalidArgumentException(
                'Invalid "Revision Date" value. Must be a date/time string or a DateTimeInterface object.'
            );
        }
        $this->newsDate = $newsDate;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function newsDate()
    {
        return $this->newsDate;
    }

    /**
     * @param mixed $url The info URL (news source or where to find more information; localized).
     * @return NewsInterface Chainable
     */
    public function setInfoUrl($url)
    {
        $this->infoUrl = new TranslationString($url);
        return $this;
    }

    /**
     * @return TranslationString
     */
    public function infoUrl()
    {
        return $this->infoUrl;
    }

    /**
     * MetatagTrait > canonical_url
     *
     * @return string
     * @todo
     */
    public function canonicalUrl()
    {
        return '';
    }

    /**
     * @return TranslationString
     */
    public function defaultMetaTitle()
    {
        return $this->title();
    }

    /**
     * @return TranslationString
     */
    public function defaultMetaDescription()
    {
        return $this->content();
    }

    /**
     * @return TranslationString
     */
    public function defaultMetaImage()
    {
        return $this->image();
    }

    /**
     * {@inheritdoc}
     *
     * @return boolean
     */
    public function preSave()
    {
        $this->setSlug($this->generateSlug());
        return parent::preSave();
    }

    /**
     * {@inheritdoc}
     *
     * @param array $properties Optional properties to update.
     * @return boolean
     */
    public function preUpdate(array $properties = null)
    {
        if (!$this->slug) {
            $this->setSlug($this->generateSlug());
        }
        return parent::preUpdate($properties);
    }
}
