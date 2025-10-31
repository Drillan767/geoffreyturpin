-- name: CreateService :execresult
INSERT INTO services (name, description, display_order)
VALUES (?, ?, ?);

-- name: GetService :one
SELECT * FROM services
WHERE id = ?;

-- name: ListServices :many
SELECT * FROM services
ORDER BY display_order ASC;

-- name: ReorderServices :exec
UPDATE services
SET display_order = ?
WHERE id = ?;

-- name: UpdateService :exec
UPDATE services
SET name = ?, description = ?
WHERE id = ?;

-- name: DeleteService :exec
DELETE FROM services
WHERE id = ?;
