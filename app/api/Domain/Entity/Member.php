<?php
declare(strict_types=1);

namespace Domain\Entity;

class Member
{
    protected $id;
    public $firstname;
    public $surname;

    public function __construct(int $id, string $firstname, string $surname)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->surname = $surname;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}