<?php

namespace Notepad\Infrastructure\Domain\MetadataEnricher;

use Notepad\Domain\Model\User\UserWasAdded;

use Prooph\Common\Messaging\Message;
use Prooph\EventStore\Metadata\MetadataEnricher;

class UserMetadataEnricher implements MetadataEnricher
{
    public function enrich(Message $event): Message
    {
        if ($event instanceof UserWasAdded) {
            $event = $event->withAddedMetadata('encryption_key', md5((string) $event->id()));
        }
        return $event;
    }
}