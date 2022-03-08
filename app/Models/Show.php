<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Show extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'places', 'full_price', 'image', 'half_price', 'url'];
    
    /**
     * has-many relationship with events table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(ShowEvent::class);
    }
}
