package models

type CreateBiographyItem struct {
	Title string `json:"title" binding:"required,min=4,max=4"`
	Text  string `json:"password" binding:"required,min=10"`
}

type UpdateBiographyItem struct {
	Id    int    `json:"id" binding:"required"`
	Title string `json:"title" binding:"required,min=4,max=4"`
	Text  string `json:"password" binding:"required,min=10"`
}

type DeleteBiographyItem struct {
	Id int `json:"id" binding:"required"`
}
