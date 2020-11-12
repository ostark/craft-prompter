<?php

namespace ostark\Prompter\Actions;

use ostark\Prompter\Services\ElementModelWriter;
use ostark\Prompter\Services\FileWriter;
use ostark\Prompter\Services\PhpstormMetaWriter;
use ostark\Prompter\Services\TwigExtensionWriter;
use ostark\Prompter\Settings;
use ostark\Yii2ArtisanBridge\base\Action;
use ostark\Yii2ArtisanBridge\base\Commands;
use yii\console\ExitCode;

class MakeAction extends Action
{
    private const ICON_SUCCESS = '👌';
    private const ICON_ERROR = '💥';

    private Settings $settings;
    private FileWriter $modelWriter;
    private FileWriter $metaWriter;
    private FileWriter $twigWriter;

    public function __construct(
        string $id,
        Commands $controller,
        Settings $settings,
        ElementModelWriter $model,
        PhpstormMetaWriter $meta,
        TwigExtensionWriter $twig,
        $config = []
    ) {
        parent::__construct($id, $controller, $config);
        $this->modelWriter = $model;
        $this->metaWriter = $meta;
        $this->twigWriter = $twig;
        $this->settings = $settings;
    }

    /**
     * Generate files
     */
    public function run(): int
    {
        if (!$this->confirm('Sure ... ?')) {
            return ExitCode::NOINPUT;
        }

        $icon = $this->modelWriter->write($this->settings->path) ? self::ICON_SUCCESS : self::ICON_ERROR;
        $this->line("* Models: $icon");

        $icon = $this->twigWriter->write($this->settings->path) ? self::ICON_SUCCESS : self::ICON_ERROR;
        $this->line("* Twig: $icon");

        $icon = $this->metaWriter->write($this->settings->path) ? self::ICON_SUCCESS : self::ICON_ERROR;
        $this->line("* Meta: $icon");

        return ExitCode::OK;
    }
}
