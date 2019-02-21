<?php
declare(strict_types=1);

namespace Domain\Entity;

use Domain\Collection\PhoneCollection;

class Member
{
    protected $id;
    public $firstname;
    public $surname;
    public $phone;

    public function __construct(string $firstname, string $surname, PhoneCollection $phone)
    {
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->phone = $phone->get();
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}