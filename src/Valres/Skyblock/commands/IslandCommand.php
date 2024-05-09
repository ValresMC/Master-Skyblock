<?php

namespace Valres\Skyblock\commands;

use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use Valres\Skyblock\commands\subcommands\CreateSubcommand;
use Valres\Skyblock\commands\subcommands\DisbandSubcommand;
use Valres\Skyblock\commands\subcommands\TpSubcommand;
use Valres\Skyblock\libs\CortexPE\Commando\BaseCommand;

class IslandCommand extends BaseCommand
{
    protected function prepare(): void {
        $this->setPermission(DefaultPermissions::ROOT_USER);
        $this->registerSubCommand(new CreateSubcommand());
        $this->registerSubCommand(new DisbandSubcommand());
        $this->registerSubCommand(new TpSubcommand());
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        $commands = [];
        $message = "§9Skyblock commands§r :\n";
        foreach($this->getSubCommands() as $subCommand){
            if(!in_array($subCommand->getName(), $commands))
            $message .= "§9 - /is " . $subCommand->getName() . "§r : " . $subCommand->getDescription() . "\n";
            $commands[] = $subCommand->getName();
        }
        $sender->sendMessage($message);
    }

    public function getPermission() {}
}
