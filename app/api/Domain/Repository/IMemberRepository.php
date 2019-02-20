<?php
declare(strict_types=1);

namespace Domain\Repository;

use Domain\Collection\MemberCollection;
use Domain\Entity\Member;

interface IMemberRepository {
    public function getList(): MemberCollection;
    public function add(Member $member): bool;
    public function delete(int $id): bool;
}