<?php

namespace App\Enums\Contracts;

interface HasLabel
{
    /**
     * @return string
     */
    public function label(): string;
}