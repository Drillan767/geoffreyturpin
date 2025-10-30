-- name: CreateSocialNetwork :execresult
INSERT INTO social_networks (platform, url)
VALUES (?, ?);

-- name: GetSocialNetwork :one
SELECT * FROM social_networks
WHERE id = ?;

-- name: ListSocialNetworks :many
SELECT * FROM social_networks
ORDER BY name;

-- name: UpdateSocialNetwork :exec
UPDATE social_networks
SET platform = ?, url = ?
WHERE id = ?;

-- name: DeleteSocialNetwork :exec
DELETE FROM social_networks
WHERE id = ?;
