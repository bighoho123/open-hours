<?php
/**
 * Open Hours plugin for Craft CMS 3.x
 *
 * Add a field type for open hours
 *
 * @link      https://simple.com.au
 * @copyright Copyright (c) 2018 Simple Integrated Marketing
 */

namespace simpleteam\openhours;

use simpleteam\openhours\services\OpenHoursService as OpenHoursServiceService;
use simpleteam\openhours\twigextensions\OpenHoursTwigExtension;
use simpleteam\openhours\fields\OpenHoursField;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;

use yii\base\Event;

/**
 * Class OpenHours
 *
 * @author    Simple Integrated Marketing
 * @package   OpenHours
 * @since     1.0.0
 *
 * @property  OpenHoursServiceService $openHoursService
 */
class OpenHours extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var OpenHours
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Craft::$app->view->registerTwigExtension(new OpenHoursTwigExtension());

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = OpenHoursField::class;
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'open-hours',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
