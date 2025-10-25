package main

import (
	"log"

	"github.com/joho/godotenv"
)

func main() {
	// Load env vars

	if err := godotenv.Load(); err != nil {
		log.Println("No .env file found")
	}
}
