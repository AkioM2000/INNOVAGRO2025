<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Document $document)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->hasAnyRole(['admin', 'manager', 'user']);
    }

    public function update(User $user, Document $document)
    {
        return $user->id === $document->user_id || $user->hasAnyRole(['admin', 'manager']);
    }

    public function delete(User $user, Document $document)
    {
        return $user->hasAnyRole(['admin', 'manager']);
    }
}
