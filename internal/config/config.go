package config

import (
	"os"
	"strings"
	"time"
)

type Config struct {
	Environment    string
	ServerPort     string
	DatabaseURL    string
	DatabaseDriver string
	AllowedOrigin  []string

	JWTSecret   string
	JWTExpirity time.Duration

	// Email setup would go there
}

func Load() *Config {
	jwtExpirity := os.Getenv("JWT_EXPIRY")

	if jwtExpirity == "" {
		jwtExpirity = "24h"
	}

	duration, err := time.ParseDuration(jwtExpirity)

	if err != nil {
		// Fallback
		duration = 24 * time.Hour
	}

	return &Config{
		Environment:    getEnv("ENVIRONMENT", "development"),
		ServerPort:     getEnv("SERVER_PORT", "3000"),
		DatabaseURL:    getEnv("DATABASE_URL", "user:password@tcp/geoffreyturpin"),
		DatabaseDriver: getEnv("DATABASE_DRIVER", "mysql"),
		AllowedOrigin:  strings.Split(getEnv("ALLOWED_ORIGINS", ""), " "),

		JWTSecret:   getEnv("JWT_SECRET_TOKEN", ""),
		JWTExpirity: duration,
	}
}

func getEnv(key, defaultValue string) string {
	value := os.Getenv(key)

	if value == "" {
		return defaultValue
	}

	return value
}
