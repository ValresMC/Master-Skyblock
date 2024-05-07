<?php

namespace Valres\Skyblock;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Skyblock extends PluginBase
{
    use SingletonTrait;

    protected function onEnable(): void {

    }

    protected function onLoad(): void {
        self::setInstance($this);
    }

    protected function onDisable(): void {

    }
}
