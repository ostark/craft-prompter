<?php

namespace ostark\Prompter;

use craft\base\Model;

class Settings extends Model
{
    public $twig;
    public $phpStormMeta;
    public $models;
    public $generateOnChange = false;
}
