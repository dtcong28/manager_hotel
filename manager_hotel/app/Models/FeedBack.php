<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Enums\StatusEnum;

class FeedBack extends Model
{
    use HasFactory,SoftDeletes;

    public $table = 'feedback';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'subject',
        'content',
        'star_rate',
        'status',
        'status_label',
    ];

    protected $appends = [
        'status_label',
    ];

    protected $casts = [
        'status' => StatusEnum::class,
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
