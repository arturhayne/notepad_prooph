<?php
namespace Notepad\Domain\Model\Notepad;

use Ramsey\Uuid\Uuid;

class NoteId{
    protected $value;

    private function __construct($value = null){
        $this->value = $value ?: Uuid::uuid4();
    }

    public static function create ($value = null) : self{
        return new self ($value);
    }

    public static function createFromString(string $value): self
    {
        return new static($value);
    }

    public function __toString()
    {
        return (string) $this->value;        
    }

    public function equals(NoteId $noteId){
        return $this->value === $noteId->value;
    }
}