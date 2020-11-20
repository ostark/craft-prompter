<?php

declare(strict_types=1);

namespace ostark\Prompter\Repositories;

use craft\records\CategoryGroup as CategoryGroupRecord;
use craft\records\EntryType as EntryTypeRecord;
use craft\records\GlobalSet as GlobalSetRecord;
use craft\records\Section as SectionRecord;
use craft\records\Volume as VolumeRecord;

class ElementContextRepository
{
    public function getSectionHandles(): array
    {
        /** @var SectionRecord[] $records */
        $records = SectionRecord::find()->select('handle')->all();

        // handles
        return array_map(fn ($item) => $item->handle, $records);
    }

    public function getTypeHandles(): array
    {
        /** @var EntryTypeRecord[] $records */
        $records = EntryTypeRecord::find()->select('handle')->all();

        // handles
        return array_map(fn ($item) => $item->handle, $records);
    }

    public function getSectionHandlesWithTypeHandles(): array
    {
        /** @var EntryTypeRecord[] $records */
        $records = EntryTypeRecord::find()->all();
        $handles = [];

        foreach ($records as $item) {
            $handles[$item->section->handle][] = $item->handle;
        }

        return $handles;
    }

    public function getVolumeHandles(): array
    {
        /** @var VolumeRecord[] $records */
        $records = VolumeRecord::find()->select('handle')->all();

        // handles
        return array_map(static fn ($item) => $item->handle, $records);
    }

    public function getCategoryGroupHandles(): array
    {
        /** @var CategoryGroupRecord[] $records */
        $records = CategoryGroupRecord::find()->select('handle')->all();

        // handles
        return array_map(static fn ($item) => $item->handle, $records);
    }

    public function getGlobalSetHandles(): array
    {
        /** @var GlobalSetRecord[] $records */
        $records = GlobalSetRecord::find()->select('handle')->all();

        // handles
        return array_map(static fn ($item) => $item->handle, $records);
    }
}
