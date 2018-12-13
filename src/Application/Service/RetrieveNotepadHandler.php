<?php

namespace Notepad\Application\Service;


use Notepad\Infrastructure\Domain\Projection\NotepadReadModel;

class RetrieveNotepadHandler
{
    protected $readModel;

    /**
     */
    public function __construct(NotepadReadModel $readModel)
    {
        $this->readModel = $readModel;
    }

    /**
     */
    public function execute(RetrieveNotepadQuery $query)
    {
            $notepad = $this->readModel->get($query->id());
            // In practice a DTO/Data Transformer

            return $notepad;
    }
}