-- name: CreateSocialNetwork :execresult
INSERT INTO social_networks (name, url, icon)
VALUES (?, ?, ?);

-- name: GetSocialNetwork :one
SELECT * FROM social_networks
WHERE id = ?;

-- name: ListSocialNetworks :many
SELECT * FROM social_networks
ORDER BY name;

-- name: UpdateSocialNetwork :exec
UPDATE social_networks
SET name = ?, url = ?, icon = ?
WHERE id = ?;

-- name: DeleteSocialNetwork :exec
DELETE FROM social_networks
WHERE id = ?;
