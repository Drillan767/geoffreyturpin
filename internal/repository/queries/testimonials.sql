-- name: CreateTestimonial :exec
INSERT INTO testimonials (client_name, client_occupation, testimonial_text, display_order)
VALUES (?, ?, ?, ?);

-- name: GetTestimonial :one
SELECT * FROM testimonials
WHERE id = ?;

-- name: ListTestimonials :many
SELECT * FROM testimonials
ORDER BY display_order ASC;

-- name: CountTestimonials :one
SELECT COUNT(*) from testimonials;

-- name: UpdateTestimonialOrder :exec
UPDATE testimonials
SET display_order = ?, updated_at = NOW()
WHERE id = ?;

-- name: UpdateTestimonial :exec
UPDATE testimonials
SET client_name = ?, client_occupation = ?, testimonial_text = ?, updated_at = NOW()
WHERE id = ?;

-- name: DeleteTestimonial :exec
DELETE FROM testimonials
WHERE id = ?;
