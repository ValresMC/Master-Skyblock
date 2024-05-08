<?php

namespace Valres\Skyblock\player;

use Overy\OveryCore\Core;
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
     * @param Player $player
     * @return bool
     */
    public function existSkyblockPlayer(Player $player): bool {
        return $this->players[$player->getName()] instanceof SkyblockPlayer;
    }

    /**
     * Load all skyblock players.
     * @return void
     */
    public function loadPlayers(): void {
        Skyblock::getInstance()->getDatabase()->executeSelect("players.getAll", [], function(array $rows): void {
            foreach($rows as $row){
                $this->players[$row["name"]] = new SkyblockPlayer($row["name"], $row["skyblock"], $row["rank"]);
            }
        });
    }

    /**
     * Create a skyblock player.
     * @param Player $player
     * @return void
     */
    public function createPlayer(Player $player): void {
        Skyblock::getInstance()->getDatabase()->executeInsert("players.create", ["name" => $player->getName()], function() use ($player): void {
            $this->players[$player->getName()] = new SkyblockPlayer($player->getName(), null, null);
        });
    }
}
