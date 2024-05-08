<?php

namespace Valres\Skyblock\player;

use Valres\Skyblock\Skyblock;
use Valres\Skyblock\skyblock\SkyblockIsland;

class SkyblockPlayer
{
    const LEADER = "leader";
    const OFFICIER = "officier";
    const MEMBER = "member";

    public function __construct(
        protected string $name,
        protected ?SkyblockIsland $skyblock,
        protected ?string $rank
    ) {}

    /**
     * Get the name of the player.
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Get the skyblock of the player.
     * @return SkyblockIsland|null
     */
    public function getSkyblock(): ?SkyblockIsland {
        return $this->skyblock;
    }

    /**
     * Check if player have skyblock.
     * @return bool
     */
    public function haveSkyblock(): bool {
        return !is_null($this->skyblock);
    }

    /**
     * Set the current skyblock of the player.
     * @param SkyblockIsland|null $skyblock
     */
    public function setSkyblock(?SkyblockIsland $skyblock): void {
        $this->skyblock = $skyblock;
        $this->save();
    }

    /**
     * Get the rank of the player.
     * @return string|null
     */
    public function getRank(): ?string {
        return $this->rank;
    }

    /**
     * Set the current rank of the player.
     * @param string|null $rank
     */
    public function setRank(?string $rank): void {
        $this->rank = $rank;
        $this->save();
    }

    /**
     * Save the player datas.
     * @return void
     */
    public function save(): void {
        Skyblock::getInstance()->getDatabase()->executeChange("players.update", [
            "name" => $this->name,
            "skyblock" => $this->skyblock?->getName() ?? null,
            "rank" => $this->rank
        ]);
    }
}
