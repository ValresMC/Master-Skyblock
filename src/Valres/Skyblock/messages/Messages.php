<?php

namespace Valres\Skyblock\messages;

use pocketmine\utils\Config;
use Valres\Skyblock\Skyblock;

class Messages
{
    private string $prefix = "§l§9[§r§7Master-Skyblock§l§9]§r";
    private array $messages = [];

    public function initMessages(): void {
        $messagesData = new Config(Skyblock::getInstance()->getDataFolder() . "messages.yml", Config::YAML);
        $messages = $messagesData->getAll();
        $this->prefix = $messages["prefix"];
        unset($messages["prefix"]);

        foreach($messages as $type => $message){
            if(!in_array($type, $this->messages)){
                $this->messages[$type] = $message;
            }
        }
    }

    public function getMessage(string $message): string {
        return $this->prefix . " " . $this->messages[$message];
    }
}
