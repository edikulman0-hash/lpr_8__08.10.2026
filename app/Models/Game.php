<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['developer_id', 'title', 'description', 'release_year', 'price', 'rating', 'is_multiplayer'];

    protected function casts(): array
    {
        return [
            'price'          => 'decimal:2',
            'rating'         => 'decimal:1',
            'is_multiplayer' => 'boolean',
        ];
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }
}
