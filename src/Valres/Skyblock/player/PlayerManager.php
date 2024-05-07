<?php

namespace Valres\Skyblock\player;

use pocketmine\player\Player;
use Valres\Skyblock\Skyblock;

class PlayerManager
{
    private array $players = [];

    /**
     * Get a skyblock player.
     * @param Player $player
     * @return SkyblockPlayer|null
     */
    public function getSkyblockPlayer(Player $player): ?SkyblockPlayer {
        return $this->players[$player->getName()] ?? null;
    }

    /**
     * Load all skyblock players.
     * @return void
     */
    public function loadPlayers(): void {
        Skyblock::getInstance()->getDatabase()->executeSelect("players.getAll", [], function(array $rows): void {
            foreach($rows as $row){
                $this->players[] = new SkyblockPlayer($row["name"], $row["skyblock"], $row["rank"]);
            }
        });
    }
}
