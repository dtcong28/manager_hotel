<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

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
    ];

    public function bookingRoom()
    {
        return $this->hasMany(BookingRoom::class);
    }
}