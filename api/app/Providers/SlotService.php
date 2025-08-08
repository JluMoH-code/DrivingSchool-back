<?php

namespace App\Providers;

use App\Models\Slot;
use Illuminate\Http\Request;

class SlotService
{


    public function list(Request $request)
    {
        $slots = Slot::all();
        return $slots;
    }
}
