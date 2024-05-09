<?php

namespace Valres\Skyblock\commands\subcommands;

use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Filesystem;
use pocketmine\world\World;
use Valres\Skyblock\libs\CortexPE\Commando\BaseSubCommand;
use Valres\Skyblock\player\SkyblockPlayer;
use Valres\Skyblock\Skyblock;

class DisbandSubcommand extends BaseSubCommand
{
    public function __construct() {
        parent::__construct("disband", "Disband your island");
    }

    protected function prepare(): void {
        $this->setPermission(DefaultPermissions::ROOT_USER);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        if(!$sender instanceof Player) return;
        $plugin = Skyblock::getInstance();
        $playerManager = $plugin->getPlayerManager();

        $skyblockPlayer = $playerManager->getSkyblockPlayer($sender);
        if(!$skyblockPlayer instanceof SkyblockPlayer) return;

        if(!$skyblockPlayer->haveSkyblock()){
            $sender->sendMessage($plugin->getMessageManager()->getMessage("no-island"));
            return;
        }

        if($skyblockPlayer->getRank() !== SkyblockPlayer::LEADER){
            $sender->sendMessage($plugin->getMessageManager()->getMessage("not-leader"));
            return;
        }

        $world = Server::getInstance()->getWorldManager()->getWorldByName("master-skyblock." . $skyblockPlayer->getSkyblock()->getName());
        if($world instanceof World) {
            foreach($world->getPlayers() as $player_){
                $player_->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSpawnLocation());
            }
            if($world->isLoaded()){
                $folderName = $world->getFolderName();
                $plugin->getServer()->getWorldManager()->unloadWorld($world);
                Filesystem::recursiveUnlink($plugin->getServer()->getDataPath() . 'worlds/' . $folderName);
            }
        }

        foreach($skyblockPlayer->getSkyblock()->getMembers() as $member){
            $skyblockMember = $playerManager->getSkyblockPlayer($member);
            $skyblockMember->setRank(null);
            $skyblockMember->setRank(null);
            if(Server::getInstance()->getPlayerExact($member) instanceof Player){
                $sender->sendMessage($plugin->getMessageManager()->getMessage("disband-island"));
            }
        }
        Skyblock::getInstance()->getSkyblockManager()->deleteSkyblock($skyblockPlayer->getSkyblock()->getName());
        $skyblockPlayer->setRank(null);
        $skyblockPlayer->setSkyblock(null);
        $sender->sendMessage($plugin->getMessageManager()->getMessage("disband-island"));
    }
}