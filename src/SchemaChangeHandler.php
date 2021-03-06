<?php

declare(strict_types=1);

namespace ostark\Prompter;

use InvalidArgumentException;
use ostark\Prompter\Services\FileWriter;
use yii\base\Event;

final class SchemaChangeHandler
{
    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var FileWriter[]
     */
    private $fileWriters;

    public function __construct(Settings $settings, array $fileWriters = [])
    {
        $this->settings = $settings;

        foreach ($fileWriters as $writer) {
            if (! ($writer instanceof FileWriter)) {
                throw new InvalidArgumentException('Wrong type: ' . gettype(
                    $writer
                ) . ' FileWriter expected');
            }
            $this->fileWriters[] = $writer;
        }
    }

    /**
     * Writes the files
     */
    public function __invoke(Event $event): void
    {
        foreach ($this->fileWriters as $writer) {
            $writer->write($this->settings->path);
        }
    }
}
