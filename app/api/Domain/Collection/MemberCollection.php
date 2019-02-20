<?php
namespace Domain\Collection;

class MemberCollection extends BaseCollection
{
    public function set(\Phone $item) {
        $this->collection = $item;
    }
}