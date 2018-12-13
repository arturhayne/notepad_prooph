<?php

namespace Notepad\Application\Service;


class RetrieveNotepadQuery
{
    /** @var string */
    protected $id;

    /**
     * RetrieveNotepadQuery constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }
}