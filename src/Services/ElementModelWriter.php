<?php

declare(strict_types=1);

namespace ostark\Prompter\Services;

use ostark\Prompter\ClassHelper;
use ostark\Prompter\Repositories\ElementClassRepository;
use ostark\Prompter\Repositories\ElementContextRepository;
use ostark\Prompter\Repositories\FieldLayout\EntryType;
use ostark\Prompter\Repositories\FieldLayoutsRepository;
use ostark\Prompter\Repositories\MatrixBlocksRepository;

class ElementModelWriter implements FileWriter
{
    public const TARGET_FILE = '.craft.prompter.model.php';

    private FieldLayoutsRepository $fieldLayouts;

    private ElementContextRepository $context;

    private MatrixBlocksRepository $matrix;

    private ElementClassRepository $elementClass;

    private string $template;

    public function __construct(
        FieldLayoutsRepository $fieldLayouts,
        ElementContextRepository $entryContext,
        MatrixBlocksRepository $matrix,
        ElementClassRepository $elementClass
    ) {
        $this->fieldLayouts = $fieldLayouts;
        $this->context = $entryContext;
        $this->matrix = $matrix;
        $this->elementClass = $elementClass;
        $this->template = $this->getClassTemplate();
    }

    public function write(string $path): bool
    {
        $parts = [$this->renderPlainElementClasses()];

        $layouts = $this->fieldLayouts->all();
        $sectionsAndTypes = $this->context->getSectionHandlesWithTypeHandles();
        $matrixFields = $this->matrix->indexedByHandle();

        $parts[] = $this->renderPlainQueryClasses();

        // Entry, Asset, Category layout type classes
        foreach ($layouts as $layout) {
            $parts[] = $this->renderClassTemplateWithProperties(
                $layout->getElementTypeClass(),
                $layout->getElementBaseClass(),
                $layout->fields
            );
        }

        // Type Query classes for all elements
        foreach ($layouts as $layout) {
            $parts[] = $this->renderQueryClassTemplate(
                $layout->getElementTypeQueryClass(),
                [$layout->getElementTypeClass()],
                $layout->getElementBaseClass() . 'Query'
            );
        }

        // Section Query classes for entries
        foreach ($sectionsAndTypes as $section => $entry) {
            // Turn Entry handle into Class name
            $entryClasses = array_map(
                static fn ($handle) => ClassHelper::elementClass($handle, EntryType::class),
                $entry
            );
            $parts[] = $this->renderQueryClassTemplate(
                ucfirst($section) . 'SectionQuery',
                $entryClasses
            );
        }

        // Matrix block classes with fields
        foreach ($matrixFields as $matrix) {
            $parts[] = $this->renderClassTemplateWithProperties(
                $matrix->getElementTypeClass(),
                $matrix->getElementBaseClass(),
                $matrix->fields
            );
        }

        $target = $path . DIRECTORY_SEPARATOR . self::TARGET_FILE;
        return file_put_contents($target, implode(PHP_EOL, $parts));
    }

    private function getClassTemplate(): string
    {
        return file_get_contents(__DIR__ . '/../stubs/' . self::CLASS_STUB);
    }

    private function renderPlainElementClasses(): string
    {
        return file_get_contents(__DIR__ . '/../stubs/' . self::PLAIN_ELEMENTS_FILE);
    }

    private function renderClassTemplateWithProperties(
        string $class,
        string $baseClass,
        array $properties
    ): string {
        $template = str_replace('{{ class }}', $class, $this->template);
        $template = str_replace('{{ baseClass }}', $baseClass, $template);
        return str_replace(
            '{{ docblock }}',
            ClassHelper::propertiesDocBlock($properties),
            $template
        );
    }

    private function renderQueryClassTemplate(
        string $className,
        array $types,
        string $baseClass = 'PlainElementQuery',
        string $rawDocBlock = ''
    ): string {
        $methods = [
            'one($db = null)' => $types,
            'all($db = null)' => array_map(static fn ($type) => $type . '[]', $types),
        ];

        $template = str_replace('{{ class }}', $className, $this->template);
        $template = str_replace('{{ baseClass }}', $baseClass, $template);
        $template = str_replace(
            '{{ docblock }}',
            ClassHelper::methodsDocBlock($methods) . $rawDocBlock,
            $template
        );

        return $template;
    }

    private function renderPlainQueryClasses(): string
    {
        $parts = [];

        foreach ($this->elementClass->fakeHints() as $class => $hints) {
            $parts[] = $this->renderQueryClassTemplate(
                $class . 'Query',
                [$class],
                'PlainElementQuery',
                PHP_EOL . implode(PHP_EOL, $hints)
            );
        }

        return implode(PHP_EOL, $parts);
    }
}
