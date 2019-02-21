<?php
declare(strict_types=1);

namespace Domain\Entity;

use Domain\ValueObject\Phone;

class UserPhone
{
    public $id;
    public $number;

    public function __construct(Phone $number)
    {
        $this->number = $number->phone;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}