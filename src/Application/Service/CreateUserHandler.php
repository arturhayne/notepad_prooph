<?php

namespace Notepad\Application\Service;

use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\User\UserId;
use Notepad\Domain\Model\User\User;



class CreateUserHandler{

    protected $repository;

    public function __construct(UserRepository $repository){
        $this->repository = $repository;
    }

    public function execute(CreateUserCommand $command){
        $user = User::create(UserId::Create(),$command->name,$command->email);
        $this->repository->save($user);
        return $user;
    }
}