<?php
declare(strict_types=1);

namespace Domain\Entity;

use Domain\ValueObject\Phone;

class UserPhone
{
    protected $id;
    protected $userId;
    protected $number;

    public function __construct(int $id, int $userId, Phone $number)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->number = $number;
    }
}