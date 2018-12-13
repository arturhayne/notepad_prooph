<?php

namespace Notepad\Domain\Model\Notepad;

class Note{
    
    protected $id;
    protected $title;
    protected $content;
    protected $notepadId;
    protected $notepad;

    private function __construct(NoteId $id, NotepadId $notepadId,Title $title,string $content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->notepadId = $notepadId;
    }
    
    public static function create(NoteId $id, NotepadId $notepadId, string $title,string $content){
        return new static($id,$notepadId,Title::create($title),$content);
    }

    public function id(){
        return $this->id;
    }

    public function title(){
        return $this->title;
    }

    public function content(){
        return $this->content;
    }

    public function notepadId(){
        return $this->notepadId;
    }

    public function notepad(){
        return $this->notepad;
    }

    public function setNotepad(?Notepad $notepad){
        $this->notepad = $notepad;
    }
    
}