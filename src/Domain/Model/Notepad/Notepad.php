<?php

namespace Notepad\Domain\Model\Notepad;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Notepad\Domain\Model\User\UserId;

class Notepad extends AggregateRoot{ 

    protected $id;
    protected $userId;
    protected $name;
    protected $notes;

    const MAX_NOTES = 5;

    public static function create(NotepadId $notepadId, UserId $userId, string $name){

        $obj = new self();
        $obj->recordThat(NotepadWasAdded::withData(
            $notepadId,
            $userId,
            $name
        ));
        return $obj;
    }

    public function createNote($title, $content){
        
        if(count($this->notes)>=self::MAX_NOTES){
            throw new \InvalidArgumentException('Max number notes exceeded');
        }

        $noteId = NoteId::create();
        $this->recordThat(NoteWasAdded::withData(
            $noteId,
            $this->id,
            $title,
            $content,
            $this->userId
        ));
    } 

    public function whenNotepadWasAdded(NotepadWasAdded $event): void
    {
        $this->id = $event->id();
        $this->userId = $event->userId();
        $this->name = $event->name();
        $this->notes = [];
    }

    public function whenNoteWasAdded(NoteWasAdded $event): void
    {
        $this->notes[(string) $event->noteId()] = Note::create(
                                NoteId::createFromString($event->noteId()), 
                                NotepadId::createFromString($event->aggregateId()), 
                                $event->title(), 
                                $event->content());
    }

    protected function apply(AggregateChanged $event): void
    {
        $handler = $this->determineEventHandlerMethodFor($event);
        if (! method_exists($this, $handler)) {
            throw new \RuntimeException(sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                get_class($this)
            ));
        }
        $this->{$handler}($event);
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $e): string
    {
        return 'when' . implode(array_slice(explode('\\', get_class($e)), -1));
    }

    public function id(){
        return $this->id;
    }

    public function name(){
        return $this->name;
    }

    public function userId(){
        return $this->userId;
    }

    public function notes(){
        return $this->notes;
    }

    protected function aggregateId(): string
    {
        return (string) $this->id();
    } 

}