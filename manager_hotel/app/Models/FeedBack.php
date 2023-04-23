<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'star_rate'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
