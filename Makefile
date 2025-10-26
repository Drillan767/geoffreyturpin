include .env

.PHONY: dev migrate-up migrate-down sqlc build-vue

# Run Go server in dev mode
dev:
	go run cmd/api/main.go

# Run Vue dev server
dev-vue:
	cd web && npm run dev

# Run both (requires 'concurrently' npm package or separate terminals)
dev-all:
	make dev & make dev-vue

# Create new migration
migrate-create:
	migrate create -ext sql -dir internal/database/migrations -seq $(name)

# Run migrations
migrate-up:
	migrate -path internal/database/migrations -database "mysql://$(DATABASE_URL)" up

# Rollback migrations
migrate-down:
	migrate -path internal/database/migrations -database "mysql://$(DATABASE_URL)" down 1

# Generate sqlc code
sqlc:
	cd internal/repository && sqlc generate

# Build Vue for production
build-vue:
	cd front && yarn build

# Build everything
build: build-vue
	go build -o bin/api cmd/api/main.go
