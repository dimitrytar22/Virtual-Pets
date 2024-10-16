<?php

namespace App\Http\Telegram;

use App\Models\Pet;
use App\Models\PetImage;
use App\Models\PetName;
use App\Models\PetRarity;
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

    public function inventory(){
        $chatId = $this->callbackQuery->from()->id();
        $user = User::query()->where('chat_id', $chatId)->first();
        $inventory = $user->inventory;

        $this->chat->message()->send();
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
        if($id != NULL){
            $pet = Pet::find($id);
        }else{
            $pet = Pet::find($this->data->get('id'));
        }
        $buttonsArray = [];
        $buttonsArray[] = Button::make('🍽️ Feed')->action('feed')->param('id', $this->data->get('id'));
        $buttonsArray[] = Button::make('🎯 Train')->action('train')->param('id', $this->data->get('id'));
        $buttonsArray[] = Button::make('🔙 Back to Pets')->action('myPets');
        $this->chat->message("
Pet №: *$pet->id* 🐾 \n
Rarity: * {$pet->rarity->title} * \n
Name: * {$pet->name->title} * \n
Experience: * {$pet->experience} *\n
Strength : *{$pet->strength}*\n
Hunger: * {$pet->hunger_index}/10*\n"

        )->photo("images/".$pet->image->title)->keyboard(
            Keyboard::make()->buttons($buttonsArray)
        )->send();
        $this->chat->deleteMessage($this->messageId)->send();
        $this->reply("");
    }

    public function feed()
    {
        $pet = Pet::find($this->data->get('id'));
        try {
            $expPointsForFood = 10;

            if ($pet->hunger_index >= 10) {
                $this->reply("The pet is full!");
                return;
            } else if ($pet->hunger_index == 9) {
                $pet->experience += $expPointsForFood;
                $pet->hunger_index += 1;
            } else {
                $pet->experience += $expPointsForFood;
                $pet->hunger_index += 2;
            }

            $pet->save();
            $pet->save();
            $this->reply("You fed " . $pet->name->title . " (+{$expPointsForFood} experience points)");
            
            $this->pet($pet->id);

        } catch (\Throwable $th) {
            $this->reply('Error!');
        }
    }

    public function train($id = NULL)
    {

        $strengthPointsForTrain = rand(1,15);
        $expPointsForTrain = rand(1,10);
        if($id != NULL){
            $pet = Pet::find($id);
        }else{
            $pet = Pet::find($this->data->get('id'));
        }        

        $pet->strength +=$strengthPointsForTrain;
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

        $user = User::query()->where('chat_id', $userId)->first();

        try {
            
            $user_id = $user->id;


           for($i = 0; $i < 5; $i++){
                $rarity_id = PetRarity::all()->random()->id;
                $name_id = PetName::all()->random();
                $image_id = PetImage::where('category_id', $name_id->category->id)->get()->random()->id;
                
                $name_id = $name_id->id;

                $experience = fake()->numberBetween(0, 10000);
                $strength = fake()->numberBetween(1, 1000);
                $hunger_index = fake()->numberBetween(0, 10);

                Pet::create([
                    'rarity_id' => $rarity_id,
                    'image_id' => $image_id,
                    'name_id' => $name_id,
                    'experience' => $experience,
                    'strength' => $strength,
                    'hunger_index' => $hunger_index,
                    'user_id' => $user->id
                ]);
           }

          
            $this->reply('Pets added successfully!');
        } catch (\Throwable $th) {
            Log::info($th);
            $this->reply('Не удалось получить бесплатных питомцев!');
        }

    }   
    public function fortuneWheelMenu(){
        $buttonsArray = [];
        $buttonsArray[] = Button::make('🎰 Spin (1 🎟️)')->action('fortuneWheelSpin')->param('id', $this->callbackQuery->from()->id());
        $buttonsArray[] = Button::make('📜 Rules')->action('fortuneWheelRules');
        $buttonsArray[] = Button::make('🔙 Back to menu')->action('menu');


        $this->chat->message('🍀 Try your luck!
Spin the wheel and get random prizes.
Every spin is a chance for a unique reward!')->keyboard(Keyboard::make()->buttons($buttonsArray))->send();
    $this->chat->deleteMessage($this->messageId)->send();   

        $this->reply('');
    }
    protected function handleUnknownCommand(Stringable $text): void
    {
        $this->reply("Unknown command!");
    }
    protected function handleChatMessage(Stringable $text): void
    {
        $this->chat->deleteMessage($this->messageId)->send();   

        $this->reply("");

    }
}
