<?php

namespace Valres\Skyblock;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use Valres\Skyblock\libs\poggit\libasynql\DataConnector;
use Valres\Skyblock\libs\poggit\libasynql\libasynql;
use Valres\Skyblock\listeners\player\PlayerJoin;
use Valres\Skyblock\player\PlayerManager;
use Valres\Skyblock\skyblock\SkyblockManager;

class Skyblock extends PluginBase
{
    use SingletonTrait;

    private PlayerManager $playerManager;
    private SkyblockManager $skyblockManager;

    private DataConnector $database;

    protected function onEnable(): void {
        $this->saveDefaultConfig();
        $this->database = libasynql::create($this, $this->getConfig()->get("database"), [
            "sqlite" => "sqlite.sql",
            "mysql" => "mysql.sql"
        ]);
        $this->playerManager = new PlayerManager();
        $this->skyblockManager = new SkyblockManager();

        $this->getDatabase()->executeGeneric("players.init");
        $this->getDatabase()->executeGeneric("skyblocks.init");
        $this->getDatabase()->waitAll();

        $this->getPlayerManager()->loadPlayers();

        $this->getServer()->getPluginManager()->registerEvents(new PlayerJoin(), $this);
    }

    protected function onLoad(): void {
        self::setInstance($this);
    }

    protected function onDisable(): void {
        $this->getDatabase()->waitAll();
        $this->getDatabase()->close();
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
}
