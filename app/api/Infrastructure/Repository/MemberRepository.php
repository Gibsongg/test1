<?php
declare(strict_types=1);

namespace Infrastructure\Repository;

use Domain\Collection\MemberCollection;
use Domain\Entity\Member;
use Domain\Repository\IMemberRepository;

class MemberRepository implements IMemberRepository
{
    public function getList(): MemberCollection
    {
        $collection = new MemberRepository();

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