<?php

declare(strict_types=1);

namespace ostark\Prompter\Services;

use ostark\Prompter\Repositories\ElementContextRepository;

class PhpstormMetaWriter implements FileWriter
{
    public const TARGET_FILE = '.phpstorm.meta.php';

    private ElementContextRepository $context;

    private string $template;

    public function __construct(
        ElementContextRepository $entryContext
    ) {
        $this->context = $entryContext;
        $this->template = $this->getPhpStormTemplate();
    }

    public function write(string $path): bool
    {
        $vars = [
            '{{ section_csv }}' => $this->csvQuoted($this->context->getSectionHandles()),
            '{{ type_csv }}' => $this->csvQuoted($this->context->getTypeHandles()),
            '{{ volume_csv }}' => $this->csvQuoted($this->context->getVolumeHandles()),
            '{{ globalset_csv }}' => $this->csvQuoted($this->context->getGlobalSetHandles()),
            '{{ category_csv }}' => $this->csvQuoted($this->context->getCategoryGroupHandles()),
        ];

        $target = $path . DIRECTORY_SEPARATOR . self::TARGET_FILE;
        return file_put_contents(
            $target,
            str_replace(array_keys($vars), array_values($vars), $this->template)
        );
    }

    private function getPhpStormTemplate(): string
    {
        return file_get_contents(__DIR__ . '/../stubs/' . self::PHPSTORM_META_FILE);
    }

    private function csvQuoted(array $array): string
    {
        $array = array_map(static fn ($value) => "'" . $value . "'", $array);
        return implode(', ', $array);
    }
}
