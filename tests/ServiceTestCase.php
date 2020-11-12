<?php

namespace Tests;

use ostark\Prompter\Services\FileWriter;

class ServiceTestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var string Location for files
     */
    public $path;

    /**
     * @var string Location for files
     */
    public $pathToTargetFile;

    /**
     * @var FileWriter
     */
    public $writer;


    protected function setUp(): void
    {
        // Init path
        $this->path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'prompter';
        if (!is_dir($this->path)) {
            mkdir($this->path);
        }
    }

    protected function tearDown(): void
    {
        // Clear path
        foreach (glob($this->path . DIRECTORY_SEPARATOR . '*') as $file) {
            unlink($file);
        }
    }
}
