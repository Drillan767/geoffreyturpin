package models

type CreateUserRequest struct {
	Email    string
	Password string
	Name     string
}

type LoginUserRequest struct {
	Email    string `json:"email" binding:"required,email"`
	Password string `json:"password" binding:"required"`
}

type UpdateUserInfoRequest struct {
	Email    string `json:"email" binding:"required,email"`
	Password string `json:"password" binding:"required,min=8,max=72"`
	Name     string `json:"name" binding:"required,min=2,max=100"`
}

type UpdateUserDetailsRequest struct {
	Biography string `json:"biography" binding:"min=20"`
	// Image handled separately
}
