<?php

namespace Notepad\Domain\Model\User;

interface UserQueryRepository{
    public function getNumberNotes(UserId $userId);
    public function getNotesFromUser(UserId $userId);
}