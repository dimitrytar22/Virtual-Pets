<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    static public function findByUser($id)
    {
        $onlineUser = self::query()->where('user_id', $id)->get();
        if ($onlineUser->isEmpty()) {
            return false;
        }
        return $onlineUser->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(UserStatus::class);
    }
}
