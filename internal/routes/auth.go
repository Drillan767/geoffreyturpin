package routes

import (
	"database/sql"

	"geoffreyturpin/internal/config"
	"geoffreyturpin/internal/handlers"

	"github.com/gin-gonic/gin"
)

func RegisterAuthRoutes(router *gin.RouterGroup, cfg *config.Config, db *sql.DB) {
	authHandler := handlers.NewAuthHandler(db, cfg)

	router.POST("/login", authHandler.Login)
}
