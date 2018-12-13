<?php

namespace Notepad\Domain\Model\Notepad;
use Notepad\Domain\Model\User\UserId;
use Prooph\EventSourcing\AggregateChanged;

class NoteWasAdded extends AggregateChanged{

    private $id;
    protected $noteId;
    protected $title;
    protected $content;
    protected $userId;

    public static function withData(NoteId $noteId, NotepadId $notepadId, string $title, string $content, UserId $userId): self
    {
        $event = self::occur((string) $notepadId, [
            'noteId' => (string) $noteId,
            'userId' => (string) $userId,
            'title' => $title,
            'content' => $content
        ]);

        $event->id = $notepadId;
        $event->noteId = $noteId;
        $event->userId = $userId;
        $event->title = $title;
        $event->content = $content;

        return $event;
    }

    public function id(): NotepadId
    {
        if (null == $this->id) {
            $this->id = NotepadId::create($this->aggregateId());
        }

        return $this->id;
    }

    public function noteId(): NoteId
    {
        if (null == $this->noteId) {
            $this->noteId = NoteId::createFromString($this->payload['noteId']);
        }

        return $this->noteId;
    } 

    public function userId(): UserId
    {
        if (null == $this->userId) {
            $this->userId = UserId::create($this->payload['userId']);
        }

        return $this->userId;
    }

    public function title(): string
    {
        if (null == $this->title) {
            $this->title = $this->payload['title'];
        }

        return $this->title;
    }

    public function content(): string
    {
        if (null == $this->content) {
            $this->content = $this->payload['content'];
        }

        return $this->content;
    }

}