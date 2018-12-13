<?php

namespace Notepad\Infrastructure\Domain\Model;

use Notepad\Domain\Model\Notepad\Notepad;
use Notepad\Domain\Model\Notepad\NotepadId;

use Notepad\Domain\Model\Notepad\NotepadRepository;

use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;
use Prooph\SnapshotStore\SnapshotStore;

class ProophNotepadRepository extends AggregateRepository implements NotepadRepository
{
    public function __construct(EventStore $eventStore, SnapshotStore $snapshotStore)
    {
        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass(Notepad::class),
            new AggregateTranslator(),
            $snapshotStore,
            null,
            true
        );
    }

    public function save(Notepad $notepad): void
    {
        $this->saveAggregateRoot($notepad);
    }

    public function get(string $id): ?Notepad
    {
        return $this->getAggregateRoot($id);
    }
}