<?php

namespace Valres\Skyblock\commands;

use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use Valres\Skyblock\commands\subcommands\CreateSubcommand;
use Valres\Skyblock\commands\subcommands\TpSubcommand;
use Valres\Skyblock\libs\CortexPE\Commando\BaseCommand;
use Valres\Skyblock\Skyblock;

class IslandCommand extends BaseCommand
{
    public function __construct() {
        parent::__construct(Skyblock::getInstance(), "island", "Island base command", ["skyblock", "is"]);
        $this->setPermission(DefaultPermissions::ROOT_USER);
    }

    protected function prepare(): void {
        $this->registerSubCommand(new CreateSubcommand());
        $this->registerSubCommand(new TpSubcommand());
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        $message = "§9Skyblock commands§r :\n";
        foreach($this->getSubCommands() as $subCommand){
            $message .= "§9 - /is " . $subCommand->getName() . "§r : " . $subCommand->getDescription() . "\n";
        }
        $sender->sendMessage($message);
    }
}
