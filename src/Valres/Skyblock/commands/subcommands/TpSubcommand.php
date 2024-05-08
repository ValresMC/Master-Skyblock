<?php

namespace Valres\Skyblock\commands\subcommands;

use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use Valres\Skyblock\libs\CortexPE\Commando\BaseSubCommand;
use Valres\Skyblock\player\SkyblockPlayer;
use Valres\Skyblock\Skyblock;

class TpSubcommand extends BaseSubCommand
{
    public function __construct() {
        parent::__construct(Skyblock::getInstance(), "tp", "Teleport to your island", ["go"]);
        $this->setPermission(DefaultPermissions::ROOT_USER);
    }

    protected function prepare(): void {}

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        if(!$sender instanceof Player) return;
        $plugin = Skyblock::getInstance();
        $playerManager = $plugin->getPlayerManager();
        $skyblockManager = $plugin->getSkyblockManager();

        $skyblockPlayer = $playerManager->getSkyblockPlayer($sender);
        if(!$skyblockPlayer instanceof SkyblockPlayer) return;

        $skylock = $skyblockPlayer->getSkyblock();
        if(!$skyblockPlayer->haveSkyblock()){
            echo "0";
            return;
        }

        $sender->teleport($skylock->getMemberSpawn());
    }
}
