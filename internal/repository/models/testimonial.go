package models

type TestimonialRequest struct {
	ClientName       string `json:"client_name" binding:"required"`
	ClientOccupation string `json:"client_title" binding:"required"`
	TestimonialText  string `json:"testimonial_text" binding:"required"`
}

type UpdateTestimonialDisplayOrderRequest struct {
	Id           uint32 `json:"id" binding:"required"`
	DisplayOrder int32  `json:"display_order" binding:"required"`
}
