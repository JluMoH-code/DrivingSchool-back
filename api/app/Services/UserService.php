<?php

namespace App\Services;

use App\Http\Requests\UsersListRequest;
use App\Models\User;

class UserService
{
    public function list(UsersListRequest $request)
    {
        $query = User::select();

        if ($request->filled('available_only') && $request->available_only) {
            $query->where('is_active', true);
        }

        if ($request->filled('roles')) {
            $query->whereIn('role', $request->roles);
        }

        $query->orderBy('pernumber');

        return $query->get();
    }
}
