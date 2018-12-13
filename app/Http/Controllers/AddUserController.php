<?php

namespace App\Http\Controllers;

use Faker\Generator;
use Illuminate\Http\Request;
use Notepad\Application\Service\CreateUserCommand;
use Notepad\Application\Service\CreateUserHandler;
use Ramsey\Uuid\Uuid;

class AddUserController extends Controller
{
    protected $handler;

    public function __construct(CreateUserHandler $handler)
    {
        $this->handler = $handler;
    }

    public function store(Request $request, Generator $faker)
    {

        $command = new CreateUserCommand(
            $faker->userName,
            $faker->email
        );

        $user = $this->handler->execute($command);
        dd((string) $user->id(), $user);
    }
}
