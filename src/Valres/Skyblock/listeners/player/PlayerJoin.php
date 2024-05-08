<?php

namespace Valres\Skyblock\listeners\player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use Valres\Skyblock\Skyblock;

class PlayerJoin implements Listener
{
    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $playerManager = Skyblock::getInstance()->getPlayerManager();

        if(!$playerManager->existSkyblockPlayer($player)){
            $playerManager->createPlayer($player);
        }
    }
}
