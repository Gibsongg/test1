<?php
declare(strict_types=1);

namespace Domain\Entity;

use Domain\ValueObject\Phone;

/** Сущность для телефонов
 * Class UserPhone
 * @package Domain\Entity
 */
class UserPhone
{
    public $id;
    public $number;
    public $numberFormat;

    public function __construct(Phone $number)
    {
        $this->number = $number->phone;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}