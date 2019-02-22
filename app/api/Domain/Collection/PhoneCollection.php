<?php
namespace Domain\Collection;

use Domain\Entity\UserPhone;

class PhoneCollection extends BaseCollection
{
    public function set(UserPhone $item) {
        $this->collection = $item;
    }
}