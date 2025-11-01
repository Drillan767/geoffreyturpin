-- name: CreateProject :execresult
INSERT INTO projects (title, project_type, short_description, description, audio_url, project_date)
VALUES (?, ?, ?, ?, ?, ?);

-- name: GetProject :one
SELECT * FROM projects
WHERE id = ?;

-- name: ListProjects :many
SELECT * FROM projects
ORDER BY project_date DESC;

-- name: ListProjectsByType :many
SELECT * FROM projects
WHERE project_type = ?
ORDER BY project_date DESC;

-- name: UpdateProject :exec
UPDATE projects
SET title = ?, project_type = ?, short_description = ?, description = ?, audio_url = ?, project_date = ?
WHERE id = ?;

-- name: DeleteProject :exec
DELETE FROM projects
WHERE id = ?;
