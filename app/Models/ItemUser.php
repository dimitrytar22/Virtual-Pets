<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ItemUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    static public function addItem(User $user, Item $item, int $amount){
        try {
            $itemUser = self::query()->where('item_id', $item->id)->where('user_id', $user->id)->get();
            if(!$itemUser->isEmpty()){
                Log::info($itemUser);
                $itemUser = $itemUser->first();
                $itemUser->amount = $itemUser->amount + $amount;
                $itemUser->save();
                Log::info($itemUser);
                return true;
            }

            $itemUser = ItemUser::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'amount' => $amount
            ]);
            return true;
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return false;
        }
    }

    static public function reduceItem(ItemUser $itemUser, int $amount){
        try {
                $itemUser = $itemUser;
                $itemUser->amount = $itemUser->amount - $amount;
                if($itemUser->amount <= 0){
                    $itemUser->delete();
                    return true;
                }
                $itemUser->save();
                return true;

            return false;
        }catch (\Exception $exception){

            return false;
        }
    }


    static public function setItem(User $user, Item $item, int $amount){
        try {
            $itemUser = self::query()->where('item_id', $item->id)->where('user_id', $user->id)->get();
            if(!$itemUser->isEmpty()){
                $itemUser = $itemUser->first();
                if($amount <= 0){
                    $itemUser->delete();
                    return true;
                }
                $itemUser->save();
                return true;
            }

            return false;
        }catch (\Exception $exception){
            return false;
        }
    }

    static public function getItems(User $user){
        return ItemUser::query()->where('user_id', $user->id)->get();
    }
}
