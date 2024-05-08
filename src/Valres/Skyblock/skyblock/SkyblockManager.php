<?php

namespace Valres\Skyblock\skyblock;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\Position;
use Valres\Skyblock\player\SkyblockPlayer;
use Valres\Skyblock\Skyblock;

class SkyblockManager
{
    private array $skyblocks = [];

    public function getSkyblock(string $name): ?SkyblockIsland {
        return $this->skyblocks[$name] ?? null;
    }

    public function loadSkyblocks(): void {
        Skyblock::getInstance()->getDatabase()->executeSelect("skyblocks.getAll", [], function(array $rows): void {
            foreach($rows as $row){
                $memberSpawn = explode(":", $row["memberSpawn"]);
                $visitSpawn = explode(":", $row["visitSpawn"]);
                $worldManager = Server::getInstance()->getWorldManager();
                $worldManager->loadWorld("master-skyblock." . $row["name"]);
                $this->skyblocks[$row["name"]] = new SkyblockIsland(
                    $row["name"],
                    $row["leader"],
                    new Position($memberSpawn[0], $memberSpawn[1], $memberSpawn[2], $worldManager->getWorldByName("master-skyblock." . $row["name"])),
                    new Position($visitSpawn[0], $visitSpawn[1], $visitSpawn[2], $worldManager->getWorldByName("master-skyblock." . $row["name"])),
                    unserialize($row["members"]),
                    $row["isLock"],
                    $row["creation"],
                );
            }
        });
    }

    public function createSkyblock(string $name, Player $player): void {
        Skyblock::getInstance()->getDatabase()->executeInsert("skyblocks.create", [
            "name" => $name,
            "leader" => $player->getName(),
            "memberSpawn" => "256:68:256",
            "visitSpawn" => "256:68:256",
            "members" => serialize([]),
            "isLock" => false,
            "creation" => date("d/m/y H:i")
        ], function() use ($name, $player): void {
            Server::getInstance()->getWorldManager()->loadWorld("master-skyblock." . $name);
            $this->skyblocks[$name] = new SkyblockIsland(
                $name, $player->getName(),
                new Position(256, 68, 256, Server::getInstance()->getWorldManager()->getWorldByName("master-skyblock." . $name)),
                new Position(256, 68, 256, Server::getInstance()->getWorldManager()->getWorldByName("master-skyblock." . $name)),
                [],
                false,
                date("M/j/Y H:i:s")
            );
            $skyblockPlayer = Skyblock::getInstance()->getPlayerManager()->getSkyblockPlayer($player);
            if(!$skyblockPlayer instanceof SkyblockPlayer) return;
            $skyblockPlayer->setSkyblock($this->getSkyblock($name));
            $skyblockPlayer->setRank(SkyblockPlayer::LEADER);
            $skyblockPlayer->getSkyblock()->save();
        });
    }
}