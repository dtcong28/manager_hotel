<?php

namespace App\Http\Controllers\Backend;

use App\Models\Enums\BookingStatusEnum;
use App\Models\Enums\PaymentStatusEnum;
use App\Repositories\Eloquent\BookingRepository;
use Carbon\Carbon;
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
//        $now = Carbon::now();
//        dd($this->bookingRepository->getListBookingByWeek(BookingStatusEnum::EXPECTED_ARRIVAL->value));
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

    public function report(Request $request) {
        $params = $request->input('time')['value'];
        $data = [
            'totalBookingCheckIn' => 0,
            'totalBookingCheckOut' => 0,
            'totalBookingEA' => 0,
            'totalMoney' => 0,
        ];
        if($params == 0) {
            $data = [
                'totalBookingCheckIn' => $this->bookingRepository->getListCheckIn()->count(),
                'totalBookingCheckOut' => $this->bookingRepository->getListCheckOut()->count(),
                'totalBookingEA' => $this->bookingRepository->getListEA()->count(),
                'totalMoney' => $this->bookingRepository->getTotalMoney(),
            ];
        }
        if($params == 1) {
            $data = [
                'totalBookingCheckIn' => $this->bookingRepository->getListBookingByDay(BookingStatusEnum::CHECK_IN->value)->count(),
                'totalBookingCheckOut' => $this->bookingRepository->getListBookingByDay(BookingStatusEnum::CHECK_OUT->value)->count(),
                'totalBookingEA' => $this->bookingRepository->getListBookingByDay(BookingStatusEnum::EXPECTED_ARRIVAL->value)->count(),
                'totalMoney' => $this->bookingRepository->getTotalMoneyByDay(),
            ];
        }
        if($params == 2) {
            $data = [
                'totalBookingCheckIn' => $this->bookingRepository->getListBookingByWeek(BookingStatusEnum::CHECK_IN->value)->count(),
                'totalBookingCheckOut' => $this->bookingRepository->getListBookingByWeek(BookingStatusEnum::CHECK_OUT->value)->count(),
                'totalBookingEA' => $this->bookingRepository->getListBookingByWeek(BookingStatusEnum::EXPECTED_ARRIVAL->value)->count(),
                'totalMoney' => $this->bookingRepository->getTotalMoneyByWeek(),
            ];
        }
        if($params == 3) {
            $data = [
                'totalBookingCheckIn' => $this->bookingRepository->getListBookingByMonth(BookingStatusEnum::CHECK_IN->value)->count(),
                'totalBookingCheckOut' => $this->bookingRepository->getListBookingByMonth(BookingStatusEnum::CHECK_OUT->value)->count(),
                'totalBookingEA' => $this->bookingRepository->getListBookingByMonth(BookingStatusEnum::EXPECTED_ARRIVAL->value)->count(),
                'totalMoney' => $this->bookingRepository->getTotalMoneyByMonth(),
            ];
        }
        if($params == 4) {
            $data = [
                'totalBookingCheckIn' => $this->bookingRepository->getListBookingByYear(BookingStatusEnum::CHECK_IN->value)->count(),
                'totalBookingCheckOut' => $this->bookingRepository->getListBookingByYear(BookingStatusEnum::CHECK_OUT->value)->count(),
                'totalBookingEA' => $this->bookingRepository->getListBookingByYear(BookingStatusEnum::EXPECTED_ARRIVAL->value)->count(),
                'totalMoney' => $this->bookingRepository->getTotalMoneyByYear(),
            ];
        }
        return response()->json(['report' => $data]);
    }
}
