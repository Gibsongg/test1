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
use Infrastructure\Provaider\DB;


class MemberRepository implements IMemberRepository
{
    protected $tableName = 'member';
    protected $phoneRepository;

    public function __construct()
    {
        //Подключим дополнительно репозиторий телефонов
        $this->phoneRepository  = new PhoneRepository();
    }

    /** Выборка списка контактов из базы.
     * Выбираем все т.к. ТЗ не подразумевает пагинацию
     * @return MemberCollection
     */
    public function getList(): MemberCollection
    {
        //Создаем инстанс подключения PDO
        $db = DB::getInstance();
        $rows = $db->query('SELECT * FROM ' . $this->tableName)->fetchAll();

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

    public function add(Member $member): bool
    {

        return true;
    }

    public function delete(int $id): bool
    {

        return true;
    }
}