-- #! mysql
-- #{ players
-- # { init
CREATE TABLE IF NOT EXISTS players
(
    name        VARCHAR(255) PRIMARY KEY,
    skyblock    VARCHAR(255),
    rank        VARCHAR(255)
);
-- # }
-- # { getAll
SELECT * FROM players;
-- # }
-- # { create
-- #    :name         string
INSERT INTO players (name, skyblock, rank) VALUES (:name, "", "");
-- # }
-- # { update
-- #    :name         string
-- #    :skyblock     string
-- #    :rank         string
UPDATE players SET skyblock = :skyblock, rank = :rank WHERE name = :name
-- # }
-- #}
-- #{ skyblocks
-- # { init
CREATE TABLE IF NOT EXISTS skyblocks
(
    name        VARCHAR(255) PRIMARY KEY,
    leader      VARCHAR(255),
    memberSpawn VARCHAR(255),
    visitSpawn  VARCHAR(255),
    members     VARCHAR(255),
    isLock      BOOLEAN,
    creation    VARCHAR(255)
);
-- # }
-- # { getAll
SELECT * FROM skyblocks;
-- # }
-- # { create
-- #    :name         string
-- #    :leader       string
-- #    :memberSpawn  string
-- #    :visitSpawn   string
-- #    :members      string
-- #    :isLock       bool
-- #    :creation     string
INSERT INTO skyblocks (name, leader, memberSpawn, visitSpawn, members, isLock, creation) VALUES (:name, :leader, :memberSpawn, :visitSpawn, :members, :isLock, :creation);
-- # }
-- # { update
-- #    :name         string
-- #    :leader       string
-- #    :memberSpawn  string
-- #    :visitSpawn   string
-- #    :members      string
-- #    :isLock       bool
-- #    :creation     string
UPDATE skyblocks SET leader = :leader, memberSpawn = :memberSpawn, visitSpawn = :visitSpawn, members = :members, isLock = :isLock, creation = :creation WHERE name = :name
-- # }
-- #}