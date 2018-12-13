<?php

namespace App\Http\Controllers;

use Faker\Generator;
use Illuminate\Http\Request;
use Notepad\Application\Service\CreateNoteCommand;
use Notepad\Application\Service\CreateNoteHandler;
use Ramsey\Uuid\Uuid;

class AddNoteController extends Controller
{
    protected $handler;

    public function __construct(CreateNoteHandler $handler)
    {
        $this->handler = $handler;
    }

    public function store($id, Request $request, Generator $faker)
    {

        $command = new CreateNoteCommand(
            $faker->title,
            $faker->text,
            $id
        );

        $notepad = $this->handler->execute($command);
        dd((string) $notepad->id(), $notepad);
    }
}
