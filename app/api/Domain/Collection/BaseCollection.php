<?php
declare(strict_types=1);

namespace Domain\Collection;

class BaseCollection
{
    protected $collection;

    public function get()
    {
        return $this->collection;
    }
}