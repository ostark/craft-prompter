<?php

declare(strict_types=1);

namespace ostark\Prompter\Repositories\FieldLayout;

class CategoryType extends LayoutType
{
    /**
     * @var string Handle of Category Type (aka Category Group)
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

    /**
     * The class the dynamic class extends from
     */
    public function getElementBaseClass(): string
    {
        return 'PlainCategory';
    }
}
