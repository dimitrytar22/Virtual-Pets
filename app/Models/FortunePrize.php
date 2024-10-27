<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FortunePrize extends Model
{
    use HasFactory;
    protected $table = 'fortune_prizes';
    protected $guarded = [];

    public function item() : BelongsTo{
        return $this->belongsTo(Item::class, 'related_item');
    }
}
