<?php
namespace Domain\Collection;
use Domain\Entity\Member;

/** Типизированная коллекция для контакта
 * Class MemberCollection
 * @package Domain\Collection
 */
class MemberCollection extends BaseCollection
{
    public function set(Member $item) {
        $this->collection[] = $item;
    }
}