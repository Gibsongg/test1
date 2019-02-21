<?php
declare(strict_types=1);

namespace Domain\ValueObject;

class Phone
{
    public $phone;

    public function __construct(string $phone)
    {
        $this->phone = preg_replace('/\D+/', '', $phone);

        //TODO: тут можно сделать проверку на кол-во символов и выдать исключение если потребуется
    }
}