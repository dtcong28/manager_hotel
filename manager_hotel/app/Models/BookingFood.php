<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingFood extends Model
{
    use HasFactory;

    public $table = 'booking_food';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'food_id',
        'price',
        'amount',
    ];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
