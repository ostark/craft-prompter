<?php

declare(strict_types=1);

namespace ostark\Prompter\Repositories;

class ElementClassRepository
{
    /**
     * A mapping between fake Element classes and additional type hints
     */
    public function fakeHints(): array
    {
        $getImg = ' * @method Twig\Markup getImg($transform = null, array $sizes = null)';
        $type = ' * @method static type(string $value)';
        $section = ' * @method static section(string $value)';
        $volume = ' * @method static volume(string $value)';
        $group = ' * @method static group(string $value)';
        $handle = ' * @method static handle(string $value)';
        $owner = ' * @method static owner(ElementInterface $owner)';

        return [
            'PlainAsset' => [$getImg, $volume],
            'PlainEntry' => [$type, $section],
            'PlainGlobalset' => [$handle],
            'PlainCategory' => [$group],
            'PlainTag' => [$group],
            'PlainMatrixBlock' => [$owner, $type],
        ];
    }
}
