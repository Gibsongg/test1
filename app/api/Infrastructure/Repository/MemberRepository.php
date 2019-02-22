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
        $data = [
            [
                'id' => 1,
                'firstname' => 'Петр',
                'surname' => 'Васильев'
            ],
            [
                'id' => 2,
                'firstname' => 'Роман',
                'surname' => 'Скляров'
            ]
        ];

        $collection = new MemberCollection();

        foreach ($data as $item) {
            $entity = new Member(
                $item['id'],
                $item['firstname'],
                $item['surname']
            );
            $entity->setId($item['id']);

            $collection->set($entity);
        }

        return $collection;
    }



    public function getById(int $id) {

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