-- name: CreatePortfolioInfo :execresult
INSERT INTO portfolio_infos (hero_message, hero_playlist_url, biography, profile_picture_url, work_philosophy, closing_phrase, legal_mentions)
VALUES (?, ?, ?, ?, ?, ?, ?);

-- name: GetPortfolioInfo :one
SELECT * FROM portfolio_infos
WHERE id = ?;

-- name: ListPortfolioInfos :many
SELECT * FROM portfolio_infos;

-- name: UpdatePortfolioInfo :exec
UPDATE portfolio_infos
SET hero_message = ?, hero_playlist_url = ?, biography = ?, profile_picture_url = ?, work_philosophy = ?, closing_phrase = ?, legal_mentions = ?
WHERE id = ?;

-- name: DeletePortfolioInfo :exec
DELETE FROM portfolio_infos
WHERE id = ?;
