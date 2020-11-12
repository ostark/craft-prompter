<?php

namespace Tests\Mocks;

use ostark\Prompter\Repositories\ElementContextRepository;

class ElementContextRepositoryMock extends ElementContextRepository
{
    public function getSectionHandles(): array
    {
        return ['sec1', 'sec2', 'sec3'];
    }

    public function getTypeHandles(): array
    {
        return ['type1', 'type2', 'typ3a', 'typ3b', 'type3c'];
    }

    public function getSectionHandlesWithTypeHandles(): array
    {
        return [
            'sec1' => ['type1'],
            'sec2' => ['type2'],
            'sec3' => ['type3a', 'type3b', 'type3c'],
        ];
    }

    public function getVolumeHandles(): array
    {
        return ['vol1', 'vol2'];
    }

    public function getCategoryGroupHandles(): array
    {
        return ['cat1', 'cat2'];
    }

    public function getGlobalSetHandles(): array
    {
        return ['set1', 'set2'];
    }
}
