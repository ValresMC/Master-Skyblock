<?php

namespace Valres\Skyblock\skyblock;

use pocketmine\world\Position;
use Valres\Skyblock\Skyblock;

class SkyblockIsland
{
    public function __construct(
        protected string $name,
        protected string $leaderName,
        protected Position $memberSpawn,
        protected Position $visitSpawn,
        protected array $members,
        protected bool $lock,
        protected string $creation
    ) {}

    /**
     * Get the name of the skyblock.
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Change name of the skyblock.
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
        $this->save();
    }

    /**
     * Get the name of the leader.
     * @return string
     */
    public function getLeaderName(): string {
        return $this->leaderName;
    }

    /**
     * Change leader of the skyblock.
     * @param string $leaderName
     */
    public function setLeaderName(string $leaderName): void {
        $this->leaderName = $leaderName;
        $this->save();
    }

    /**
     * Get member's spawn point of the skyblock.
     * @return Position
     */
    public function getMemberSpawn(): Position {
        return $this->memberSpawn;
    }

    /**
     * Change visiter's spawn point of the skyblock.
     * @param Position $memberSpawn
     */
    public function setMemberSpawn(Position $memberSpawn): void {
        $this->memberSpawn = $memberSpawn;
        $this->save();
    }

    /**
     * Get visiter's spawn point of the skyblock.
     * @return Position
     */
    public function getVisitSpawn(): Position {
        return $this->visitSpawn;
    }

    /**
     * Change visiter's spawn point of the slyblock.
     * @param Position $visitSpawn
     */
    public function setVisitSpawn(Position $visitSpawn): void {
        $this->visitSpawn = $visitSpawn;
        $this->save();
    }

    /**
     * Get the list of members of the skyblock.
     * @return array
     */
    public function getMembers(): array {
        return $this->members;
    }

    /**
     * Add member in the members skyblock.
     * @param string $name
     * @return void
     */
    public function addMember(string $name): void {
        $this->members[] = $name;
        $this->save();
    }

    /**
     * Check if skyblock is lock or not.
     * @return bool
     */
    public function isLock(): bool {
        return $this->lock;
    }

    /**
     * Set lock status of the skyblock.
     * @param bool $lock
     */
    public function setLock(bool $lock): void {
        $this->lock = $lock;
        $this->save();
    }

    /**
     * Get the creation date of the slyblock.
     * @return string
     */
    public function getCreation(): string {
        return $this->creation;
    }

    public function save(): void {
        Skyblock::getInstance()->getDatabase()->executeChange("skyblocks.update", [
            "name" => $this->name,
            "leader" => $this->leaderName,
            "memberSpawn" => $this->memberSpawn->x . ":" . $this->memberSpawn->y . ":" . $this->memberSpawn->z,
            "visitSpawn" => $this->visitSpawn->x . ":" . $this->visitSpawn->y . ":" . $this->visitSpawn->z,
            "members" => serialize($this->members),
            "isLock" => $this->lock,
            "creation" => $this->creation
        ]);
    }
}
