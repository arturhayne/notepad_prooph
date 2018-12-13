<?php

namespace Notepad\Infrastructure\Domain\MetadataEnricher;

use Notepad\Domain\Model\Notepad\NotepadWasAdded;

use Prooph\Common\Messaging\Message;
use Prooph\EventStore\Metadata\MetadataEnricher;

class NotepadMetadataEnricher implements MetadataEnricher
{
    public function enrich(Message $event): Message
    {
        if ($event instanceof NotepadWasAdded) {
            $event = $event->withAddedMetadata('encryption_key', md5((string) $event->id()));
        }
        return $event;
    }
}