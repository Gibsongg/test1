<?php
declare(strict_types=1);

namespace Domain\ValueObject;

/** Value Object для телефона чтобы типизировать данные и сделать преобразование в число
 * Class Phone
 * @package Domain\ValueObject
 */
class Phone
{
    public $phone;

    public function __construct(string $phone)
    {
        $this->phone = preg_replace('/\D+/', '', $phone);
    }
}