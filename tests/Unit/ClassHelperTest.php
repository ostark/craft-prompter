<?php

use ostark\Prompter\Repositories\FieldLayout\CategoryType;

test(
    'construct asset query class from layout type',
    function () {
        $handle = 'fooo';
        $class = 'AssetType';
        $result = \ostark\Prompter\ClassHelper::elementQueryClass($handle, $class);
        expect($result)->toBe('FoooAssetQuery');
    }
);

test(
    'construct asset query class from asset element with namespace',
    function () {
        $handle = 'fooo';
        $class = \craft\elements\Asset::class;
        $result = \ostark\Prompter\ClassHelper::elementQueryClass($handle, $class);
        expect($result)->toBe('FoooAssetQuery');
    }
);

test(
    'construct class from entry layout type',
    function () {
        $handle = 'bar';
        $class = 'EntryType';
        $result = \ostark\Prompter\ClassHelper::elementClass($handle, $class);
        expect($result)->toBe('BarEntry');
    }
);

test(
    'construct class from entry element with namespace',
    function () {
        $handle = 'bar';
        $class = \craft\elements\Entry::class;
        $result = \ostark\Prompter\ClassHelper::elementClass($handle, $class);
        expect($result)->toBe('BarEntry');
    }
);

test(
    'call helper from LayoutType class',
    function () {
        $layout = new CategoryType('fake', []);
        expect($layout->getElementTypeClass())->toBe('FakeCategory');
    }
);
