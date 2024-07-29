<?php


namespace App\Http\Telegram;

use App\Models\Pet;
use App\Models\PetUser;
use DefStudio\Telegraph\DTO\Chat;
use DefStudio\Telegraph\DTO\Message;
use DefStudio\Telegraph\DTO\TelegramUpdate;
use DefStudio\Telegraph\Enums\ChatActions;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;
use App\Models\User;
use DefStudio\Telegraph\Models\TelegraphChat;

class MainHook extends WebhookHandler{
    
    public function start(){
        $chatId = $this->message->chat()->id();
        User::firstOrCreate([
            'chat_id' => $chatId
        ],[
            'chat_id' => $chatId, 
            'name' => $this->message->chat()->title()
        ]);
       $this->chat->message("Привет!" . "\nТвой *ID:* " . "`" .$chatId . "`" . "\n\n Меню")->keyboard(
            Keyboard::make()->buttons([
                Button::make('🐾 Мои питомцы')->action('myPets'),
                Button::make('🆓 Получить бесплатных питомцев')->action('freePets'),
                Button::make('🏪 Магазин')->action('shop'),
                Button::make('🎰 Колесо фортуны')->action('fortuneWheel')
                ])
        )->send();
    }



    
    public function myPets(){
        $this->chat->deleteMessage($this->messageId)->send();

        $chatId = $this->callbackQuery->from()->id();
        $user = User::query()->where('chat_id', $chatId)->first();
        $userPets = PetUser::query()->where('user_id', $user->id)->get();
        
        $buttonsArray = [];
        foreach( $userPets as $userPet){
            $buttonsArray[] = Button::make('Питомец №'. $userPet->pet->id . ' - ' . $userPet->pet->name->title)->action('pet')->param('id', $userPet->pet->id);
        }

       $this->chat->message('Твои питомцы')->photo( 'images/myPets.jpg')->keyboard(
            Keyboard::make()->buttons($buttonsArray)
        )->send();
        $this->reply('');
    }

    public function pet(){
        $this->chat->deleteMessage($this->messageId)->send();

        $pet = Pet::find($this->data->get('id'));
        $buttonsArray = [];
        $buttonsArray[] = Button::make('🍽️ Кормить')->action('feed')->param('id',$this->data->get('id'));
        $buttonsArray[] = Button::make('🎯 Тренировать')->action('train')->param('id',$this->data->get('id'));

        

        $this->chat->message("
🐾 Питомец № $pet->id \n
📝 Имя: * {$pet->name->title} * \n
📚 Опыт: * {$pet->experience} *\n
😋 Голод: * {$pet->hunger->title} ({$pet->hunger->hunger_index}/10🍕)*\n"
        
        )->photo( $pet->image->title)->keyboard(
            Keyboard::make()->buttons($buttonsArray)
        )->send();

                
        $this->reply("");  
    }

    public function feed(){
        $pet = Pet::find($this->data->get('id'));
        try {
            $pet->experience += 10;
            $pet->save();
            // $this->chat->message("123")->edit($this->messageId)->send();
            // $buttonsArray = [];
            // $buttonsArray[] = Button::make('Кормить')->action('feed')->param('id',$this->data->get('id'));
            // $buttonsArray[] = Button::make('Тренировать')->action('train')->param('id',$this->data->get('id'));
        
            // $this->reply("Вы покормили " . $pet->name->title);
            // $this->chat->deleteMessage($this->messageId)->send();

            // $this->chat->message("Питомец № $pet->id \nИмя:* " . $pet->name->title . " * \nОпыт: * $pet->experience *\n")->photo( $pet->image->title)->keyboard(
            //     Keyboard::make()->buttons($buttonsArray)
            // )->send();
            $this->pet();
            $this->reply('');


        } catch (\Throwable $th) {
            $this->reply('Ошибка!');
        }
    }

    public function train(){
       
        $this->reply('');
    }
    public function freePets(){
        $userId = $this->callbackQuery->from()->id();
        $freePetsAmount = 10;

        $user = User::query()->where('chat_id', $userId)->first();
        $createdPets = Pet::factory($freePetsAmount)->create();

        try {
            foreach($createdPets as $pet){
                PetUser::create([
                    'user_id' => $user->id,
                    'pet_id' => $pet->id
                ]);
            }
            $this->reply('Питомцы успешно добавлены!');
        } catch (\Throwable $th) {
            $this->reply('Не удалось получить бесплатных питомцев!');
        }

        
    }

    protected function handleUnknownCommand(Stringable $text): void{
        $this->reply("Неизвестная комманда!");
    }
    protected function handleChatMessage(Stringable $text): void
    {
        $this->reply("Я принял твоё сообщение");
        
    }
}