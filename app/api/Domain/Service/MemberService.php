<?php
declare(strict_types=1);

namespace Domain\Service;

use Domain\Collection\PhoneCollection;
use Domain\Entity\Member;
use Domain\Entity\UserPhone;
use Domain\Repository\IMemberRepository;
use Domain\Repository\IPhoneRepository;
use Domain\ValueObject\Phone;

/** Сервис содержащий основную бизнес логику
 * Class MemberService
 * @package Domain\Service
 */
class MemberService
{

    protected $repository;
    protected $phoneRepository;


    public function __construct(IMemberRepository $memberRepository, IPhoneRepository $phoneRepository)
    {
        $this->repository = $memberRepository;
        $this->phoneRepository = $phoneRepository;
    }

    public function getMemberList()
    {
        return $this->repository->getList()->get();
    }


    public function createMember(array $request)
    {
        if (empty($request['firstname'])) {
            throw new \DomainException('Имя контакта не указано');
        }

        if (empty($request['surname'])) {
            throw new \DomainException('Фамилия контакта не указана');
        }

        //заполняем сущность
        $entity = new Member(
            (string)($request['firstname']),
            (string)($request['surname']),
            new PhoneCollection()
        );

        if (!$this->repository->add($entity)) {
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
    public function updateMember(int $id, array $request): bool
    {
        //TODO: Валидацию лучше вынести в отдельный класс Form/***
        if ($id === 0) {
            throw new \DomainException('ID пользователя не указан');
        }

        if (empty($request['firstname'])) {
            throw new \DomainException('Имя пользователя не указано');
        }

        if (empty($request['surname'])) {
            throw new \DomainException('Фамилия пользователя не указана');
        }

        if ($this->repository->getById($id) === null) {
            throw new \DomainException('Пользователь не найден');
        }

        //заполняем сущность
        $entity = new Member(
            (string)($request['firstname']),
            (string)($request['surname']),
            new PhoneCollection()
        );

        $entity->setId($id);

        if (!$this->repository->update($entity)) {
            throw new \DomainException('Ошибка редактирования контакта');
        }
    }


    public function deleteMember(int $id): bool
    {
        if ($this->repository->getById($id) === null) {
            throw new \DomainException('Пользователь не найден');
        }

        return $this->repository->delete($id);
    }


    public function addPhoneForMember(int $memberId, array $request)
    {
        if ($this->repository->getById($memberId) === null) {
            throw new \DomainException('Пользователь не найден');
        }
        $entity = new UserPhone(new Phone($request['phone']));
        $this->phoneRepository->add($memberId, $entity);
    }


    public function deletePhone(int $id)
    {
        $this->phoneRepository->delete($id);
    }
}