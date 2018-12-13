<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Elasticsearch\ClientBuilder;
use Illuminate\Contracts\Foundation\Application;
use Notepad\Domain\Model\User\UserRepository;
use Notepad\Domain\Model\Notepad\NotepadRepository;
use Notepad\Infrastructure\Domain\MetadataEnricher\UserMetadataEnricher;
use Notepad\Infrastructure\Domain\MetadataEnricher\NotepadMetadataEnricher;
use Notepad\Infrastructure\Domain\Model\ProophUserRepository;
use Notepad\Infrastructure\Domain\Model\ProophNotepadRepository;
use Notepad\Infrastructure\Domain\Projection\NotepadProjector;
use Notepad\Infrastructure\Domain\Projection\NotepadReadModel;

use Prooph\Common\Event\ProophActionEventEmitter;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\EventStore\ActionEventEmitterEventStore;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Metadata\MetadataEnricherAggregate;
use Prooph\EventStore\Metadata\MetadataEnricherPlugin;
use Prooph\EventStore\Pdo\MySqlEventStore;
use Prooph\EventStore\Pdo\PersistenceStrategy\MySqlAggregateStreamStrategy;
use Prooph\EventStore\Pdo\Projection\MySqlProjectionManager;
use Prooph\EventStore\Projection\ProjectionManager;
use Prooph\EventStoreBusBridge\EventPublisher;
use Prooph\ServiceBus\EventBus;
use Prooph\SnapshotStore\Pdo\PdoSnapshotStore;
use Prooph\SnapshotStore\SnapshotStore;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // TODO: read the actual config from the .env
        $pdo = new \PDO('mysql:dbname=default;host=mysql', 'root', 'root');

        $this->app->singleton(ProophActionEventEmitter::class, function (Application $app) {
            return new ProophActionEventEmitter();
        });

        $this->app->singleton(EventBus::class, function (Application $app) {
            return new EventBus($app->make(ProophActionEventEmitter::class));
        });

        $this->app->bind(EventStore::class, function (Application $app) use ($pdo) {
            $eventStore = new MySqlEventStore(new FQCNMessageFactory(), $pdo, new MySqlAggregateStreamStrategy());
            $eventEmitter = $app->make(ProophActionEventEmitter::class);
            $eventStore = new ActionEventEmitterEventStore($eventStore, $eventEmitter);

            $eventBus = $app->make(EventBus::class);
            $eventPublisher = new EventPublisher($eventBus);
            $eventPublisher->attachToEventStore($eventStore);

            // Adding metadata enricher
            // Imagine we want to add some metadata to an event this would be one way of doing it before persisting.
            $plugin = new MetadataEnricherPlugin(new MetadataEnricherAggregate(
                [
                    new UserMetadataEnricher(),
                    new NotepadMetadataEnricher(),
                ]
            ));
            $plugin->attachToEventStore($eventStore);

            return $eventStore;
        });

        $this->app->bind(SnapshotStore::class, function (Application $app) use ($pdo){
            return new PdoSnapshotStore($pdo);
        });

        $this->app->bind(UserRepository::class, function (Application $app) {
            return new ProophUserRepository(
                $app->make(EventStore::class),
                $app->make(SnapshotStore::class)
            );
        });

        $this->app->bind(NotepadRepository::class, function (Application $app) {
            return new ProophNotepadRepository(
                $app->make(EventStore::class),
                $app->make(SnapshotStore::class)
            );
        });

        $this->app->bind(ProjectionManager::class, function (Application $app) use ($pdo) {
            return new MySqlProjectionManager(
                $app->make(EventStore::class),
                $pdo
            );
        });

        $this->app->bind(NotepadReadModel::class, function (Application $app) {
            return new NotepadReadModel(ClientBuilder::fromConfig(['hosts' => ['elasticsearch']]));
            });
        
    }
}
