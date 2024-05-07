-- #! mysql
-- #{ players
-- # { init
CREATE TABLE IF NOT EXISTS players
(
    name        TEXT,
    skyblock    TEXT,
    rank        INTEGER
);
-- # }
-- #}