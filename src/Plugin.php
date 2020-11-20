<?php

declare(strict_types=1);

namespace ostark\Prompter;

use Craft;
use craft\services\ProjectConfig;
use ostark\Prompter\Actions\HintAction;
use ostark\Prompter\Actions\MakeAction;
use ostark\Prompter\Services\ElementModelWriter;
use ostark\Prompter\Services\FileWriter;
use ostark\Prompter\Services\PhpstormMetaWriter;
use ostark\Prompter\Services\TwigExtensionWriter;
use ostark\Yii2ArtisanBridge\ActionGroup;
use ostark\Yii2ArtisanBridge\Bridge;
use yii\base\Event;

/**
 * Prompter
 *
 * @method Settings getSettings()
 */
class Plugin extends \craft\base\Plugin
{
    /**
     * @var FileWriter[]
     */
    private $fileWriters = [];

    /**
     * Initialize Plugin
     */
    public function init(): void
    {
        parent::init();

        // No need to look further
        if (Craft::$app->getRequest()->isSiteRequest) {
            return;
        }

        $this->registerServices();
        $this->registerConsoleCommands();
        $this->registerOnChangeEventHandler();
    }

    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }

    /**
     * Register services if needed
     */
    private function registerServices(): void
    {
        // Resolve the specific FileWriter from the containers with all dependencies
        // and collect them so we can pass them easily to the event handler
        if ($this->getSettings()->generateOnChange || Craft::$app->getRequest()->isConsoleRequest) {
            $this->fileWriters[] = Craft::createObject(ElementModelWriter::class);
            $this->fileWriters[] = Craft::createObject(PhpstormMetaWriter::class);
            $this->fileWriters[] = Craft::createObject(TwigExtensionWriter::class);
        }

        // Register our Settings Model in the container, so we can
        // inject it everywhere filled with config data
        $this->set(Settings::class, fn () => $this->getSettings());
    }

    /**
     * Console commands
     */
    private function registerConsoleCommands(): void
    {
        // Nope
        if (! Craft::$app->getRequest()->isConsoleRequest) {
            return;
        }

        $actions = [
            'make' => MakeAction::class,
            'hint' => HintAction::class,
        ];

        // Register console commands
        Bridge::registerGroup(
            (new ActionGroup('prompter', 'Craft IDE helper'))
                ->setActions($actions)
                ->setDefaultAction('make')
                ->setOptions(
                    [
                        'v' => 'verbose',
                        'f' => 'format',
                    ]
                )
        );
    }

    /**
     * Automatic
     */
    private function registerOnChangeEventHandler(): void
    {
        Event::on(
            ProjectConfig::class,
            ProjectConfig::EVENT_AFTER_APPLY_CHANGES,
            new SchemaChangeHandler(
                $this->getSettings(),
                $this->fileWriters
            )
        );
    }
}
