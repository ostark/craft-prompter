<?php

use ostark\Prompter\SchemaChangeHandler;
use ostark\Prompter\Services\PhpstormMetaWriter;
use ostark\Prompter\Settings;
use Tests\Mocks\ElementContextRepositoryMock;
use yii\base\Event;

uses(\Tests\ServiceTestCase::class);

test(
    'throws exception if wrong types provided',
    function () {
        $settings = new Settings();
        $fileWriters = [new DateTime()];
        new SchemaChangeHandler($settings, $fileWriters);
    }
)->throws(InvalidArgumentException::class);

test(
    'handler is invokable with Event',
    function () {
        $settings = new Settings();
        $settings->path = $this->path;
        $fileWriters = [new PhpstormMetaWriter(new ElementContextRepositoryMock())];
        $handler = new SchemaChangeHandler($settings, $fileWriters);

        expect(is_callable($handler))->toBeTrue();

        // let's call it
        $handler(new Event());
    }
);
