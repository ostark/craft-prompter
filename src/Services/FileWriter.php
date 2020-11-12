<?php

namespace ostark\Prompter\Services;

interface FileWriter
{
    public const CLASS_STUB = 'class.stub';
    public const PLAIN_ELEMENTS_FILE = 'base.elements.stub';
    public const EXTENSION_CLASS_FILE = 'extension.class.stub';
    public const VARIABLE_CLASS_FILE = 'variable.class.stub';
    public const PHPSTORM_META_FILE = 'phpstorm.meta.stub';

    public function write(string $path): bool;
}
