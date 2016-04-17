<?php

namespace Charcoal\Cms;

use \Charcoal\Cms\AbstractVideo;

/**
 *
 */
final class Video extends AbstractVideo
{
    /**
     * @return string
     */
    public function categoryType()
    {
        return 'charcoal/cms/video-category';
    }
}
