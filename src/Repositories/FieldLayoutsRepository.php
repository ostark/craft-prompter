<?php

declare(strict_types=1);

namespace ostark\Prompter\Repositories;

use craft\base\FieldInterface;
use craft\records\CategoryGroup as CategoryGroupRecord;
use craft\records\EntryType as EntryTypeRecord;
use craft\records\FieldLayout as FieldLayoutRecord;
use craft\records\GlobalSet as GlobalSetRecord;
use craft\records\Volume as VolumeRecord;
use ostark\Prompter\Repositories\FieldLayout\AssetType;
use ostark\Prompter\Repositories\FieldLayout\CategoryType;
use ostark\Prompter\Repositories\FieldLayout\EntryType;
use ostark\Prompter\Repositories\FieldLayout\GlobalsetType;
use ostark\Prompter\Repositories\FieldLayout\LayoutType;
use ReflectionClass;
use Throwable;

class FieldLayoutsRepository
{
    /**
     * @var MatrixBlocksRepository
     */
    protected $matrixRepo;

    public function __construct(MatrixBlocksRepository $matrixRepo)
    {
        $this->matrixRepo = $matrixRepo;
    }

    /**
     * @return LayoutType[]
     */
    public function all(): array
    {
        return array_merge(
            $this->getEntryTypes(),
            $this->getAssetTypes(),
            $this->getCategoryTypes(),
            $this->getGlobalSetTypes()
        );
    }

    /**
     * @return EntryType[]
     */
    protected function getEntryTypes(): array
    {
        /** @var EntryTypeRecord[] $elements */
        $elements = EntryTypeRecord::find()->all();
        $result = [];

        foreach ($elements as $element) {
            $result[] = new EntryType(
                $element->handle,
                $this->getFieldsFromLayout($element->fieldLayout)
            );
        }

        return $result;
    }

    protected function getFieldsFromLayout(FieldLayoutRecord $layout): array
    {
        $fields = [];
        $blocks = $this->matrixRepo->indexedByHandle();

        foreach ($layout->fields as $field) {
            // A MatrixBlock field
            if (isset($blocks[$field->field->handle])) {
                $fields[$field->field->handle] = $blocks[$field->field->handle];
                continue;
            }

            // All other field types
            $fields[$field->field->handle] = $this->getValueType($field->field->type);
        }

        return $fields;
    }

    protected function getValueType(string $fieldClassName): string
    {
        try {
            if ((new ReflectionClass($fieldClassName))->implementsInterface(
                FieldInterface::class
            )) {
                return call_user_func([$fieldClassName, 'valueType']);
            }
        } catch (Throwable $exception) {
        }

        return $fieldClassName;
    }

    /**
     * @return AssetType[]
     */
    protected function getAssetTypes(): array
    {
        /** @var VolumeRecord[] $elements */
        $elements = VolumeRecord::find()->all();
        $result = [];

        foreach ($elements as $element) {
            $result[] = new AssetType(
                $element->handle,
                $this->getFieldsFromLayout($element->fieldLayout)
            );
        }

        return $result;
    }

    /**
     * @return CategoryType[]
     */
    protected function getCategoryTypes(): array
    {
        /** @var CategoryGroupRecord[] $elements */
        $elements = CategoryGroupRecord::find()->all();
        $result = [];

        foreach ($elements as $element) {
            $result[] = new CategoryType(
                $element->handle,
                $this->getFieldsFromLayout($element->fieldLayout)
            );
        }

        return $result;
    }

    /**
     * @return GlobalsetType[]
     */
    protected function getGlobalSetTypes(): array
    {
        /** @var GlobalSetRecord[] $elements */
        $elements = GlobalSetRecord::find()->all();
        $result = [];

        foreach ($elements as $element) {
            $result[] = new GlobalsetType(
                $element->handle,
                $this->getFieldsFromLayout($element->fieldLayout)
            );
        }

        return $result;
    }
}
