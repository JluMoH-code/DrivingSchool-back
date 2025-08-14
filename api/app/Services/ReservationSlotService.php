<?php

namespace App\Services;

use App\Enums\DrivingSessionStatus;
use App\Enums\SlotStatus;
use App\Enums\UserRole;
use App\Exceptions\SlotAlreadyCompletedException;
use App\Exceptions\SlotNotAvailableException;
use App\Exceptions\SlotNotFoundException;
use App\Exceptions\SlotStartTimeHasAlreadyPastException;
use App\Exceptions\UserNotActiveException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserNotStudentException;
use App\Models\DrivingSession;
use App\Models\Slot;
use App\Models\User;
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

        $drivingSession = DrivingSession::firstOrCreate([
            'student_id' => $user->id,
            'slot_id' => $slot->id,
        ]);

        $drivingSession->update([
            'status' => DrivingSessionStatus::RESERVATION,
        ]);

        $slot->update(['status' => SlotStatus::RESERVATION]);

        return $drivingSession;
    }

    /**
     * @throws SlotStartTimeHasAlreadyPastException
     * @throws SlotAlreadyCompletedException
     * @throws SlotNotFoundException
     * @throws UserNotActiveException
     */
    public function cancelReservation($slotId, Request $request)
    {
        $slot = Slot::whereId($slotId)->first();
        if (!$slot) throw new SlotNotFoundException();
        if ($slot->status === SlotStatus::COMPLETED) throw new SlotAlreadyCompletedException();
        if ($slot->start_time->lessThan(Carbon::now()->subHour())) throw new SlotStartTimeHasAlreadyPastException();

        $user = $request->user();
        if (!$user->is_active) throw new UserNotActiveException();

        $slot->drivingSession()->update(['status' => DrivingSessionStatus::CANCELED]);
        $slot->update(['status' => SlotStatus::AVAILABLE]);

        return $slot;
    }

    /**
     * @throws SlotNotFoundException
     * @throws UserNotFoundException
     * @throws SlotNotAvailableException
     * @throws UserNotActiveException
     * @throws UserNotStudentException
     */
    public function reserveSlotForUser($slotId, $userId)
    {
        $slot = Slot::whereId($slotId)->first();
        if (!$slot) throw new SlotNotFoundException();
        if ($slot->status !== SlotStatus::AVAILABLE) throw new SlotNotAvailableException();

        $user = User::whereId($userId)->first();
        if (!$user) throw new UserNotFoundException();
        if (!$user->is_active) throw new UserNotActiveException();
        if ($user->role !== UserRole::STUDENT) throw new UserNotStudentException();

        $drivingSession = DrivingSession::firstOrCreate([
            'student_id' => $user->id,
            'slot_id' => $slot->id,
        ]);

        $drivingSession->update([
            'status' => DrivingSessionStatus::RESERVATION,
        ]);

        $slot->update(['status' => SlotStatus::RESERVATION]);

        return $drivingSession;
    }

    /**
     * @throws UserNotFoundException
     * @throws SlotAlreadyCompletedException
     * @throws SlotNotFoundException
     * @throws UserNotActiveException
     * @throws UserNotStudentException
     */
    public function cancelReservationForUser($slotId, $userId)
    {
        $slot = Slot::whereId($slotId)->first();
        if (!$slot) throw new SlotNotFoundException();
        if ($slot->status === SlotStatus::COMPLETED) throw new SlotAlreadyCompletedException();

        $user = User::whereId($userId)->first();
        if (!$user) throw new UserNotFoundException();
        if (!$user->is_active) throw new UserNotActiveException();

        $slot->drivingSession()->update(['status' => DrivingSessionStatus::CANCELED]);
        $slot->update(['status' => SlotStatus::AVAILABLE]);

        return $slot;
    }
}
