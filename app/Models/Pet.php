<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function name(): BelongsTo
    {
        return $this->belongsTo(PetName::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(PetImage::class);
    }

    public function hunger(): BelongsTo
    {
        return $this->belongsTo(PetHunger::class);
    }

    public function rarity(): BelongsTo
    {
        return $this->belongsTo(PetRarity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function __toString()
    {
        return $this->name->title . ' ' . $this->rarity->title . ' ' . $this->strength . ' ';
    }
}
