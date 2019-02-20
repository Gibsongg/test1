<?php
declare(strict_types=1);

namespace Domain\ValueObject;

class Phone
{
    protected $phone;

    public function __construct(string $phone)
    {
        $this->phone = preg_replace('/\D+/', '', $phone);
    }
}