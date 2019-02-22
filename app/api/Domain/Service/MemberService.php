<?php
declare(strict_types=1);

namespace Domain\Service;

use Domain\Repository\IMemberRepository;

class MemberService {
    protected $repository;

    public function __construct(IMemberRepository $memberRepository)
    {
        $this->repository = $memberRepository;
    }

    public function getMemberList()
    {
        echo '<pre>' . print_r($this->repository->getList()->get(), true) . '</pre>';
        return $this->repository->getList()->get();
    }

    public function addMember(int $id, array $request) {
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




        $firstname = isset($request['firstname']) ?? null;
        $surname = isset($request['surname']) ?? null;
    }
}