<?php

namespace Notepad\Domain\Model\User;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;


class User extends AggregateRoot{
    
    /** @var Uuid */
    protected $id;

    /** @var string */
    protected $name;

    /** @var Email */
    protected $email;

    public static function create(UserId $id,string $name, string $email){

        $obj = new self();
        $obj->recordThat(UserWasAdded::withData(
            $id,
            $name,
            Email::create($email)
        ));
        return $obj;
    }

    public function whenUserWasAdded(UserWasAdded $event): void
    {
        $this->id = $event->id();
        $this->name = $event->name();
        $this->email = $event->email();
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

    /**
     * @return UserId
     */
    public function id(): UserId{
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string{
        return $this->name;
    }

    /**
     * @return Email
     */
    public function email(): Email{
        return $this->email;
    }

    protected function aggregateId(): string
    {
        return (string) $this->id();
    }

}