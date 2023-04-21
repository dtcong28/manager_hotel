<?php

namespace App\Models;

use App\Models\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;

class Customer extends Model
{
    use HasFactory,Billable,SoftDeletes;

    public $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'gender',
        'phone',
        'email',
        'identity_card',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $appends = [
        'gender_label',
    ];

    protected $casts = [
        'gender' => GenderEnum::class,
    ];

    protected function genderLabel(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->gender?->label()
        );
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
}
