<?php

namespace Notepad\Domain\Model\User;
use Prooph\EventSourcing\AggregateChanged;

class UserWasAdded extends AggregateChanged{

    protected $id;
    protected $email;
    protected $name;
    
    public static function withData(UserId $id, string $name, Email $email): self
    {
        $event = self::occur((string) $id, [
            'email' => (string) $email,
            'name' => $name
        ]);

        $event->id = $id;
        $event->email = $email;
        $event->name = $name;

        return $event;
    }

    public function id()
    {
        if (null == $this->id) {
            $this->id = UserId::createFromString($this->aggregateId());
        }

        return $this->id;
    } 

    public function email(): Email
    {
        if (null == $this->email) {
            $this->email = Email::create($this->payload['email']);
        }

        return $this->email;
    }

    public function name(): string
    {
        if (null == $this->name) {
            $this->name = $this->payload['name'];
        }

        return $this->name;
    }

}