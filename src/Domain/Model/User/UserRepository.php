<?php

namespace Notepad\Domain\Model\User;

interface UserRepository{
    public function save(User $user): void;
    public function get(string $userId): ?User;
}