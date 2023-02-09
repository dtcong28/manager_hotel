<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

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
        'note',
        'max_person',
        'size',
        'view',
        'number_bed',
        'rent_per_night',
        'img1',
        'img2',
        'img3',
    ];

    public function typeRoom()
    {
        return $this->belongsTo(TypeRoom::class);
    }
}
