<?php

declare(strict_types=1);

namespace ostark\Prompter\Services;

use ostark\Prompter\Repositories\ElementContextRepository;
use ostark\Prompter\Repositories\FieldLayout\AssetType;
use ostark\Prompter\Repositories\FieldLayout\EntryType;
use ostark\Prompter\Repositories\FieldLayout\GlobalsetType;
use ostark\Prompter\Services\TypeHintOutput\Php;
use ostark\Prompter\Services\TypeHintOutput\Twig;
use ostark\Prompter\Services\TypeHintOutput\TypeHintOutput;

class TypeHintHelpGenerator
{
    private ElementContextRepository $context;

    private TypeHintOutput $output;

    public function __construct(ElementContextRepository $context)
    {
        $this->context = $context;
        $this->output = new Twig();
    }

    public function setOutputFormat(string $format): self
    {
        if ($format === 'php') {
            $this->output = new Php();
        }
        return $this;
    }

    public function entry(?string $handle = null): string
    {
        // Full example
        if ($handle) {
            $type = new EntryType($handle, []);
            $type->getElementTypeQueryClass();
            $queryClass = $type->getElementTypeQueryClass();
            $entryClass = $type->getElementTypeClass();

            return $this->output->fullTemplate($handle, $queryClass, $entryClass);
        }

        // List
        $output = '';
        foreach ($this->context->getTypeHandles() as $handle) {
            $type = new EntryType($handle, []);
            $output .= $this->output->listTemplate(
                $handle,
                $type->getElementTypeQueryClass(),
                TypeHintOutput::ENTRY_TYPE_QUERY
            );
        }

        return $output;
    }

    public function asset(): string
    {
        $output = '';
        foreach ($this->context->getVolumeHandles() as $handle) {
            $type = new AssetType($handle, []);
            $output .= $this->output->listTemplate(
                $handle,
                $type->getElementTypeQueryClass(),
                TypeHintOutput::ASSET_QUERY
            );
        }

        return $output;
    }

    public function section(): string
    {
        $output = '';
        foreach ($this->context->getSectionHandles() as $handle) {
            $output .= $this->output->listTemplate(
                $handle,
                ucfirst($handle) . 'SectionQuery',
                TypeHintOutput::ENTRY_SECTION_QUERY
            );
        }
        return $output;
    }

    public function globalset(): string
    {
        $output = '';
        foreach ($this->context->getGlobalSetHandles() as $handle) {
            $type = new GlobalsetType($handle, []);
            $output .= $this->output->listTemplateGlobalset(
                $handle,
                $type->getElementTypeClass()
            );
        }
        return $output;
    }
}
