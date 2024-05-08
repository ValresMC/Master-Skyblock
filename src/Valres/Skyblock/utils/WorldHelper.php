<?php

namespace Valres\Skyblock\utils;


use pocketmine\nbt\LittleEndianNbtSerializer;
use pocketmine\nbt\TreeRoot;
use pocketmine\Server;
use pocketmine\utils\Binary;
use pocketmine\world\format\io\data\BedrockWorldData;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Valres\Skyblock\Skyblock;

class WorldHelper
{
    public static function copyWorld(string $newName, string $name): void {
        $server = Server::getInstance();
        $plugin = Skyblock::getInstance();

        $worldPath = $server->getDataPath() . "/worlds/$name/";
        $dbPath = $worldPath . "db/";

        self::createDirectory($worldPath);
        self::createDirectory($dbPath);

        self::copyFile($plugin->getDataFolder() . "island/" . $newName . "/level.dat", $worldPath . "level.dat");
        self::transferWorldData($plugin->getDataFolder() . "island/" . $newName . "/level.dat", $worldPath . "level.dat", $name);
        self::copyDirectory($plugin->getDataFolder() . "island/" . $newName . "/db", $dbPath);
    }

    private static function transferWorldData(string $oldWorldPath, string $newWorldPath, string $name): void {
        $oldWorldNbt = new BedrockWorldData($oldWorldPath);
        $worldData = $oldWorldNbt->getCompoundTag();
        $worldData->setString("LevelName", $name);
        $nbt = new LittleEndianNbtSerializer();
        $buffer = $nbt->write(new TreeRoot($worldData));
        file_put_contents($newWorldPath, Binary::writeLInt(BedrockWorldData::CURRENT_STORAGE_VERSION) . Binary::writeLInt(strlen($buffer)) . $buffer);
    }

    private static function createDirectory(string $path): void {
        if(!is_dir($path) && !mkdir($path, 0777, true)){
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
    }

    private static function copyFile(string $source, string $destination): void {
        if(!copy($source, $destination)){
            throw new \RuntimeException(sprintf('Failed to copy file from "%s" to "%s"', $source, $destination));
        }
    }

    private static function copyDirectory(string $from, string $to): void {
        $to = rtrim($to, "/\\") . "/";
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($from)) as $file){
            if($file->isFile()){
                $target = $to . ltrim(substr($file->getRealPath(), strlen($from)), "/\\");
                $dir = dirname($target);
                self::createDirectory($dir);
                self::copyFile($file->getRealPath(), $target);
            }
        }
    }
}

