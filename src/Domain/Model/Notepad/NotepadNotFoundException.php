<?php

namespace Notepad\Domain\Model\Notepad;

use Throwable;

class NotepadNotFoundException extends \Exception
{
    protected $code = 1;
    protected $errorMessage = "Notepad %s not found";

    public function __construct($notepadId, Throwable $previous = null)
    {
        parent::__construct(sprintf($this->errorMessage, $notepadId), $this->code, $previous);
    }
}