<?php


namespace App\Http\Telegram;

use DefStudio\Telegraph\Handlers\WebhookHandler;
use Illuminate\Support\Stringable;

class MainHook extends WebhookHandler{
    public function start(){
        $this->reply("Привет!");
    }



    
    protected function handleUnknownCommand(Stringable $text): void{
        $this->reply("Неизвестная комманда!");
    }
    protected function handleChatMessage(Stringable $text): void
    {
        $this->reply("Я принял твоё сообщение");
        
    }
}