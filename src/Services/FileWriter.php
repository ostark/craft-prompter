<?php

namespace ostark\Prompter\Services;

interface FileWriter
{
    public function collect(): bool;
    public function write(): bool;
}
