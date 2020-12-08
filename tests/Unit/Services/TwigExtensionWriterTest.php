<?php

use ostark\Prompter\Services\TwigExtensionWriter;

uses(\Tests\ServiceTestCase::class, \Spatie\Snapshots\MatchesSnapshots::class);

beforeEach(
    function () {
        $this->pathToTargetFile = $this->path . DIRECTORY_SEPARATOR . TwigExtensionWriter::TARGET_FILE;
        $this->writer = new TwigExtensionWriter();
    }
);

test(
    'can write file to path',
    function () {
        $this->writer->write($this->path);
        expect(file_exists($this->pathToTargetFile))->toBeTrue();
    }
);

test(
    'file content matches',
    function () {
        $this->writer->write($this->path);
        $content = file_get_contents($this->pathToTargetFile);
        $this->assertMatchesSnapshot($content);
    }
);
