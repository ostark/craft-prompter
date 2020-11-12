<?php

use ostark\Prompter\Services\TwigExtensionWriter;

use function Spatie\Snapshots\assertMatchesSnapshot;

uses(\Tests\ServiceTestCase::class);

beforeEach(
    function () {
        $this->pathToTargetFile = $this->path . DIRECTORY_SEPARATOR . TwigExtensionWriter::TARGET_FILE;
        $this->writer = new TwigExtensionWriter(
            new \Tests\Mocks\ElementContextRepositoryMock()
        );
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
        assertMatchesSnapshot($content);
    }
);
