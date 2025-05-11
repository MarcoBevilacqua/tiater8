<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShowEvent extends Model
{
    use HasFactory;

    const AVAILABLE_TIMES = [
        "18:00",
        "18:30",
        "19:00",
        "19:30",
        "20:00",
        "20:30",
        "21:00",
        "21:30",
    ];
    protected $fillable = [
        'show_id',
        'show_date'
    ];

    protected $dates = ['show_date'];

    /**
     * @return BelongsTo
     */
    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class, 'show_id');
    }
}
