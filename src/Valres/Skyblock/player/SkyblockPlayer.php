<?php

namespace Valres\Skyblock\player;

use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\player\Player;
use pocketmine\player\PlayerInfo;
use pocketmine\Server;

class SkyblockPlayer extends Player
{
    public function __construct(Server $server, NetworkSession $session, PlayerInfo $playerInfo, bool $authenticated, Location $spawnLocation, ?CompoundTag $namedtag) {
        parent::__construct($server, $session, $playerInfo, $authenticated, $spawnLocation, $namedtag);
    }

    protected function initEntity(CompoundTag $nbt): void {
        parent::initEntity($nbt); // TODO: Change the autogenerated stub
    }

    public function save(): void {
        parent::save(); // TODO: Change the autogenerated stub
    }
}
