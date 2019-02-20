<?php
declare(strict_types=1);

namespace Infrastructure\Repository;

use Domain\Collection\PhoneCollection;
use Domain\Entity\UserPhone;
use Domain\ValueObject\Phone;

class PhoneRepository implements \IPhoneRepository
{

    public function getByUserId(int $userId): PhoneCollection {
        $collection = new PhoneCollection();

        return $collection;
    }

    public function add(int $userId, UserPhone $phone): bool
    {
        return true;
    }

    public function delete(int $id): bool
    {
        return true;
    }

}