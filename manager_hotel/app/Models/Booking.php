<?php

namespace App\Models;

use App\Models\Enums\BookingStatusEnum;
use App\Models\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory,SoftDeletes;

    public $table = 'booking';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'time_check_in',
        'time_check_out',
        'type_booking',
        'feedback',
        'number_rooms',
        'payment_date',
        'method_payment',
        'status_payment',
        'status_booking',
        'total_money',
        'reason_cancel',
        'note_booking_food',
        'note_booking_room',
        'status_payment_label',
        'status_booking_label',
    ];

    protected $appends = [
        'status_payment_label',
        'status_booking_label',
    ];

    protected $casts = [
        'status_payment' => PaymentStatusEnum::class,
        'status_booking' => BookingStatusEnum::class,
        'time_check_in' => 'datetime:Y-m-d',
        'time_check_out' => 'datetime:Y-m-d',
    ];

    protected function statusPaymentLabel(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->status_payment?->label()
        );
    }

    protected function statusBookingLabel(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->status_booking?->label()
        );
    }

    public function bookingRoom()
    {
        return $this->hasMany(BookingRoom::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function bookingFood()
    {
        return $this->hasMany(BookingFood::class);
    }
}
