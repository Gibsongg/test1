<?php
declare(strict_types=1);

namespace Infrastructure\Repository;

use Domain\Collection\PhoneCollection;
use Domain\Entity\UserPhone;
use Domain\Repository\IPhoneRepository;
use Domain\ValueObject\Phone;
use Infrastructure\Provider\DB;

class PhoneRepository implements IPhoneRepository
{
    protected $tableName = 'phone';

    //TODO: При необходимости можно сделать жадную загрузку по списку ID мемберов чтобы уменьшить кол-во запросов

    /** находит список телефонов контакта
     * @param int $userId
     * @return PhoneCollection
     */
    public function getByUserId(int $userId): PhoneCollection {

        $db = DB::getInstance();
        $rows = $db->query('SELECT * FROM ' . $this->tableName . ' WHERE member_id = ' . $userId)->fetchAll();

        $collection = new PhoneCollection();

        foreach ($rows as $item) {
            $entity = new UserPhone(new Phone((string)$item['phone_number']));
            $entity->setId((int)$item['id']);
            $collection->set($entity);
        }

        return $collection;
    }

    /** Метод добавления телефона к кондакту
     * @param int $memberId
     * @param UserPhone $phone
     * @return bool
     *
     */
    public function add(int $memberId, UserPhone $phone): bool
    {
        $db = DB::getInstance();
        $row = $db->prepare('INSERT INTO ' . $this->tableName .
            ' (member_id, phone_number) VALUES (:member_id, :phone_number)');

        $row->bindValue(':member_id', $memberId, SQLITE3_INTEGER);
        $row->bindValue(':phone_number', $phone->number, SQLITE3_NUM);
        $result = $row->execute();
        $this->lastId = $db->lastInsertId();
        return $result;
    }

    public function delete(int $id): bool
    {
        $db = DB::getInstance();
        return $db->query('DELETE FROM ' . $this->tableName . ' WHERE id = ' . $id)->execute();
    }

    public function deleteByMemberId(int $id): bool
    {
        $db = DB::getInstance();
        return $db->query('DELETE FROM ' . $this->tableName . ' WHERE member_id = ' . $id)->execute();
    }

}