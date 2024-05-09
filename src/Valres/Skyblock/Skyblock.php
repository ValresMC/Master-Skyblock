<?php

namespace Valres\Skyblock;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use Valres\Skyblock\commands\IslandCommand;
use Valres\Skyblock\libs\CortexPE\Commando\PacketHooker;
use Valres\Skyblock\libs\poggit\libasynql\DataConnector;
use Valres\Skyblock\libs\poggit\libasynql\libasynql;
use Valres\Skyblock\listeners\player\PlayerJoin;
use Valres\Skyblock\messages\Messages;
use Valres\Skyblock\player\PlayerManager;
use Valres\Skyblock\skyblock\SkyblockManager;

class Skyblock extends PluginBase
{
    use SingletonTrait;

    private PlayerManager $playerManager;
    private SkyblockManager $skyblockManager;
    private Messages $messages;

    private DataConnector $database;

    protected function onEnable(): void {
        $this->saveDefaultConfig();
        $this->saveResource("messages.yml", true);
        @mkdir($this->getDataFolder() . "island/");

        $this->init();

        $this->getDatabase()->executeGeneric("players.init");
        $this->getDatabase()->executeGeneric("skyblocks.init");
        $this->getDatabase()->waitAll();

        $this->getSkyblockManager()->loadSkyblocks();
        $this->getPlayerManager()->loadPlayers();
        $this->getMessageManager()->initMessages();

        $this->loadListeners();
        $this->loadCommands();
    }

    protected function onLoad(): void {
        self::setInstance($this);
    }

    protected function onDisable(): void {
        $this->getDatabase()->waitAll();
        $this->getDatabase()->close();
    }

    public function loadCommands(): void {
        if(!PacketHooker::isRegistered()) PacketHooker::register($this);
        $this->getServer()->getCommandMap()->registerAll("master-skyblock", [
            new IslandCommand($this, "island", "Island base commands", ["is", "skyblock"])
        ]);
    }

    public function loadListeners(): void {
        $listeners = [
            new PlayerJoin()
        ];

        foreach($listeners as $listener){
            $this->getServer()->getPluginManager()->registerEvents($listener, $this);
        }
    }

    public function init(): void {
        $this->database = libasynql::create($this, $this->getConfig()->get("database"), [
            "sqlite" => "sqlite.sql",
            "mysql" => "mysql.sql"
        ]);
        $this->playerManager = new PlayerManager();
        $this->skyblockManager = new SkyblockManager();
        $this->messages = new Messages();
    }

    public function getPlayerManager(): PlayerManager {
        return $this->playerManager;
    }

    public function getSkyblockManager(): SkyblockManager {
        return $this->skyblockManager;
    }

    public function getDatabase(): DataConnector {
        return $this->database;
    }

    public function getMessageManager(): Messages {
        return $this->messages;
    }
}
