<?php

use \ostark\Prompter\Services\ElementModelWriter;

use function Spatie\Snapshots\assertMatchesSnapshot;

uses(\Tests\ServiceTestCase::class);

beforeEach(
    function () {
        $this->pathToTargetFile = $this->path . DIRECTORY_SEPARATOR . ElementModelWriter::TARGET_FILE;
        $this->writer = new ElementModelWriter(
            new \Tests\Mocks\FieldLayoutsRepositoryMock(),
            new \Tests\Mocks\ElementContextRepositoryMock(),
            new \Tests\Mocks\MatrixBlocksRepositoryMock(),
            new \ostark\Prompter\Repositories\ElementClassRepository()
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
