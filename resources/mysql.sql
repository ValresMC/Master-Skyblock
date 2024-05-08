-- #! mysql
-- #{ players
-- # { init
CREATE TABLE IF NOT EXISTS players
(
    name        VARCHAR(255) PRIMARY KEY,
    skyblock    VARCHAR(255) NULL,
    rank        VARCHAR(255) NULL
);
-- # }
-- # { getAll
SELECT * FROM players;
-- # }
-- # { create
-- #    :name     string
INSERT IGNORE INTO players (name, skyblock, rank) VALUES (:name, NULL, NULL);
-- # }
-- # { update
-- #    :name     string
-- #    :skyblock string
-- #    :rank     string
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
    isLock      VARCHAR(255),
    points      INTEGER,
    creation    VARCHAR(255)
);
-- # }
-- #}