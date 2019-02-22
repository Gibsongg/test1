<?php
declare(strict_types=1);

namespace Infrastructure\Repository;

use Domain\Collection\PhoneCollection;
use Domain\Entity\UserPhone;
use Domain\Repository\IPhoneRepository;
use Domain\ValueObject\Phone;
use Infrastructure\Provaider\DB;

class PhoneRepository implements IPhoneRepository
{
    protected $tableName = 'phone';

    public function getByUserId(int $userId): PhoneCollection {
        //TODO: При необходимости можно сделать жадную загрузку по списку ID мемберов чтобы уменьшить кол-во запросов


        $db = DB::getInstance();
        $rows = $db->query('SELECT * FROM ' . $this->tableName . ' WHERE member_id = ' . $userId)->fetchAll();

        $collection = new PhoneCollection();
        foreach ($rows as $item) {
            $entity = new UserPhone(new Phone($item['phone_number']));
            $entity->setId((int)$item['id']);
            $collection->set($entity);
        }

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