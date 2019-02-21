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
}