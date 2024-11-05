<?php

namespace App\Http\Telegram;

use App\Models\FortunePrize;
use App\Models\Item;
use App\Models\ItemUser;
use App\Models\Pet;
use App\Models\PetImage;
use App\Models\PetName;
use App\Models\PetRarity;
use App\Models\RegistrationApplication;
use App\Models\Role;
use App\Models\User;
use DefStudio\Telegraph\DTO\Chat;
use DefStudio\Telegraph\DTO\Message;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;

class MainHook extends WebhookHandler
{
    public function start()
    {
        $chatId = $this->message->chat()->id();
        $user = User::query()->where('chat_id', $chatId)->get();
        if ($user->isEmpty()) {
            $user = User::create([
                'chat_id' => $chatId,
                'name' => $this->message->chat()->title(),
            ]);
            ItemUser::addItem($user, Item::query()->where('title', 'Lottery Ticket')->get()->first(), 3);
            ItemUser::addItem($user, Item::query()->where('title', 'Apple')->get()->first(), 10);
            Pet::createRandomPet($chatId);
            Pet::createRandomPet($chatId);
            Pet::createRandomPet($chatId);
            $this->chat->message('You have got start bonus: Apples *10x* Lottery Ticket *3x* Random Pets *3x*');
        }
        User::firstOrCreate([
            'chat_id' => $chatId,
        ], [
            'chat_id' => $chatId,
            'name' => $this->message->chat()->title(),
        ]);
        $this->menu();
    }

    public function menu()
    {
        if ($this->message == null) {
            $chatId = $this->callbackQuery->from()->id();
        } else {
            $chatId = $this->message->chat()->id();
        }

        $this->chat->message("👋 Hello!" . "\n\n⚔️ Evolve pets, fight with others and try your luck in the wheel of fortune!\n\n📋 Menu")->keyboard(
            Keyboard::make()->buttons([
                Button::make('🐾 My pets')->action('myPets'),
                Button::make('🆓 Get Free Pets')->action('freePets'),
                Button::make('🏪 Shop')->action('shop'),
                Button::make('🎒 Inventory')->action('inventory'),
                Button::make('🎰 Wheel of Fortune')->action('fortuneWheelMenu'),
            ])
        )->send();
        $this->chat->deleteMessage($this->messageId)->send();
    }

    public function inventory()
    {
        $chatId = $this->callbackQuery->from()->id();
        $user = User::query()->where('chat_id', $chatId)->first();
        $inventory = $user->inventory;

        $buttonsArray = [];
        $buttonsArray[] = Button::make('🔙 Back to menu')->action('menu');

        $itemsText = "";
        if ($inventory->isEmpty()) {
            $itemsText = 'Inventory is empty';
            $this->chat->message($itemsText)->keyboard(Keyboard::make()->buttons($buttonsArray))->send();
            $this->chat->deleteMessage($this->messageId)->send();
            $this->reply('');
            return;
        }

        foreach ($inventory as $itemUser) {
            $itemsText .= "*{$itemUser->item->title}* *{$itemUser->amount}x*
";
        }
        $this->chat->message($itemsText)->keyboard(Keyboard::make()->buttons($buttonsArray))->send();
        $this->chat->deleteMessage($this->messageId)->send();
        $this->reply('');
    }

    public function myPets()
    {

        $chatId = $this->callbackQuery->from()->id();
        $user = User::query()->where('chat_id', $chatId)->first();
        $userPets = $user->pets()->paginate(100);

        $buttonsArray = [];
        foreach ($userPets as $userPet) {
            $buttonsArray[] = Button::make('Pet' . ' - ' . $userPet->name->title)->action('pet')->param('id', $userPet->id);
        }
        $buttonsArray[] = Button::make('🔙 Back to menu')->action('menu');

        $this->chat->message('Your pets')->photo('images/myPets.jpg')->keyboard(
            Keyboard::make()->buttons($buttonsArray)->chunk(2)
        )->send();

        $this->chat->deleteMessage($this->messageId)->send();
        $this->reply('');
    }

    public function pet($id = NULL)
    {
        if ($id != NULL) {
            $pet = Pet::find($id);
        } else {
            $pet = Pet::find($this->data->get('id'));
        }
        $buttonsArray = [];
        $buttonsArray[] = Button::make('🍽️ Feed')->action('chooseFood')->param('id', $pet->id);
        $buttonsArray[] = Button::make('🎯 Train')->action('train')->param('id', $pet->id);
        $buttonsArray[] = Button::make('☠️ Put to sleep')->action('confirmPutToSleep')->param('id', $pet->id);
        $buttonsArray[] = Button::make('🔙 Back to pets')->action('myPets');
        $this->chat->message("
Pet №: *$pet->id* 🐾 \n
Rarity: * {$pet->rarity->title} * \n
Name: * {$pet->name->title} * \n
Experience: * {$pet->experience} *\n
Strength : *{$pet->strength}*\n
Hunger: * {$pet->hunger_index}/10*\n"

        )->photo("images/" . $pet->image->title)->keyboard(
            Keyboard::make()->buttons($buttonsArray)
        )->send();
        $this->chat->deleteMessage($this->messageId)->send();
        $this->reply("");
    }

    public function confirmPutToSleep()
    {
        $buttonsArray = [];
        $buttonsArray[] = Button::make('✅ Yes')->action('putToSleep')->param('id', $this->data->get('id'));
        $buttonsArray[] = Button::make('❌ Cancel')->action('pet')->param('id', $this->data->get('id'));

        $this->chat->message("Are you sure you want to put your pet to sleep?
The action cannot be undone")->keyboard(Keyboard::make()->buttons($buttonsArray)->chunk(2))->send();
        $this->chat->deleteMessage($this->messageId)->send();
        $this->reply("");
    }
    public function putToSleep()
    {
        $pet = Pet::find($this->data->get('id'));
        $pet->delete();


        $this->myPets();
        $this->chat->deleteMessage($this->messageId)->send();
    }
    public function chooseFood()
    {
        $chatId = $this->callbackQuery->from()->id();
        $user = User::query()->where('chat_id', $chatId)->first();
        $foodItems = [];

        foreach ($user->inventory as $item) {
            if(strtolower($item->item->category->title) == 'food')
                $foodItems[] = $item;
        }

        $buttonsArray = [];
        foreach ($foodItems as $foodItem) {
            $buttonsArray[] = Button::make($foodItem->item->title . " " . $foodItem->amount . "x")->action('feed')->param('itemId', $foodItem->id)->param('petId', $this->data->get('id'));
        }

        $text = "Choose food";
        if($foodItems == null)
            $text .= "\n*You have no food!*";
        $buttonsArray[] = Button::make("🔙 Back to pet")->action('pet')->param('id', $this->data->get('id'));
        $this->chat->message($text)->keyboard(Keyboard::make()->buttons($buttonsArray))->send();
        $this->chat->deleteMessage($this->messageId)->send();


    }
    public function feed()
    {
        $pet = Pet::find($this->data->get('petId'));

        try {
            $expPointsForFood = 10;

            if ($pet->hunger_index >= 10) {
                $this->reply("The pet is full!");

                return;
            }else if ($pet->hunger_index == 9) {
                ItemUser::reduceItem(ItemUser::find($this->data->get('itemId')), 1);
                $pet->experience += $expPointsForFood;
                $pet->hunger_index += 1;
            } else {
                ItemUser::reduceItem(ItemUser::find($this->data->get('itemId')), 1);
                $pet->experience += $expPointsForFood;
                $pet->hunger_index += 2;
            }

            $pet->save();

            $this->reply("You fed " . $pet->name->title . " (+{$expPointsForFood} experience points)");


        } catch (\Throwable $th) {
            $this->reply('Not enough items!');
        } finally {
            $this->pet($this->data->get('petId'));
            $this->chat->deleteMessage($this->messageId)->send();
        }

    }


    public function train($id = NULL)
    {

        $strengthPointsForTrain = rand(1, 15);
        $expPointsForTrain = rand(1, 10);
        if ($id != NULL) {
            $pet = Pet::find($id);
        } else {
            $pet = Pet::find($this->data->get('id'));
        }

        $pet->strength += $strengthPointsForTrain;
        $pet->experience += $expPointsForTrain;
        $pet->save();
        $this->reply("You have trained your pet (+ {$strengthPointsForTrain} strength)");
        $this->pet($pet->id);
        $this->chat->deleteMessage($this->messageId)->send();
    }

    public function freePets()
    {
        $userId = $this->callbackQuery->from()->id();
        $freePetsAmount = 10;

        try {
            for ($i = 0; $i < $freePetsAmount; $i++) {
                Pet::createRandomPet($userId);
            }
            $this->reply('Pets added successfully!');
        } catch (\Exception $exception) {
            $this->reply('Error adding pets!');
        } finally {
            return;
        }

    }

    public function fortuneWheelMenu()
    {

        $user = User::query()->where('chat_id', $this->callbackQuery->from()->id())->first();
        $tickets = $user->tickets->first();
        if ($tickets == null)
            $tickets = 0;
        else
            $tickets = $tickets->amount;
        $buttonsArray = [];
        $buttonsArray[] = Button::make('🎰 Spin (1 🎟️)')->action('fortuneWheelSpin')->param('id', $this->callbackQuery->from()->id());
        $buttonsArray[] = Button::make('📜 Rules')->action('fortuneWheelRules');
        $buttonsArray[] = Button::make('🔙 Back to menu')->action('menu');


        $this->chat->message("🍀 Try your luck!
Spin the wheel and get random prizes.
Every spin is a chance for a unique reward!

*{$tickets}x 🎟 available*")->keyboard(Keyboard::make()->buttons($buttonsArray))->send();
        $this->chat->deleteMessage($this->messageId)->send();

        $this->reply('');
    }


    public function fortuneWheelSpin()
    {
        $chatId = $this->callbackQuery->from()->id();
        $user = User::query()->where('chat_id', $chatId)->first();
        $inventory = $user->inventory;
        $itemTickets = 0;
        $buttonsArray = [];
        if (!$inventory->isEmpty()) {
            foreach ($inventory as $itemUser) {
                if ($itemUser->item->title == 'Lottery ticket' && $itemUser->amount > 0) {
                    $itemTickets = $itemUser;
                }
            }
        }
        if (gettype($itemTickets) == 'integer' && $itemTickets <= 0) {
            $this->reply("Not enough tickets");
            return;
        }


        $rewards = FortunePrize::with('item')->get();


        $wheel = ['🔵', '🔴', '🟢', '🟡', '🟠', '⚪', '⚫'];

        function getWheelFrame($index, $wheel)
        {

            return implode(' ', array_merge(
                array_slice($wheel, $index),
                array_slice($wheel, 0, $index)
            ));
        }

        $message = $this->chat->message(getWheelFrame(0, $wheel))->send();
        $message_id = $message->telegraphMessageId();

        for ($i = 0; $i < count($wheel) * 1; $i++) {
            usleep(300000);
            $this->chat->edit($message_id)->message(getWheelFrame($i % count($wheel), $wheel))->send();
        }

        $prize = $rewards->first();
        $randomChance = rand(1, 100);

        foreach ($rewards as $reward) {
            $randomChance -= $reward->chance;
            if ($randomChance <= 0) {
                $prize = $reward;
                break;
            }
        }

        switch ($prize) {
            case $prize->related_item == null:
            {
                switch ($prize->title) {
                    case "Free Random Pet":
                    {
                        Pet::createRandomPet($chatId);
                        $this->reply("Free random pet");
                        break;
                    }
                }
                break;
            }
            case $prize->related_item != null:
            {
                ItemUser::addItem($user, $prize->item, $prize->amount);
            }

        }


        $this->chat->edit($message_id)->message("🎉 You got $prize->title *$prize->amount**x* 🎉
$prize->description")->send();

        $itemTickets->refresh();
        ItemUser::reduceItem($itemTickets, 1);
        $this->fortuneWheelMenu();
        $this->chat->deleteMessage($this->messageId)->send();
        $this->reply('');
    }

    protected function handleUnknownCommand(Stringable $text): void
    {
        $chatId = $this->message->chat()->id();
        $user = User::query()->where('chat_id', $chatId)->first();


        switch (strtolower($text)) {
            case '/admin_register':
            {
                if($user->password != null)
                {
                    $this->reply('You are already registered!');
                    break;
                }
                if(!RegistrationApplication::query()->where('user_id', $user->id)->get()->isEmpty()){
                    $user->status = null;
                    $user->save();

                    $this->reply('You have already claimed the application!');
                    break;
                }
                $this->reply('Enter password:');
                $user->status = 'entering_password';
                $user->save();

                break;
            }
            case '/admin':
            {
                if ($user->role->title != 'admin' && $user->password == null)
                    $this->reply("You have no access!");
                else {
                    $buttonsArray = [];
                    $buttonsArray[] = Button::make('Admin Panel')->action('getAdminPanel');
                    $buttonsArray[] = Button::make('🔙 Back to menu')->action('menu');
                    $this->chat->message("Welcome, " . $user->chat_id . "\nYou are " . $user->role->title)->keyboard(Keyboard::make()->buttons($buttonsArray))->send();
                }
                break;
            }
            default:
            {
                $this->reply("Unknown command!");
                break;
            }
        }


    }
    public function  getAdminPanel()
    {
        $this->chat->message(env('APP_URL'))->send();
        $this->reply('');
    }

    protected function handleChatMessage(Stringable $text): void
    {
        $chatId = $this->message->chat()->id();
        $user = User::query()->where('chat_id', $chatId)->first();


        if ($user->status === 'entering_password') {
            if(strlen($text) < 8){
                $this->reply("Password should be more than 8 characters!");
                $this->chat->deleteMessage($this->messageId)->send();
                return;
            }
            $password = md5($text);

            $data = [
                'user_id' => $user->id,
                'role_id' => Role::query()->where('title', "admin")->first()->id,
                'password' => $text,
            ];



            $user->status = null;
            $user->save();

            RegistrationApplication::create($data);
            $this->reply('Your application is on the consideration. Wait for approving!');

        } else {

        }



        $this->chat->deleteMessage($this->messageId)->send();

        $this->reply("");

    }
}
