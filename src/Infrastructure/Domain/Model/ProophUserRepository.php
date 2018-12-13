<?php

namespace Notepad\Infrastructure\Domain\Model;

use Notepad\Domain\Model\User\User;
use Notepad\Domain\Model\User\UserId;

use Notepad\Domain\Model\User\UserRepository;

use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;
use Prooph\SnapshotStore\SnapshotStore;

class ProophUserRepository extends AggregateRepository implements UserRepository
{
    public function __construct(EventStore $eventStore, SnapshotStore $snapshotStore)
    {
        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass(User::class),
            new AggregateTranslator(),
            $snapshotStore,
            null,
            true
        );
    }

    public function save(User $user): void
    {
        $this->saveAggregateRoot($user);
    }

    public function get(string $id): ?User
    {
        return $this->getAggregateRoot($id);
    }
}