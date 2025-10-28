package main

import (
	"log"
	"time"

	"geoffreyturpin/internal/config"
	database "geoffreyturpin/internal/database"
	"geoffreyturpin/internal/routes"

	"github.com/gin-contrib/cors"
	"github.com/gin-gonic/gin"

	"github.com/joho/godotenv"
)

func main() {

	if err := godotenv.Load(); err != nil {
		log.Println("No .env file found")
	}

	cfg := config.Load()

	// Validate critical config
	if cfg.JWTSecret == "" {
		log.Fatal("JWT_SECRET is required")
	}

	if cfg.DatabaseURL == "" {
		log.Fatal("DATABASE_URL is required")
	}

	db, err := database.DBClient(cfg.DatabaseDriver, cfg.DatabaseURL)

	log.Println("DEBUG: DATABASE_URL =", cfg.DatabaseURL) // Add this

	if err != nil {
		log.Fatal("Failed to connect to database: ", err.Error())
	}

	defer db.Close()

	router := gin.New()

	// Configure CORS middleware
	router.Use(cors.New(cors.Config{
		AllowOrigins:     cfg.AllowedOrigin,
		AllowMethods:     []string{"GET", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"},
		AllowHeaders:     []string{"Origin", "Content-Type", "Authorization"},
		ExposeHeaders:    []string{"Content-Length"},
		AllowCredentials: true,
		MaxAge:           12 * time.Hour,
	}))

	routes.RegisterAPIRoutes(router, cfg, db)

	log.Printf("Server starting on %s", cfg.ServerPort)

	router.Run(cfg.ServerPort)
}
