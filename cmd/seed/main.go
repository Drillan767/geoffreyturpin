package main

import (
	"context"
	"log"
	"os"

	"geoffreyturpin/internal/config"
	database "geoffreyturpin/internal/database"
	repository "geoffreyturpin/internal/repository/generated"

	"github.com/joho/godotenv"
	"golang.org/x/crypto/bcrypt"
)

func main() {
	if err := godotenv.Load(); err != nil {
		log.Fatal("Could not load .env file!!")
	}

	cfg := config.Load()

	if cfg.DatabaseURL == "" {
		log.Fatal("DATABASE_URL is required")
	}

	adminDefaultPwd := os.Getenv("ADMIN_DEFAULT_PASSWORD")
	devDefaultPwd := os.Getenv("DEV_DEFAULT_PASSWORD")

	adminPassword, err := bcrypt.GenerateFromPassword([]byte(adminDefaultPwd), bcrypt.DefaultCost)
	devPassword, err2 := bcrypt.GenerateFromPassword([]byte(devDefaultPwd), bcrypt.DefaultCost)

	if err != nil || err2 != nil {
		log.Fatal(err, err2)
	}

	adminUser := repository.CreateUserParams{
		Name:     "Geoffrey Turpin",
		Email:    "gufre@gmail.com",
		Password: string(adminPassword),
	}

	devUser := repository.CreateUserParams{
		Name:     "Geoffrey Turpin",
		Email:    "dev@gmail.com",
		Password: string(devPassword),
	}

	db, err := database.DBClient(cfg.DatabaseDriver, cfg.DatabaseURL)

	if err != nil {
		log.Fatal("Error connecting to the database ", err)
	}

	defer db.Close()

	queries := repository.New(db)

	_, adminError := queries.CreateUser(context.Background(), adminUser)

	_, devError := queries.CreateUser(context.Background(), devUser)

	if adminError != nil || devError != nil {
		log.Fatal(adminError, devError)
	}

	log.Println("Users created successfully ")
}
