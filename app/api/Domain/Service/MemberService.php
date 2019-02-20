<?php
declare(strict_types=1);

namespace Domain\Service;

use Domain\Repository\MemberRepository;

class MemberService {
    protected $repository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->repository = $memberRepository;
    }
}