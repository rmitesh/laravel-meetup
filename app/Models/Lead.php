<?php

namespace App\Models;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'full_name', 'email', 'phone_number', 'property_type', 'location', 'budget', 'bedrooms', 'bathrooms',
        'additional_requirements',
    ];

    public static function getPropertyType(): array
    {
        return [
            'House',
            'Apartment',
            'Condo',
            'Townhouse',
            'Villa',
            'Land',
            'Commercial',
            'Industrial',
            'Farm',
            'Vacation Rental',
        ];
    }

    /* Relationships */

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
