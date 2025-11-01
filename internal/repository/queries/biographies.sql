-- name: CreateBiography :execresult
INSERT INTO biographies (title, text)
VALUES (?, ?);

-- name: GetBiography :one
SELECT * FROM biographies
WHERE id = ?;

-- name: ListBiographies :many
SELECT * FROM biographies
ORDER BY created_at DESC;

-- name: UpdateBiography :exec
UPDATE biographies
SET title = ?, text = ?
WHERE id = ?;

-- name: DeleteBiography :exec
DELETE FROM biographies
WHERE id = ?;
