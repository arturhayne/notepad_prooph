<?php

namespace Notepad\Domain\Model\Notepad;

interface NotepadRepository{
    public function get(string $notepadId): ?Notepad;
    public function save(Notepad $notepad): void; 
}