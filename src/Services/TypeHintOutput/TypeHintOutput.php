<?php

namespace ostark\Prompter\Services\TypeHintOutput;

interface TypeHintOutput
{
    public const ENTRY_TYPE_QUERY = 'type';
    public const ENTRY_SECTION_QUERY = 'section';
    public const ASSET_QUERY = 'asset';

    public function fullTemplate(string $handle, string $queryClass, string $elementClass): string;

    public function listTemplate(string $handle, string $queryClass, string $query): string;

    public function listTemplateGlobalset(string $handle, string $class): string;
}
