<?php

namespace Tests\Mocks;

use ostark\Prompter\Repositories\FieldLayout\BlockType;
use ostark\Prompter\Repositories\FieldLayout\LayoutType;

class FieldLayoutsRepositoryMock extends \ostark\Prompter\Repositories\FieldLayoutsRepository
{
    /**
     * @var LayoutType[]
     */
    private $layoutTypes;

    public function __construct(array $layoutTypes = [])
    {
        $this->layoutTypes = $layoutTypes;
        parent::__construct(new MatrixBlocksRepositoryMock());
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        if ($this->layoutTypes) {
            return $this->layoutTypes;
        }

        $layouts = static::getLayouts();

        // Get the scalar type instead of the FQN of the field
        return array_map(
            function ($layout) {
                /** @var LayoutType $layout */
                $layout->fields = array_map(
                    function ($field) {
                        if (is_string($field)) {
                            return $this->getValueType($field);
                        }
                        return $field;
                    },
                    $layout->fields
                );
                return $layout;
            },
            $layouts
        );
    }

    /**
     * @return LayoutType[]
     */
    public static function getLayouts()
    {
        return [
            // Entries
            new \ostark\Prompter\Repositories\FieldLayout\EntryType(
                'efoo',
                [
                    'someText' => \craft\fields\PlainText::class,
                    'someBool' => \craft\fields\Lightswitch::class,
                    'someAssetRel' => \craft\elements\db\AssetQuery::class,
                    'multi1' => new BlockType(
                        'multi1',
                        [
                            'text1' => \craft\fields\PlainText::class,
                            'text2' => \craft\fields\PlainText::class,
                            'text3' => \craft\fields\PlainText::class,
                        ]
                    )
                ]
            ),
            new \ostark\Prompter\Repositories\FieldLayout\EntryType(
                'ebar',
                [
                    'someText2' => \craft\fields\PlainText::class,
                    'someBool2' => \craft\fields\Lightswitch::class,
                    'multi2' => new BlockType(
                        'multi2',
                        [
                            'text100' => \craft\fields\PlainText::class,
                            'text200' => \craft\fields\PlainText::class,
                            'text300' => \craft\fields\PlainText::class,
                        ]
                    )
                ]
            ),
            // Globalsets
            new \ostark\Prompter\Repositories\FieldLayout\GlobalsetType(
                'gfoo',
                [
                    'someText' => \craft\fields\PlainText::class,
                    'someBool' => \craft\fields\Lightswitch::class,
                    'someEntry' => 'SomeEntry',
                ]
            ),
            // Assets
            new \ostark\Prompter\Repositories\FieldLayout\AssetType(
                'afoo',
                [
                    'someText' => \craft\fields\PlainText::class,
                    'someBool' => \craft\fields\Lightswitch::class,
                ]
            )
        ];
    }
}
