package models

type CreateSocialNetworkItem struct {
	Name string `json:"name" binding:"required"`
	Url  string `json:"url" binding:"required"`
	Icon string `json:"icon" binding:"required"`
}

type UpdateSocialNetworkItem struct {
	Id   int    `json:"id" binding:"required"`
	Name string `json:"name" binding:"required"`
	Url  string `json:"url" binding:"required"`
	Icon string `json:"icon" binding:"required"`
}

type DeleteSocialNetworkItem struct {
	Id int `json:"id" binding:"required"`
}
