<?php

namespace App\Http\Controllers;

use Faker\Generator;
use Illuminate\Http\Request;
use Notepad\Application\Service\CreateNotepadCommand;
use Notepad\Application\Service\CreateNotepadHandler;
use Ramsey\Uuid\Uuid;

class AddNotepadController extends Controller
{
    protected $handler;

    public function __construct(CreateNotepadHandler $handler)
    {
        $this->handler = $handler;
    }

    public function store(Request $request, Generator $faker)
    {

        $command = new CreateNotepadCommand(
            $faker->title,
            Uuid::uuid4()->toString()
        );

        $notepad = $this->handler->execute($command);
        dd((string) $notepad->id(), $notepad);
    }
}
