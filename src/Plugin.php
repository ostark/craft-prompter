<?php

namespace ostark\Prompter;

use Craft;
use craft\services\ProjectConfig;
use ostark\Prompter\Actions\HelpAction;
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
 * @method Settings getSettings()
 */
class Plugin extends \craft\base\Plugin
{
    /**
     * @var FileWriter[]
     */
    private $fileWriters;


    /**
     * Initialize Plugin
     */
    public function init()
    {
        parent::init();

        $this->registerServices();
        $this->registerConsoleCommands();
        $this->registerOnChangeEventHandler();
    }

    /**
     * Register services if needed
     */
    private function registerServices()
    {
        // Nope
        if (Craft::$app->getRequest()->isSiteRequest) {
            return;
        }

        if ($this->getSettings()->generateOnChange || Craft::$app->getRequest()->isConsoleRequest) {
            $this->fileWriters[] = $this->get(ElementModelWriter::class);
            $this->fileWriters[] = $this->get(PhpstormMetaWriter::class);
            $this->fileWriters[] = $this->get(TwigExtensionWriter::class);
        }
    }


    /**
     * Console commands
     */
    private function registerConsoleCommands(): void
    {
        $actions = [
            'make' => MakeAction::class,
            'help' => HelpAction::class
        ];

        // Register console commands
        Bridge::registerGroup(
            (new ActionGroup('prompter', 'Craft IDE helper'))
                ->setActions($actions)
                ->setDefaultAction('make')
                ->setOptions(
                    ['v' => 'verbose']
                )
        );
    }

    /**
     * Automatic
     */
    private function registerOnChangeEventHandler(): void
    {
        // Nothing to do
        if (!count($this->fileWriters)) {
            return;
        }

        Event::on(
            ProjectConfig::class,
            ProjectConfig::EVENT_AFTER_APPLY_CHANGES,
            new SchemaChangeHandler(
                $this->getSettings(),
                $this->fileWriters
            )
        );
    }

    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }
}
