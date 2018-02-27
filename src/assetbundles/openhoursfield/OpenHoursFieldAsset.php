<?php
/**
 * Open Hours plugin for Craft CMS 3.x
 *
 * Add a field type for open hours
 *
 * @link      https://simple.com.au
 * @copyright Copyright (c) 2018 Simple Integrated Marketing
 */

namespace simpleteam\openhours\assetbundles\openhoursfield;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
use craft\web\assets\vue\VueAsset;

/**
 * @author    Simple Integrated Marketing
 * @package   OpenHours
 * @since     1.0.0
 */
class OpenHoursFieldAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@simpleteam/openhours/assetbundles/openhoursfield/dist";

        $this->depends = [
            CpAsset::class,
            VueAsset::class,
        ];

        $this->js = [
            'js/OpenHours.js',
        ];


        parent::init();
    }
}
