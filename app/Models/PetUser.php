<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'user_id'
    ];

    public function pet() : BelongsTo{
        return $this->belongsTo(Pet::class);
    }
}
