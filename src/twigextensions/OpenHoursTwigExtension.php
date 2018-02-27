<?php
/**
 * Open Hours plugin for Craft CMS 3.x
 *
 * Add a field type for open hours
 *
 * @link      https://simple.com.au
 * @copyright Copyright (c) 2018 Simple Integrated Marketing
 */

namespace simpleteam\openhours\twigextensions;

use simpleteam\openhours\OpenHours;

use Craft;

/**
 * @author    Simple Integrated Marketing
 * @package   OpenHours
 * @since     1.0.0
 */
class OpenHoursTwigExtension extends \Twig_Extension
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'OpenHours';
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('openHours', [$this, 'openHours']),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('openHours', [$this, 'openHours']),
        ];
    }


    public function openHours($text = null)
    {
        $data = json_decode($text);
        return $data;
    }
}
