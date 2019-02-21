<?php
namespace Domain\Collection;
use Domain\Entity\Member;

class MemberCollection extends BaseCollection
{
    public function set(Member $item) {
        $this->collection[] = $item;
    }
}