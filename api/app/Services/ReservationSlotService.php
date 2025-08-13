<?php

namespace App\Services;

use App\Enums\DrivingSessionStatus;
use App\Enums\SlotStatus;
use App\Exceptions\SlotNotAvailableException;
use App\Exceptions\SlotNotFoundException;
use App\Exceptions\SlotStartTimeHasAlreadyPastException;
use App\Exceptions\UserNotActiveException;
use App\Models\DrivingSession;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationSlotService
{
    /**
     * @throws SlotStartTimeHasAlreadyPastException
     * @throws SlotNotFoundException
     * @throws SlotNotAvailableException
     * @throws UserNotActiveException
     */
    public function reserveSlotForSelf($slotId, Request $request)
    {
        $slot = Slot::whereId($slotId)->first();
        if (!$slot) throw new SlotNotFoundException();
        if ($slot->status !== SlotStatus::AVAILABLE) throw new SlotNotAvailableException();
        if ($slot->start_time->lessThan(Carbon::now()->subHour())) throw new SlotStartTimeHasAlreadyPastException();

        $user = $request->user();
        if (!$user->is_active) throw new UserNotActiveException();

        $drivingSession = DrivingSession::create([
            'student_id' => $user->id,
            'slot_id' => $slot->id,
            'status' => DrivingSessionStatus::RESERVATION,
        ]);

        $slot->update(['status' => SlotStatus::RESERVATION]);

        return $drivingSession;
    }
}
