<?php

namespace Valres\Skyblock\commands\subcommands;

use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use pocketmine\world\World;
use pocketmine\world\WorldCreationOptions;
use Valres\Skyblock\generator\Island;
use Valres\Skyblock\libs\CortexPE\Commando\args\RawStringArgument;
use Valres\Skyblock\libs\CortexPE\Commando\BaseSubCommand;
use Valres\Skyblock\libs\CortexPE\Commando\exception\ArgumentOrderException;
use Valres\Skyblock\player\SkyblockPlayer;
use Valres\Skyblock\Skyblock;

class CreateSubcommand extends BaseSubCommand
{
    public function __construct() {
        parent::__construct(Skyblock::getInstance(), "create", "Create a island");
        $this->setPermission(DefaultPermissions::ROOT_USER);
    }

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void {
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

        $worldOptions = (new WorldCreationOptions())->setGeneratorClass(Island::class);
        $worldManager->generateWorld("master-skyblock." . $args["name"], $worldOptions);
        $skyblockManager->createSkyblock($args["name"], $sender);
    }
}
