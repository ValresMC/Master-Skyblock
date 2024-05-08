<?php

namespace Valres\Skyblock\commands\subcommands;

use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use pocketmine\utils\Utils;
use pocketmine\world\World;
use Valres\Skyblock\libs\CortexPE\Commando\args\RawStringArgument;
use Valres\Skyblock\libs\CortexPE\Commando\BaseSubCommand;
use Valres\Skyblock\libs\CortexPE\Commando\exception\ArgumentOrderException;
use Valres\Skyblock\player\SkyblockPlayer;
use Valres\Skyblock\Skyblock;
use Valres\Skyblock\utils\WorldHelper;

class CreateSubcommand extends BaseSubCommand
{
    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void {
        $this->setPermission(DefaultPermissions::ROOT_USER);
        $this->registerArgument(0, new RawStringArgument("name", true));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        if(!$sender instanceof Player) return;
        $plugin = Skyblock::getInstance();
        $worldManager = $plugin->getServer()->getWorldManager();
        $playerManager = $plugin->getPlayerManager();
        $skyblockManager = $plugin->getSkyblockManager();

        $skyblockPlayer = $playerManager->getSkyblockPlayer($sender);
        if(!$skyblockPlayer instanceof SkyblockPlayer) return;
        if($skyblockPlayer->haveSkyblock()){
            echo "0";
            return;
        }

        if(empty($args)){
            echo "1";
            return;
        }

        if($worldManager->getWorldByName("master-skyblock." . $args["name"]) instanceof World){
            echo "2";
            return;
        }

        if(count(array_diff(Utils::assumeNotFalse(scandir($plugin->getDataFolder() . 'island/island')), ['..', '.'])) == 0){
            $sender->sendMessage("no default island");
            return;
        }

        WorldHelper::copyWorld("island", "master-skyblock." . $args["name"]);
        $skyblockManager->createSkyblock($args["name"], $sender);
    }
}
