<?php

declare(strict_types=1);

namespace ostark\Prompter\Services;

use ostark\Prompter\Repositories\ElementContextRepository;

class TwigExtensionWriter implements FileWriter
{
    public const TARGET_FILE = '.craft.prompter.extension.php';

    private ElementContextRepository $context;

    private string $template;

    public function __construct(
        ElementContextRepository $entryContext
    ) {
        $this->context = $entryContext;
        $this->template = $this->getTwigExtensionTemplate();
    }

    public function write(string $path): bool
    {
        $vars = [
            '{{ docblock }}' => '*',
            '{{ namespace }}' => '',
            '{{ variable_class }}' => 'PrompterVariable',
            '{{ extension_class }}' => 'PrompterExtension',
            '{{ globals }}' => "'foo' => false,",
        ];

        $target = $path . DIRECTORY_SEPARATOR . self::TARGET_FILE;
        return file_put_contents(
            $target,
            str_replace(array_keys($vars), array_values($vars), $this->template)
        );
    }

    private function getTwigExtensionTemplate(): string
    {
        return file_get_contents(__DIR__ . '/../stubs/' . self::EXTENSION_CLASS_FILE);
    }
}
