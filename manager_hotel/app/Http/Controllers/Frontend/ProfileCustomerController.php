<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\ProfileUpdateRequest;
use App\Repositories\Eloquent\BookingFoodRepository;
use App\Repositories\Eloquent\BookingRepository;
use App\Repositories\Eloquent\BookingRoomRepository;
use App\Repositories\Eloquent\CustomerRepository;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileCustomerController extends FrontendController
{
    protected $customerRepository;
    protected $bookingRepository;
    protected $bookingRoomRepository;
    protected $bookingFoodRepository;

    public function __construct()
    {
        parent::__construct();
        $this->customerRepository = app(CustomerRepository::class);
        $this->bookingRepository = app(BookingRepository::class);
        $this->bookingRoomRepository = app(BookingRoomRepository::class);
        $this->bookingFoodRepository = app(BookingFoodRepository::class);
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $customer = $this->customerRepository->find($request->user('web')->id);
        $booking = $this->bookingRepository->where('customer_id',$customer->id)->with(['bookingRoom.room','bookingFood.food'])->get();

        return Inertia::render('Web/Profile/Edit', [
            'mustVerifyEmail' => $request->user('web') instanceof MustVerifyEmail,
            'status' => session('status'),
            'booking' => $booking,
            'customer' => $customer,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user('web')->fill($request->validated());

        if ($request->user('web')->isDirty('email')) {
            $request->user('web')->email_verified_at = null;
        }

        $request->user('web')->save();

        return Redirect::route('web.profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user('web');

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
