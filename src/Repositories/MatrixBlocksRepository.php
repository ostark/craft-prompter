<?php

declare(strict_types=1);

namespace ostark\Prompter\Repositories;

use craft\services\Matrix;
use ostark\Prompter\Repositories\FieldLayout\BlockType;
use yii\base\InvalidConfigException;

class MatrixBlocksRepository
{
    protected static array $blockTypes = [];

    /**
     * @var Matrix
     */
    private $matrixService;

    public function __construct(Matrix $matrixService)
    {
        $this->matrixService = $matrixService;
    }

    /**
     * A map of handles and BlockTypes
     *
     * @return FieldLayout\BlockType[]
     *
     * @throws InvalidConfigException
     */
    public function indexedByHandle(): array
    {
        // Get cached static
        if (count(self::$blockTypes) > 0) {
            return self::$blockTypes;
        }

        foreach ($this->all() as $blockType) {
            self::$blockTypes[$blockType->handle] = $blockType;
        }

        return self::$blockTypes;
    }

    /**
     * A collection of all block types
     *
     * @return FieldLayout\BlockType[]
     *
     * @throws InvalidConfigException
     */
    public function all(): array
    {
        $result = [];

        foreach ($this->matrixService->getAllBlockTypes() as $blockType) {
            $matrixHandle = $blockType->getField()->handle;
            $matrixFields = [];

            foreach ($blockType->getFields() as $child) {
                $matrixFields[$child->handle] = get_class($child);
            }

            $result[] = new BlockType($matrixHandle, $matrixFields);
        }

        return $result;
    }
}
