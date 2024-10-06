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
        $this->chat->deleteMessage($this->messageId)->send();

        if ($this->message == null) {
            $chatId = $this->callbackQuery->from()->id();
        } else {
            $chatId = $this->message->chat()->id();
        }

        $this->chat->message("👋 Привет!" . "\nТвой *ID:* " . "`" . $chatId . "`" . "\n\n📋 Меню")->keyboard(
            Keyboard::make()->buttons([
                Button::make('🐾 Мои питомцы')->action('myPets'),
                Button::make('🆓 Получить бесплатных питомцев')->action('freePets'),
                Button::make('🏪 Магазин')->action('shop'),
                Button::make('🎰 Колесо фортуны')->action('fortuneWheel'),
            ])
        )->send();
    }

    public function myPets()
    {
        $this->chat->deleteMessage($this->messageId)->send();

        $chatId = $this->callbackQuery->from()->id();
        $user = User::query()->where('chat_id', $chatId)->first();
        $userPets = $user->pets()->paginate(100);

        $buttonsArray = [];
        foreach ($userPets as $userPet) {
            $buttonsArray[] = Button::make('Питомец' . ' - ' . $userPet->name->title)->action('pet')->param('id', $userPet->id);
        }
        Log::info($buttonsArray);
        $buttonsArray[] = Button::make('🔙 Назад в меню')->action('menu');

        $this->chat->message('Твои питомцы')->photo('images/myPets.jpg')->keyboard(
            Keyboard::make()->buttons($buttonsArray)->chunk(2)
        )->send();
        $this->reply('');

    }

    public function pet($id = NULL)
    {

        $this->chat->deleteMessage($this->messageId)->send();

        if($id != NULL){
            $pet = Pet::find($id);
        }else{
            $pet = Pet::find($this->data->get('id'));
        }
        $buttonsArray = [];
        $buttonsArray[] = Button::make('🍽️ Кормить')->action('feed')->param('id', $this->data->get('id'));
        $buttonsArray[] = Button::make('🎯💪 Тренировать')->action('train')->param('id', $this->data->get('id'));
        $buttonsArray[] = Button::make('🔙 Назад к питомцам')->action('myPets');

        $this->chat->message("
🐾 Питомец № $pet->id \n
📝 Имя: * {$pet->name->title} * \n
📚 Опыт: * {$pet->experience} *\n
💪 Сила : *{$pet->strength}*\n
😋 Голод: * {$pet->hunger_index}/10🍕*\n"

        )->photo($pet->image->title)->keyboard(
            Keyboard::make()->buttons($buttonsArray)
        )->send();

        $this->reply("");
    }

    public function feed()
    {
        $pet = Pet::find($this->data->get('id'));
        try {
            $expPointsForFood = 10;

            if ($pet->hunger_index >= 10) {
                $this->reply("Питомец сыт!");
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
            $this->reply("Вы покормили " . $pet->name->title . " (+{$expPointsForFood} очков опыта)");
            
            $this->pet($pet->id);

        } catch (\Throwable $th) {
            $this->reply('Ошибка!');
        }
    }

    public function train($id = NULL)
    {
        $this->chat->deleteMessage($this->messageId)->send();

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
        $this->reply("Вы потренировали питомца (+ {$strengthPointsForTrain} силы)");
        $this->pet($pet->id);
    }
    public function freePets()
    {
        $userId = $this->callbackQuery->from()->id();
        $freePetsAmount = 10;

        $user = User::query()->where('chat_id', $userId)->first();

        try {
            $createdPets = Pet::factory()->count(5)->sequence([
                'rarity_id' => PetRarity::all()->random()->id,
                    'image_id' => PetImage::all()->random()->id,
                    'name_id' => PetName::all()->random()->id,
                    'experience' => fake()->numberBetween(0, 10000),
                    'strength' => fake()->numberBetween(1, 1000),
                    'hunger_index' => fake()->numberBetween(0, 10),
                    'user_id' => $user->id
            ],[
                'rarity_id' => PetRarity::all()->random()->id,
                    'image_id' => PetImage::all()->random()->id,
                    'name_id' => PetName::all()->random()->id,
                    'experience' => fake()->numberBetween(0, 10000),
                    'strength' => fake()->numberBetween(1, 1000),
                    'hunger_index' => fake()->numberBetween(0, 10),
                    'user_id' => $user->id
            ],[
                'rarity_id' => PetRarity::all()->random()->id,
                    'image_id' => PetImage::all()->random()->id,
                    'name_id' => PetName::all()->random()->id,
                    'experience' => fake()->numberBetween(0, 10000),
                    'strength' => fake()->numberBetween(1, 1000),
                    'hunger_index' => fake()->numberBetween(0, 10),
                    'user_id' => $user->id
            ],[
                'rarity_id' => PetRarity::all()->random()->id,
                    'image_id' => PetImage::all()->random()->id,
                    'name_id' => PetName::all()->random()->id,
                    'experience' => fake()->numberBetween(0, 10000),
                    'strength' => fake()->numberBetween(1, 1000),
                    'hunger_index' => fake()->numberBetween(0, 10),
                    'user_id' => $user->id
            ],[
                'rarity_id' => PetRarity::all()->random()->id,
                    'image_id' => PetImage::all()->random()->id,
                    'name_id' => PetName::all()->random()->id,
                    'experience' => fake()->numberBetween(0, 10000),
                    'strength' => fake()->numberBetween(1, 1000),
                    'hunger_index' => fake()->numberBetween(0, 10),
                    'user_id' => $user->id
            ])->create();
            $this->reply('Питомцы успешно добавлены!');
        } catch (\Throwable $th) {
            Log::info($th);
            $this->reply('Не удалось получить бесплатных питомцев!');
        }

    }

    protected function handleUnknownCommand(Stringable $text): void
    {
        $this->reply("Неизвестная комманда!");
    }
    protected function handleChatMessage(Stringable $text): void
    {
        $this->reply("Я принял твоё сообщение");

    }
}
