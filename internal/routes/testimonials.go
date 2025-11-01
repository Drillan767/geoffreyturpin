package routes

import (
	"database/sql"
	"geoffreyturpin/internal/config"
	"geoffreyturpin/internal/handlers"
	"geoffreyturpin/internal/middlewares"

	"github.com/gin-gonic/gin"
)

func RegisterTestimonialRoutes(router *gin.RouterGroup, cfg *config.Config, db *sql.DB) {
	testimonialHandler := handlers.NewTestimonialHandler(db)

	group := router.Group("/testimonials")
	group.GET("", testimonialHandler.ListTestimonials)

	protected := group.Group("")
	protected.Use(middlewares.RequireAuth(cfg))

	protected.POST("", testimonialHandler.Create)
	protected.PUT("/order", testimonialHandler.UpdateOrder)
	protected.PUT("/:id", testimonialHandler.Update)
	protected.DELETE("/:id", testimonialHandler.Delete)
}
