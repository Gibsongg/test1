<?php
declare(strict_types=1);


namespace Infrastructure\Controllers;

use Domain\Service\MemberService;


class MemberController
{
    protected $service;


    public function __construct(MemberService $service)
    {
        $this->service = $service;
    }


    public function actionIndex()
    {
        $data = $this->service->getMemberList();

        return $data;
    }

    public function actionCreate()
    {
        return $this->service->createMember($_REQUEST);

    }

    public function actionUpdate($id)
    {
        $this->service->updateMember((int)$id, $_REQUEST);
    }


    public function actionDelete($id)
    {
        $this->service->deleteMember((int) $id);
    }
}
