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
        return $this->repository->getList()->get();
    }
}