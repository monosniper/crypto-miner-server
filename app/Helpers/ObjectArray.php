<?php

namespace App\Helpers;

use SplObjectStorage;

class ObjectArray extends SplObjectStorage
{
    public function __construct(
        public array $items
    ) {
        $this->attachItems();
    }

    protected function attachItems(): void
    {
        foreach ($this->items as $item) $this[$item[0]] = $item[1];
    }

    public function get($name) {
        return $this->offsetGet($name);
    }
}
