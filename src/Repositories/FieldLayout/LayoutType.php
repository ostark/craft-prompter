<?php

declare(strict_types=1);

namespace ostark\Prompter\Repositories\FieldLayout;

use craft\base\Element;
use InvalidArgumentException;
use ostark\Prompter\ClassHelper;
use ReflectionClass;

abstract class LayoutType
{
    /**
     * @var string
     */
    public $handle;

    /**
     * @var array A map with field handles and field class names
     */
    public $fields = [];

    /**
     * @var string The type
     */
    public $type;

    public function __construct(string $handle, array $fields)
    {
        $this->handle = $handle;
        $this->fields = $this->validateFields($fields);
        $this->type = (new ReflectionClass($this))->getShortName();
    }

    /**
     * The dynamic class name with handle
     */
    public function getElementTypeClass(): string
    {
        return ClassHelper::elementClass($this->handle, $this->type);
    }

    /**
     * The dynamic query class name with handle
     */
    public function getElementTypeQueryClass(): string
    {
        return ClassHelper::elementQueryClass($this->handle, $this->type);
    }

    /**
     * The class the dynamic class extends from
     */
    public function getElementBaseClass(): string
    {
        return Element::class;
    }

    protected function validateFields(array $fields): array
    {
        if (count($fields) === 0) {
            return [];
        }

        $name = static::class;

        foreach (array_keys($fields) as $fieldHandle) {
            if (! is_string($fieldHandle)) {
                throw new InvalidArgumentException(
                    "String expected in [$name], handle [{$this->handle}], type: [" . gettype(
                        $fieldHandle
                    ) . ']'
                );
            }
        }

        return $fields;
    }
}
