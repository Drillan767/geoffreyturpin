package routes

import (
	"database/sql"
	"geoffreyturpin/internal/config"

	"github.com/gin-gonic/gin"
)

func RegisterAPIRoutes(router *gin.Engine, cfg *config.Config, db *sql.DB) {
	api := router.Group("/api")

	RegisterAuthRoutes(api, cfg, db)
	RegisterTestimonialRoutes(api, cfg, db)
}
