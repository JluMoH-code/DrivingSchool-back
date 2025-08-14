<?php

namespace App\Providers;

use App\Enums\SlotStatus;
use App\Http\Requests\SlotsListRequest;
use App\Models\Slot;
use Carbon\Carbon;

class SlotService
{


    public function list(SlotsListRequest $request)
    {
        $query = Slot::select();

        $query->where('start_time', '>=', Carbon::now());
        $query->whereNot('status', SlotStatus::BLOCKED);

        if ($request->filled('available_only') && $request->available_only) {
            $query->where('status', SlotStatus::AVAILABLE);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('start_time', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('start_time', '<=', $request->to_date);
        }

        if ($request->filled('from_time')) {
            $query->whereTime('start_time', '>=', $request->from_time);
        }

        if ($request->filled('to_time')) {
            $query->whereTime('start_time', '<=', $request->to_time);
        }

        if ($request->filled('instructor_ids')) {
            $query->whereIn('instructor_id', $request->instructor_ids);
        }

        if ($request->filled('car_ids')) {
            $query->whereIn('car_id', $request->car_ids);
        }

        if ($request->filled('transmissions')) {
            $query->whereHas('car', function ($q) use ($request) {
                $q->whereIn('transmission', $request->transmissions);
            });
        }

        $query->orderBy('start_time');

        return $query->get();
    }
}
