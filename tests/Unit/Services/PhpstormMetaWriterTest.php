<?php

use \ostark\Prompter\Services\PhpstormMetaWriter;

use function Spatie\Snapshots\assertMatchesSnapshot;

uses(\Tests\ServiceTestCase::class);

beforeEach(
    function () {
        $this->pathToTargetFile = $this->path . DIRECTORY_SEPARATOR . PhpstormMetaWriter::TARGET_FILE;
        $this->writer = new PhpstormMetaWriter(
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
