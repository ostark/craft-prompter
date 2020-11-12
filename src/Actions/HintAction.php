<?php

namespace ostark\Prompter\Actions;

use ostark\Prompter\Services\TypeHintHelpGenerator;
use ostark\Prompter\Settings;
use ostark\Yii2ArtisanBridge\base\Action;
use ostark\Yii2ArtisanBridge\base\Commands;
use yii\console\ExitCode;

class HintAction extends Action
{
    public const FORMAT_OPTIONS = ['twig', 'php'];

    public $format = 'twig';
    private Settings $settings;
    private TypeHintHelpGenerator $hints;

    public function __construct(
        string $id,
        Commands $controller,
        Settings $settings,
        TypeHintHelpGenerator $hints,
        $config = []
    ) {
        parent::__construct($id, $controller, $config);
        $this->settings = $settings;
        $this->hints = $hints;

        if ( ! in_array($this->format, self::FORMAT_OPTIONS)) {
            $this->format = 'twig';
        }
    }

    /**
     * Help for type hints
     *
     * @param string|null $type Type like 'entry', 'asset' or 'globalset'
     * @param string|null $entryTypeHandle Entry handle
     */
    public function run(string $type = null, string $entryTypeHandle = null): int
    {
        $this->hints->setOutputFormat($this->format);

        switch ($type) {
            case 'entry':
                $this->line(PHP_EOL . $this->hints->entry($entryTypeHandle));
                break;
            case 'section':
                $this->line(PHP_EOL . $this->hints->section());
                break;
            case 'asset':
                $this->line(PHP_EOL . $this->hints->asset());
                break;
            case 'globalset':
                $this->line(PHP_EOL . $this->hints->globalset());
                break;
            default:
                $this->defaultHelp();
        }

        return ExitCode::OK;
    }

    private function defaultHelp(): void
    {
        $this->output->section('Full example');
        $this->line('./craft <fg=yellow>prompter/hint</> <fg=cyan>entry [entryType]</>');

        $this->output->section('Basic hints');
        $this->line('./craft <fg=yellow>prompter/hint</> <fg=cyan>entry</>');
        $this->line('./craft <fg=yellow>prompter/hint</> <fg=cyan>section</>');
        $this->line('./craft <fg=yellow>prompter/hint</> <fg=cyan>asset</>');
        $this->line('./craft <fg=yellow>prompter/hint</> <fg=cyan>globalset</>');
        $this->line(PHP_EOL . "Optional: --format=" . implode('|', self::FORMAT_OPTIONS));
    }

}
