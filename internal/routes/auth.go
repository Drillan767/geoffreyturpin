package routes

import (
	"database/sql"
	"net/http"

	"geoffreyturpin/internal/config"
	"geoffreyturpin/internal/handlers"
	"geoffreyturpin/internal/middlewares"

	"github.com/gin-gonic/gin"
)

func RegisterAuthRoutes(router *gin.RouterGroup, cfg *config.Config, db *sql.DB) {
	authHandler := handlers.NewAuthHandler(db, cfg)

	router.POST("/login", authHandler.Login)

	protected := router.Group("/")
	protected.Use(middlewares.RequireAuth(cfg))

	// get profile, log out, update password, etc
	protected.GET("/test", func(c *gin.Context) {
		userId, _ := c.Get("userId")
		email, _ := c.Get("email")
		c.JSON(http.StatusOK, gin.H{
			"message": "You're authenticated!",
			"userId":  userId,
			"email":   email,
		})
	})
}
