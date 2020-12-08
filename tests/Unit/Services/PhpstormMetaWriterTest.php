<?php

use \ostark\Prompter\Services\PhpstormMetaWriter;

uses(\Tests\ServiceTestCase::class, \Spatie\Snapshots\MatchesSnapshots::class);

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
        $this->assertMatchesSnapshot($content);
    }
);
