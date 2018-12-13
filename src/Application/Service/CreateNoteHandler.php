<?php

namespace Notepad\Application\Service;

use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\Note;


class CreateNoteHandler {

    protected $repository;

    public function __construct(NotepadRepository $repository){
        $this->repository = $repository;
    }

    public function execute(CreateNoteCommand $command){
        $notepad = $this->repository->get($command->notepadId);
        if ($notepad instanceof Notepad) {
            $notepad->createNote($command->title,$command->content);
            $this->repository->save($notepad);
            return $notepad;
        } else {
            throw new \InvalidArgumentException('Non existing Notepad');
        }
    }

}