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

    }

    public function actionUpdate($id)
    {

        $this->service->addMember((int)$id, $_REQUEST);
    }

}
