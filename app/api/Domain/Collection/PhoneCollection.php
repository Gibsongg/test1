<?php
namespace Domain\Collection;

use Domain\Entity\UserPhone;

/** Типизированная коллекция для телефонов
 * Class PhoneCollection
 * @package Domain\Collection
 */
class PhoneCollection extends BaseCollection
{
    public function set(UserPhone $item) {
        $this->collection[] = $item;
    }
}