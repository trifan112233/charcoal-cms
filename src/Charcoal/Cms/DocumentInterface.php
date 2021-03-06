<?php

namespace Charcoal\Cms;

/**
 *
 */
interface DocumentInterface
{
    /**
     * @param mixed $name The document name (localized).
     * @return DocumentInterface Chainable
     */
    public function setName($name);

    /**
     * @return \Charcoal\Translation\TranslationString
     */
    public function name();

    /**
     * @param string $file The file relative path / url (localized).
     * @return DocumentInterface Chainable
     */
    public function setFile($file);

    /**
     * @return string
     */
    public function file();

    /**
     * @return string
     */
    public function path();

    /**
     * @return string
     */
    public function url();

    /**
     * @return string
     */
    public function mimetype();

    /**
     * Get the filename (basename; without any path segment).
     *
     * @return string
     */
    public function filename();

    /**
     * Get the document's file size, in bytes.
     *
     * @return integer
     */
    public function filesize();
}
