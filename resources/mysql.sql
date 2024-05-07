-- #! mysql
-- #{ players
-- # { init
CREATE TABLE IF NOT EXISTS players
(
    name        TEXT,
    skyblock    TEXT,
    rank        TEXT
);
-- # }
-- # { getAll
SELECT * FROM players;
-- # { create
-- #    :name     string
-- #    :skyblock string
-- #    :rank     string
INSERT INTO players (name, skyblock, rank) VALUES (:name, :skyblock, :rank);
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
    name        TEXT,
    leader      TEXT,
    memberSpawn TEXT,
    visitSpawn  TEXT,
    members     TEXT,
    isLock      TEXT,
    points      FLOAT,
    creation    TEXT
);
-- # }
-- #}