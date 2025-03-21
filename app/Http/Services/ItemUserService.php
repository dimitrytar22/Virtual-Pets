<?php

namespace App\Http\Services;

use App\Models\Item;
use App\Models\ItemUser;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ItemUserService
{
    public function addItem(User $user, Item $item, int $amount)
    {
        try {
            $itemUser = ItemUser::query()->where('item_id', $item->id)->where('user_id', $user->id)->get();
            if (!$itemUser->isEmpty()) {
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
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return false;
        }
    }

    public function reduceItem(ItemUser $itemUser, int $amount)
    {
        try {
            $itemUser->amount = $itemUser->amount - $amount;
            if ($itemUser->amount <= 0) {
                $itemUser->delete();
                return true;
            }
            $itemUser->save();
            return true;
        } catch (\Exception $exception) {

            return false;
        }
    }


    public function setItem(User $user, Item $item, int $amount)
    {
        try {
            $itemUser = ItemUser::query()->where('item_id', $item->id)->where('user_id', $user->id)->get();
            if (!$itemUser->isEmpty()) {
                $itemUser = $itemUser->first();
                if ($amount <= 0) {
                    $itemUser->delete();
                    return true;
                }
                $itemUser->save();
                return true;
            }

            return false;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getItems(User $user)
    {
        return ItemUser::query()->where('user_id', $user->id)->get();
    }
}
