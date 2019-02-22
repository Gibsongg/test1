<?php
declare(strict_types=1);

namespace Domain\Service;

use Domain\Collection\PhoneCollection;
use Domain\Entity\Member;
use Domain\Repository\IMemberRepository;

class MemberService {

    protected $repository;


    public function __construct(IMemberRepository $memberRepository)
    {
        $this->repository = $memberRepository;
    }

    public function getMemberList()
    {
        return $this->repository->getList()->get();
    }



    public function createMember(array $request)
    {
        if(empty($request['firstname'])) {
            throw new \DomainException('Имя контакта не указано');
        }

        if(empty($request['surname'])) {
            throw new \DomainException('Фамилия контакта не указана');
        }

        //заполняем сущность
        $entity = new Member(
            (string)($request['firstname']),
            (string)($request['surname']),
            new PhoneCollection()
        );

        if(!$this->repository->add($entity)) {
            throw new \DomainException('Ошибка при добавлении контакта');
        } else {
            return [
                'id' => $this->repository->getLastId()
            ];
        }
    }


    /** Метод интерфейса отвечающий за
     * @param int $id
     * @param array $request
     * @return bool
     */
    public function updateMember(int $id, array $request): bool {
        //TODO: Валидацию лучше вынести в отдельный класс Form/***
        if($id === 0) {
            throw new \DomainException('ID пользователя не указан');
        }

        if(empty($request['firstname'])) {
            throw new \DomainException('Имя пользователя не указано');
        }

        if(empty($request['surname'])) {
            throw new \DomainException('Фамилия пользователя не указана');
        }

        if($this->repository->getById($id) === null) {
            throw new \DomainException('Пользователь не найден');
        }

        //заполняем сущность
        $entity = new Member(
            (string)($request['firstname']),
            (string)($request['surname']),
            new PhoneCollection()
        );

        $entity->setId($id);

        if(!$this->repository->update($entity)) {
            throw new \DomainException('Ошибка редактирования контакта');
        }
    }


    public function deleteMember(int $id): bool
    {
        if($this->repository->getById($id) === null) {
            throw new \DomainException('Пользователь не найден');
        }

        return $this->repository->delete($id);
    }
}