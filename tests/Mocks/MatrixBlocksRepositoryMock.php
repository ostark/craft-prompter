<?php

namespace Tests\Mocks;

use craft\services\Matrix;
use ostark\Prompter\Repositories\FieldLayout\BlockType;

class MatrixBlocksRepositoryMock extends \ostark\Prompter\Repositories\MatrixBlocksRepository
{
    public function __construct()
    {
        parent::__construct(new Matrix());
    }

    /**
     * @return BlockType[]
     */
    public function all(): array
    {
        $matrix = [];
        $layouts = FieldLayoutsRepositoryMock::getLayouts();

        // Extract Matrix blocks from layouts using them
        foreach ($layouts as $layoutType) {
            foreach ($layoutType->fields as $field) {
                if ($field instanceof BlockType) {
                    $matrix[] = $field;
                }
            }
        }

        return $matrix;
    }
}
