<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Notepad\Infrastructure\Domain\Projection\NotepadProjector;

class ProjectNotepad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:notepad';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Project Notepad';

    /** @var Notepadrojector */
    protected $projector;

    /**
     * ProjectNotepad constructor.
     * @param NotepadProjector $projector
     */
    public function __construct(NotepadProjector $projector)
    {
        parent::__construct();
        $this->projector = $projector;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->projector->run(true);
    }
}
