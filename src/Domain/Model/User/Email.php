<?php

namespace Notepad\Domain\Model\User;

class Email{

    protected $value;

    private function __construct($value){
        $this->validateValue($value);
        $this->value = $value;
    }

    public static function create($value) : self{
        return new static ($value);
    }

    public function __toString(){
        return (string) $this->value;
    }

    private function validateValue($value){
        if(!is_string($value)||!strlen($value)){
            throw new \InvalidArgumentException('E-mail can not be null');
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email format');
        }
    }
}