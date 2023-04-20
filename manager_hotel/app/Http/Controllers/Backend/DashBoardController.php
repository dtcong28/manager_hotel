<?php

namespace App\Http\Controllers\Backend;

use App\Models\Enums\BookingStatusEnum;
use App\Models\Enums\PaymentStatusEnum;
use App\Repositories\Eloquent\BookingRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashBoardController extends BackendController
{
    protected $bookingRepository;
    public function __construct()
    {
        parent::__construct();
        $this->bookingRepository = app(BookingRepository::class);
    }

    public function index(Request $request)
    {
        $record = $this->bookingRepository->getSearchBooking($request->search);
        return Inertia::render('Admin/DashBoard/Index',[
            'totalCheckIn' => $this->bookingRepository->getListCheckIn()->count(),
            'totalCheckOut' => $this->bookingRepository->getListCheckOut()->count(),
            'totalEA' => $this->bookingRepository->getListEA()->count(),
            'totalMoney' => $this->bookingRepository->getTotalMoney(),
            'bookings' => $record,
            'status' => $record->map(function ($value) {
                return [
                    'booking_class' => BookingStatusEnum::statusBg($value->status_booking->value),
                    'payment_class' => PaymentStatusEnum::statusBg($value->status_payment->value),
                ];
            }),
        ]);
    }
}
