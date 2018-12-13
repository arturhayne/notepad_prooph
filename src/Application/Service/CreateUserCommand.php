<?php

namespace Notepad\Application\Service;

class CreateUserCommand{
    public $name;
    public $email;

    public function __construct($name, $email){
        $this->name = $name;
        $this->email = $email;
    }
}