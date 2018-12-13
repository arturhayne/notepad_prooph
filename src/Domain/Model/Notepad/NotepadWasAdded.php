<?php

namespace Notepad\Domain\Model\Notepad;
use Prooph\EventSourcing\AggregateChanged;
use Notepad\Domain\Model\User\UserId;


class NotepadWasAdded extends AggregateChanged{
    protected $id;
    protected $userId;
    protected $name;
    
    public static function withData(NotepadId $id, UserId $userId, string $name): self
    {
        $event = self::occur((string) $id, [
            'userId' => (string) $userId,
            'name' => $name
        ]);

        $event->id = $id;
        $event->userId = $userId;
        $event->name = $name;

        return $event;
    }

    public function id()
    {
        if (null == $this->id) {
            $this->id = NotepadId::createFromString($this->aggregateId());
        }

        return $this->id;
    } 

    public function userId(): UserId
    {
        if (null == $this->userId) {
            $this->userId = UserId::create($this->payload['userId']);
        }

        return $this->userId;
    }

    public function name(): string
    {
        if (null == $this->name) {
            $this->name = $this->payload['name'];
        }

        return $this->name;
    }

}