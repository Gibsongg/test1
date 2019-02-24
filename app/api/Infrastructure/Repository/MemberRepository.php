<?php
/**
 * репозиторий для работы с таблицой контактов
 */
declare(strict_types=1);

namespace Infrastructure\Repository;

use Domain\Collection\MemberCollection;
use Domain\Entity\Member;
use Domain\Repository\IMemberRepository;
//use Domain\Repository\IPhoneRepository;
use Infrastructure\Provider\DB;


class MemberRepository implements IMemberRepository
{
    protected $tableName = 'member';
    protected $phoneRepository;
    private $lastId = null;

    public function __construct()
    {
        //Подключим дополнительно репозиторий телефонов
        $this->phoneRepository = new PhoneRepository();
    }

    /** Выборка списка контактов из базы.
     * Выбираем все т.к. ТЗ не подразумевает пагинацию
     * @return MemberCollection
     */
    public function getList(): MemberCollection
    {
        //Создаем инстанс подключения PDO
        $db = DB::getInstance();
        $rows = $db->query('SELECT * FROM ' . $this->tableName . ' ORDER BY id DESC')->fetchAll();

        //Создадим типизированную коллекцию
        $collection = new MemberCollection();

        foreach ($rows as $item) {
            //Создаем сужность и мапим ее
            $entity = new Member(
                (string)$item['firstname'],
                (string)$item['surname'],
                $this->phoneRepository->getByUserId((int)$item['id'])
            );
            $entity->setId((int)$item['id']);
            //добавляем в коллекцию
            $collection->set($entity);
        }

        return $collection;
    }


    /** Возвращаем пользователя по ID
     * @param int $id
     * @return Member|null
     */
    public function getById(int $id): ?Member
    {
        //Создаем инстанс подключения PDO
        $db = DB::getInstance();
        $row = $db->query('SELECT * FROM ' . $this->tableName . ' WHERE id = ' . $id)->fetch();

        if (!empty($row)) {
            //Создаем сужность и мапим ее
            $entity = new Member(
                (string)$row['firstname'],
                (string)$row['surname'],
                $this->phoneRepository->getByUserId((int)$row['id'])
            );
            $entity->setId((int)$row['id']);
            return $entity;
        } else {
            return null;
        }
    }


    /** Добавление нового контакта
     * @param Member $member
     * @return bool
     */
    public function add(Member $member): bool
    {
        $db = DB::getInstance();
        $row = $db->prepare('INSERT INTO ' . $this->tableName .
            ' (firstname, surname) VALUES (:firstname, :surname)');

        $row->bindValue(':firstname', $member->firstname, SQLITE3_TEXT);
        $row->bindValue(':surname', $member->surname, SQLITE3_TEXT);
        $result = $row->execute();
        $this->lastId = $db->lastInsertId();
        return $result;
    }

    /** Обновление пользователя
     * @param Member $member
     * @return bool
     */
    public function update(Member $member): bool
    {
        $db = DB::getInstance();
        $row = $db->prepare('UPDATE ' . $this->tableName .
        ' SET firstname = :firstname, surname = :surname WHERE id = ' . $member->id);

        $row->bindValue(':firstname', $member->firstname, SQLITE3_TEXT);
        $row->bindValue(':surname', $member->surname, SQLITE3_TEXT);

        return $row->execute();
    }


    /** Удаление контакта
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $db = DB::getInstance();

        $db->beginTransaction();

        try {
            $db->query('DELETE FROM ' . $this->tableName . ' WHERE id = ' . $id)->execute();
            $this->phoneRepository->deleteByMemberId($id);
            $db->commit();
            return true;
        } catch (\Exception $e) {
            $db->rollBack();
            return false;
        }
    }


    public function getLastId(): int
    {
        $db = DB::getInstance();

        return (int)$this->lastId;
    }
}