<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'status', 'priority', 'due_at', 'created_by',
    ];

    protected $casts = [
        'due_at' => 'timestamp',
        'status' => 'bool',
    ];

    public static function getPriority(): array
    {
        return [
            'Very High',
            'High',
            'Medium',
            'Low',
            'Very Low',
        ];
    }

    /* Relationships */    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
