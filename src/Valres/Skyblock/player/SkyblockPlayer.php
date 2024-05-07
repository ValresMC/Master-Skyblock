<?php

namespace Valres\Skyblock\player;

use Valres\Skyblock\skyblock\Skyblock;

class SkyblockPlayer
{
    const LEADER = "leader";
    const OFFICIER = "officier";
    const MEMBER = "member";

    public function __construct(
        protected string $name,
        protected ?Skyblock $skyblock,
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
     * @return Skyblock|null
     */
    public function getSkyblock(): ?Skyblock {
        return $this->skyblock;
    }

    /**
     * Get the rank of the player.
     * @return string|null
     */
    public function getRank(): ?string {
        return $this->rank;
    }
}
