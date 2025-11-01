-- name: CreateWorkingProcess :execresult
INSERT INTO working_processes (title, description, step_number)
VALUES (?, ?, ?);

-- name: GetWorkingProcess :one
SELECT * FROM working_processes
WHERE id = ?;

-- name: ListWorkingProcesses :many
SELECT * FROM working_processes
ORDER BY step_number ASC;

-- name: UpdateWorkingProcess :exec
UPDATE working_processes
SET title = ?, description = ?, step_number = ?
WHERE id = ?;

-- name: DeleteWorkingProcess :exec
DELETE FROM working_processes
WHERE id = ?;
