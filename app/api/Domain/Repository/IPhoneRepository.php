<?php
declare(strict_types=1);
use \Domain\Collection\PhoneCollection;

interface IPhoneRepository
{
    public function getByUserId(int $userId): PhoneCollection;
    public function add(int $userId, \Domain\Entity\UserPhone $phone);
    public function delete(int $id): bool;
}