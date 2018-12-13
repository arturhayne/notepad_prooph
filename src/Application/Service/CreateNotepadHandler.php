<?php

namespace Notepad\Application\Service;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\NotepadId;
use Notepad\Domain\Model\User\UserId;
use Notepad\Domain\Model\Notepad\Notepad;

class CreateNotepadHandler{

    protected $repository;

    public function __construct(NotepadRepository $repository){
        $this->repository = $repository;
    }
    
    public function execute(CreateNotepadCommand $command) {
        $notepad = Notepad::create(NotepadId::create(),
            UserId::createFromString($command->userId),
            $command->name);
        $this->repository->save($notepad);
        return $notepad;
    }
}