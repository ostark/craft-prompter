<?php

namespace ostark\Prompter;

use ostark\Prompter\Actions\HelpAction;
use ostark\Prompter\Actions\MakeAction;
use ostark\Yii2ArtisanBridge\ActionGroup;
use ostark\Yii2ArtisanBridge\Bridge;

/**
 * Prompter
 */
class Plugin extends \craft\base\Plugin
{

    /**
     * Initialize Plugin
     */
    public function init()
    {
        parent::init();

        $this->registerConsoleCommands();
    }

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

    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }
}
