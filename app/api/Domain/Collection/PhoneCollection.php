<?php
namespace Domain\Collection;

class PhoneCollection extends BaseCollection
{
    public function set(\Phone $item) {
        $this->collection = $item;
    }
}