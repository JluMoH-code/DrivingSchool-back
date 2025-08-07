<?php

namespace App\Services;

use Illuminate\Http\Request;

class ProfileService
{
    public function profile(Request $request)
    {
        return $request->user();
    }
}
