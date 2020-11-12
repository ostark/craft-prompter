<?php

namespace ostark\Prompter;

/**
 * Helps to build fake class names
 */
class ClassHelper
{
    public static function elementClass(string $handle, string $elementType): string
    {
        $elementType = self::stripNamespace($elementType);
        return ucfirst($handle) . str_replace('Type', '', $elementType);
    }

    private static function stripNamespace(string $class): string
    {
        $namespaceParts = explode('\\', $class);
        return $namespaceParts[array_key_last($namespaceParts)];
    }

    public static function elementQueryClass(string $handle, string $elementType): string
    {
        $elementType = self::stripNamespace($elementType);
        return ucfirst($handle) . str_replace('Type', '', $elementType) . 'Query';
    }

    public static function propertiesDocBlock(array $properties): string
    {
        $docBlock = '';
        foreach ($properties as $name => $type) {
            $docBlock .= " * @property $type $$name" . PHP_EOL;
        }
        return rtrim($docBlock);
    }

    public static function methodsDocBlock(array $methods): string
    {
        $docBlock = '';
        foreach ($methods as $method => $types) {
            $docBlock .= " * @method " . implode('|', (array) $types) . " $method" . PHP_EOL;
        }
        return rtrim($docBlock);
    }
}
