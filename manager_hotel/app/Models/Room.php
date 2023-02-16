<?php

namespace App\Models;

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
        'max_person',
        'size',
        'view',
        'number_bed',
        'rent_per_night',
        'images',
        'description',
    ];

    public function typeRoom()
    {
        return $this->belongsTo(TypeRoom::class);
    }
}
