<?php

namespace ostark\Prompter\Repositories\FieldLayout;

class EntryType extends LayoutType
{
    /**
     * @var string Handle of EntryType
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
        return 'PlainEntry';
    }
}
