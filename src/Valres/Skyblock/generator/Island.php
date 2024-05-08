<?php

namespace Valres\Skyblock\generator;

use pocketmine\block\VanillaBlocks;
use pocketmine\math\Vector3;
use pocketmine\world\ChunkManager;
use pocketmine\world\generator\Generator;
use pocketmine\world\generator\object\OakTree;

class Island extends Generator
{
    public function __construct(int $seed, string $preset) {
        parent::__construct($seed, $preset);
    }

    public function generateChunk(ChunkManager $world, int $chunkX, int $chunkZ): void {}

    public function populateChunk(ChunkManager $world, int $chunkX, int $chunkZ): void {
        if($chunkX == 16 && $chunkZ == 16) {
            $center = new Vector3(256, 68, 256);

            $offsets = [[0, 0, 0], [3, 0, 0], [0, 0, -3]];
            $blocksToPlace = [
                [69, VanillaBlocks::GRASS()],
                [69, VanillaBlocks::GRASS()],
                [69, VanillaBlocks::GRASS()],
                [2, VanillaBlocks::CHEST()],
                [2, VanillaBlocks::OBSIDIAN()]
            ];

            foreach($offsets as $offset){
                foreach($blocksToPlace as $blockInfo){
                    $blockVec = $center->add($offset[0], $offset[1], $offset[2]);
                    $world->setBlockAt($blockVec->getX(), $blockVec->getY(), $blockVec->getZ(), $blockInfo[1]);
                }
            }

            $treeVec = $center->add(4, 2, 1);
            $tree = new OakTree;
            $tree->getBlockTransaction($world, $treeVec->getX(), $treeVec->getY(), $treeVec->getZ(), $this->random)->apply();
        }
    }
}
