<?php

namespace App\Providers;

use App\Enums\SlotStatus;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SlotService
{


    public function list(Request $request)
    {
        $query = Slot::select();

        $query->where('start_time', '>=', Carbon::now());
        $query->whereNot('status', SlotStatus::BLOCKED);
        $query->orderBy('start_time');

        return $query->get();
    }
}
