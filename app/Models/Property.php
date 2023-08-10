<?php

namespace App\Models;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'price', 'bedrooms', 'bathrooms', 'description',
    ];

    public function leads(): BelongsToMany
    {
        return $this->belongsToMany(Lead::class);
    }

    // public function lead()
    // {
    //     return $this->belongsTo(Lead::class);
    // }

}
