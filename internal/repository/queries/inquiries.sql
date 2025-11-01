-- name: CreateInquiry :execresult
INSERT INTO inquiries (full_name, email, subject, message, is_read)
VALUES (?, ?, ?, ?, ?);

-- name: GetInquiry :one
SELECT * FROM inquiries
WHERE id = ?;

-- name: ListInquiries :many
SELECT * FROM inquiries
ORDER BY id DESC;

-- name: ListUnreadInquiries :many
SELECT * FROM inquiries
WHERE is_read = false
ORDER BY id DESC;

-- name: MarkInquiryAsRead :exec
UPDATE inquiries
SET is_read = true
WHERE id = ?;

-- name: DeleteInquiry :exec
DELETE FROM inquiries
WHERE id = ?;
