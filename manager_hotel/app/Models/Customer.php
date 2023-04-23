<?php

namespace App\Models;

use App\Models\Enums\GenderEnum;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Customer extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;
    use HasFactory, Billable, SoftDeletes;
    protected $guard = 'web';

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
        'remember_token',
    ];

    protected $appends = [
        'gender_label',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
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

    public function feedback()
    {
        return $this->hasMany(FeedBack::class);
    }
}
