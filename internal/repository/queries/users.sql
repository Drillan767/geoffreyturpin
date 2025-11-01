-- name: CreateUser :execresult
INSERT INTO users (name, email, password, picture, biography)
VALUES (?, ?, ?, ?, ?);

-- name: GetUser :one
SELECT * FROM users
WHERE id = ?;

-- name: GetUserByEmail :one
SELECT * FROM users
WHERE email = ?;

-- name: ListUsers :many
SELECT * FROM users
ORDER BY created_at DESC;

-- name: UpdateUser :exec
UPDATE users
SET name = ?, email = ?, password = ?, picture = ?, biography = ?
WHERE id = ?;

-- name: UpdateUserProfile :exec
UPDATE users
SET name = ?, picture = ?, biography = ?
WHERE id = ?;
