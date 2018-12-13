<?php

namespace Notepad\Application\Service;

class CreateNoteCommand{
    public $title;
    public $content;
    public $notepadId;

    public function __construct($title,$content,$notepadId){
        $this->title = $title;
        $this->content = $content;
        $this->notepadId = $notepadId;
    }
}