<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Enums\DiscountStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory,SoftDeletes;

    public $table = 'discount';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'percent',
        'status',
        'expiration_date',
        'status_label',
    ];

    protected $appends = [
        'status_label',
    ];

    protected $casts = [
        'status' => DiscountStatusEnum::class,
        'expiration_date' => 'datetime:Y-m-d',
    ];

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->status?->label()
        );
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
