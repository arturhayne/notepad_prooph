<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notepad\Application\Service\RetrieveNotepadHandler;
use Notepad\Application\Service\RetrieveNotepadQuery;
use Notepad\Domain\Model\Notepad\NotepadNotFoundException;

class RetrieveNotepadController extends Controller
{
    /** @var RetrieveNotepadHandler */
    protected $handler;

    /**
     * RetrieveNotepadController constructor.
     * @param RetrieveNotepadHandler $handler
     */
    public function __construct(RetrieveNotepadHandler $handler)
    {
        $this->handler = $handler;
    }

    public function show($id)
    {
        try {
            return response()->json($this->handler->execute(new RetrieveNotepadQuery($id)));
        } catch (NotepadFoundException $exception) {
            return response()->json(
                [ 'error' => $exception->getMessage(), 'code' => $exception->getCode() ],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
