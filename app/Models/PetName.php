<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetName extends Model
{
    protected $fillable = [
        'title',
        'category_id'
    ];
    use HasFactory;

    public function category() {
        return $this->belongsTo(PetCategory::class);
    }
}
