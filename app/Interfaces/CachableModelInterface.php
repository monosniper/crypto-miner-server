<?php

namespace App\Interfaces;

interface CachableModelInterface
{
    function getCacheValue(): array;
}
