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
        'active',
        'active_label',
    ];

    protected $appends = [
        'active_label',
    ];

    protected $casts = [
        'active' => StatusEnum::class,
    ];

    protected function activeLabel(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->active?->label()
        );
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
