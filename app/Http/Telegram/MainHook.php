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

class MainHook extends WebhookHandler{
    
    public function start(){
        $chatId = $this->message->chat()->id();
        $user = User::firstOrCreate([
            'chat_id' => $chatId
        ],[
            'chat_id' => $chatId, 
            'name' => $this->message->chat()->title()
        ]);
        $this->reply("Привет!" . "\nТвой *ID:* " . '`' .$chatId . '`');
       $this->chat->message('Меню')->keyboard(
            Keyboard::make()->buttons([
                Button::make('Мои питомцы')->action('myPets'),
                Button::make('Магазин')->action('shop'),
                Button::make('Колесо фортуны')->action('fortuneWheel')
                ])
        )->send();
    }



    
    public function myPets(){
        
        $chatId = $this->callbackQuery->from()->id();
        $user = User::query()->where('chat_id', $chatId)->first();
        $userPets = PetUser::query()->where('user_id', $user->id)->get();
        
        $buttonsArray = [];
        foreach( $userPets as $userPet){
            $buttonsArray[] = Button::make('Питомец №'. $userPet->pet->id . ' - ' . $userPet->pet->name->title)->action('pet')->param('id', $userPet->pet->id);
        }

       $this->chat->message('Твои питомцы' . $chatId)->send();
       $this->chat->message('Твои питомцы')->photo( 'images/myPets.jpg')->keyboard(
            Keyboard::make()->buttons($buttonsArray)
        )->send();
        $this->reply('');
    }

    public function pet(){
        $pet = Pet::find($this->data->get('id'));
        $buttonsArray = [];
        $buttonsArray[] = Button::make('Кормить')->action('feed')->param('id',$this->data->get('id'));
        $buttonsArray[] = Button::make('Тренировать')->action('train')->param('id',$this->data->get('id'));
        


        $this->chat->message("Питомец № $pet->id \nИмя:* " . $pet->name->title . " * \nОпыт: * $pet->experience *\n")->photo( $pet->image->title)->keyboard(
            Keyboard::make()->buttons($buttonsArray)
        )->send();

        $this->reply("");  
    }

    protected function handleUnknownCommand(Stringable $text): void{
        $this->reply("Неизвестная комманда!");
    }
    protected function handleChatMessage(Stringable $text): void
    {
        $this->reply("Я принял твоё сообщение");
        
    }
}