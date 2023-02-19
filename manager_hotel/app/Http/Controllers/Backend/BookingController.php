<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Booking\BookingRequest;
use App\Repositories\Eloquent\BookingRepository;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\RoomRepository;
use App\Services\BookingService;
use App\Services\CustomerService;
use App\Services\RoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BookingController extends BackendController
{
    protected $bookingRepository;
    protected $bookingService;
    protected $customerRepository;
    protected $customerService;
    protected $roomRepository;
    protected $roomService;

    public function __construct(BookingRepository $bookingRepository, BookingService $bookingService, CustomerRepository $customerRepository, CustomerService $customerService, RoomRepository $roomRepository, RoomService $roomService)
    {
        parent::__construct();
        $this->bookingRepository = $bookingRepository;
        $this->customerRepository = $customerRepository;
        $this->roomRepository = $roomRepository;
        $this->bookingService = $bookingService;
        $this->customerService = $customerService;
        $this->roomService = $roomService;
    }

    public function index()
    {
    }

    public function create()
    {
        $params = request()->all();
        $customers = $this->customerService->index($params);

        foreach (\App\Models\Enums\TypeBookingEnum::cases() as $key => $data) {
            $typeBooking[$key] = [
                'value' => $data->value,
                'name' => $data->label(),
            ];
        }

        return Inertia::render('Admin/Booking/Create', [
            'customers' => $customers->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                ];
            }),
            'typeBooking' => $typeBooking,
        ]);
    }

    public function filterRoom(BookingRequest $request)
    {
        $data = $request->all();

        $params['number_people_lteq'] = $data['number_people'];
        $params['status_eq'] = \App\Models\Enums\RoomStatusEnum::VACANT->value;

        $data["name"] = $data["name"]["id"];
        $data["type_booking"] = $data["type_booking"]["value"];
        $data["time_check_in"] = $data["range"]["start"];
        $data["time_check_out"] = $data["range"]["end"];
        unset($data["range"]);

        $request->session()->put('booking', $data);

        $record = $this->roomService->index($params);

        return Inertia::render('Admin/Booking/RoomAvailable', [
            'rooms' => $record->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                    'type_room_id' => $value->type_room_id,
                    'status' => $value->status,
                    'note' => $value->note,
                    'number_people' => $value->number_people,
                    'size' => $value->size,
                    'view' => $value->view,
                    'number_bed' => $value->number_bed,
                    'rent_per_night' => $value->rent_per_night,
                    'image' => ($value->getMedia('images'))[0]->getUrl(),
                ];
            }),
            ''
        ]);
    }

    public function store(BookingRequest $request)
    {

    }

    public function edit($id)
    {

    }

    public function update(BookingRequest $request, $id)
    {

    }

    public function destroy($id)
    {

    }

}
