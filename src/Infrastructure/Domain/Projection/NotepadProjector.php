<?php

namespace Notepad\Infrastructure\Domain\Projection;

use Notepad\Domain\Model\Notepad\NotepadWasAdded;
use Notepad\Domain\Model\Notepad\NoteWasAdded;
use Prooph\EventStore\Projection\ProjectionManager;


class NotepadProjector
{
    /** @var ProjectionManager */
    protected $projectionManager;

    /** @var NotepadReadModel */
    protected $readModel;

    /** @var string */
    protected $projectionName = 'projection_notepad';

    /** @var string */
    private $streamCategory;

    /**
     * NotepadProjector constructor.
     * @param ProjectionManager    $projectionManager
     * @param NotepadReadModel $readModel
     */
    public function __construct(ProjectionManager $projectionManager, NotepadReadModel $readModel)
    {
        $this->streamCategory    = 'Notepad\Domain\Model\Notepad\Notepad';
        $this->projectionManager = $projectionManager;
        $this->readModel         = $readModel;
    }

    public function run(bool $keepRunning = false)
    {
        $projection = $this->projectionManager->createReadModelProjection($this->projectionName, $this->readModel);

        $projection->fromCategory($this->streamCategory)
        ->when([
            NotepadWasAdded::class => function ($state, NotepadWasAdded $event) {
                $this->readModel()->stack('createNotepad',
                    (string) $event->id(),
                    [
                        'name' => $event->name(),
                        'userId' => (string) $event->userId(),
                        'notes' => []
                    ]
                );
            },
            NoteWasAdded::class => function ($state, NoteWasAdded $event) {
                $this->readModel()->stack('addNote',
                    (string) $event->id(),
                    [
                        'noteId' => (string) $event->noteId(),
                        'title' => $event->title(),
                        'content' => $event->content(),
                        'userId' => (string) $event->userId()
                    ]
                );
            },
        ])
        ->run($keepRunning);
    }
}