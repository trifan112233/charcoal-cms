<?php

namespace Charcoal\Cms;

use \InvalidArgumentException;

// Module `charcoal-core` dependencies
use \Charcoal\Model\Collection;

// Module `charcoal-translation` dependencies
use \Charcoal\Translation\TranslationString;

use \Charcoal\Loader\CollectionLoader;

// Module `charcoal-base` dependencies
use \Charcoal\Object\Content;
use \Charcoal\Object\HierarchicalInterface;
use \Charcoal\Object\HierarchicalTrait;
use \Charcoal\Object\RoutableInterface;
use \Charcoal\Object\RoutableTrait;

// Intra-module (`charcoal-cms`) dependencies
use \Charcoal\Cms\MetatagInterface;
use \Charcoal\Cms\SearchableInterface;
use \Charcoal\Cms\SectionInterface;

/**
 * A Section is a unique, reachable page.
 *
 * ## Types of sections
 * There can be different types of ection. 4 exists in the CMS module:
 * - `blocks`
 * - `content`
 * - `empty`
 * - `external`
 *
 * ## External implementations
 * Sections imlpement the following _Interface_ / _Trait_:
 * - From the `Charcoal\Object` namespace (in `charcoal-base`)
 *   - `Hierarchical`
 *   - `Routable`
 * - From the local `Charcoal\Cms` namespace
 *   - `Metatag`
 *   - `Searchable`
 *
 */
abstract class AbstractSection extends Content implements
    HierarchicalInterface,
    MetatagInterface,
    RoutableInterface,
    SearchableInterface,
    SectionInterface
{
    use HierarchicalTrait;
    use MetatagTrait;
    use RoutableTrait;
    use SearchableTrait;

    const TYPE_BLOCKS = 'charcoal/cms/section/blocks';
    const TYPE_CONTENT = 'charcoal/cms/section/content';
    const TYPE_EMPTY = 'charcoal/cms/section/empty';
    const TYPE_EXTERNAL = 'charcoal/cms/section/external';
    const DEFAULT_TYPE = self::TYPE_CONTENT;

    /**
     * @var string $sectionType
     */
    private $sectionType = self::DEFAULT_TYPE;

    /**
     * @var TranslationString $title
     */
    private $title;
    /**
     * @var TranslationString $subtitle
     */
    private $subtitle;
    /**
     * @var TranslationString $content
     */
    private $content;

    /**
     * @var TranslationString $image
     */
    private $image;

    /**
     * @var mixed $templateIdent
     */
    private $templateIdent;
    /**
     * @var array $templateOptions
     */
    private $templateOptions = [];

    /**
     * @var array $attachments
     */
    private $attachments;

    /**
     * @param string $sectionType The section type.
     * @throws InvalidArgumentException If the section type is not a string or not a valid section type.
     * @return SectionInterface Chainable
     */
    public function setSectionType($sectionType)
    {
        if (!is_string($sectionType)) {
            throw new InvalidArgumentException(
                'Section type must be a string'
            );
        }
        $validTypes = [
            self::TYPE_CONTENT,
            self::TYPE_EMPTY,
            self::TYPE_EXTERNAL
        ];
        if (!in_array($sectionType, $validTypes)) {
            throw new InvalidArgumentException(
                'Section type is not valid'
            );
        }

        $this->sectionType = $sectionType;
        return $this;
    }

    /**
     * @return string
     */
    public function sectionType()
    {
        return $this->sectionType;
    }

    /**
     * @param mixed $title The section title (localized).
     * @return TranslationString
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
     * @param mixed $subtitle The section subtitle (localized).
     * @return Section Chainable
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
     * @param mixed $content The section content (localized).
     * @return Section Chainable
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
     * @return Section Chainable
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
     * @return SectionInterface Chainable
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
     * @return SectionInterface Chainable
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
     * @param string $type Optional type.
     * @return array
     */
    public function attachments($type = null)
    {
        if (!$this->attachments) {
            $this->attachments = $this->loadAttachments();
        }
        if ($type) {
            // Return only the attachments of a certain type.
            return $this->attachments[$type];
        } else {
            // Return all attachments, grouped by types.
            return $this->attachments;
        }
    }

    /**
     * @return array
     */
    public function loadAttachments()
    {
        return [];
    }

    /**
     * HierarchicalTrait > loadChildren
     *
     * @return Co
     */
    public function loadChildren()
    {
        $loader = new CollectionLoader([
            'logger' => $this->logger,
            'factory' => $this->modelFactory()
        ]);
        $loader->setModel($this);
        $loader->addFilter([
            'property'=>'master',
            'val'=>$this->id()
        ]);
        $loader->addFilter([
            'property'=>'active',
            'val'=>true
        ]);

        $loader->addOrder([
            'property'=>'position',
            'mode'=>'asc'
        ]);
        return $loader->load();
    }

    /**
     * MetatagTrait > canonicalUrl
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
        // if (!$this->slug) {
            $this->setSlug($this->generateSlug());
        // }
        return parent::preUpdate($properties);
    }
}
