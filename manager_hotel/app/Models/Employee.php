<?php

namespace App\Models;

use App\Models\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Employee extends Model
{
    use HasFactory;

    public $table = 'employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'gender',
    ];

    protected $appends = [
        'gender_label',
    ];

    protected $hidden = [
        'password',
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
}
