<?php

declare(strict_types=1);

namespace ostark\Prompter;

use craft\base\Model;

class Settings extends Model
{
    public bool $generateOnChange = false;

    public string $path;

    public function __construct($config = [])
    {
        parent::__construct($config);

        if (defined('CRAFT_BASE_PATH')) {
            $this->path = CRAFT_BASE_PATH;
        }
    }
}
