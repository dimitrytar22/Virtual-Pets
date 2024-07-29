<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    use HasFactory;


    public function name() : BelongsTo{
        return $this->belongsTo(PetName::class);
    }
    public function image() : BelongsTo{
        return $this->belongsTo(PetImage::class);
    }
    public function hunger() : BelongsTo{
        return $this->belongsTo(PetHunger::class);
    }
}
