<?php

declare(strict_types=1);

namespace ostark\Prompter\Repositories\FieldLayout;

class BlockType extends LayoutType
{
    /**
     * @var string Handle of
     */
    public $handle;

    /**
     * @var array A map with field handles and field class names
     */
    public $fields = [];

    public function __construct(string $handle, array $fields)
    {
        parent::__construct($handle, $fields);
    }

    public function __toString(): string
    {
        return $this->getElementTypeClass() . '[]';
    }

    /**
     * The class the dynamic class extends from
     */
    public function getElementBaseClass(): string
    {
        return 'PlainMatrixBlock';
    }
}
