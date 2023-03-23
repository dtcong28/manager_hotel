<?php

namespace App\Models;

use App\Models\Enums\RoomStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Room extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $table = 'rooms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type_room_id',
        'status',
        'number_people',
        'size',
        'view',
        'number_bed',
        'rent_per_night',
        'description',
        'status_label',
        'time_check_in',
        'time_check_out',
    ];

    protected $appends = [
        'status_label',
    ];

    protected $casts = [
        'status' => RoomStatusEnum::class,
    ];

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->status?->label()
        );
    }

    public function typeRoom()
    {
        return $this->belongsTo(TypeRoom::class);
    }

    public function bookingRoom() {
        return $this->hasMany(BookingRoom::class);
    }
}
