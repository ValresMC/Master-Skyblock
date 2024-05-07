-- #! sqlite
-- #{ players
-- # { init
CREATE TABLE IF NOT EXISTS players
(
    name        TEXT,
    skyblock    TEXT,
    rank        TEXT
);
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