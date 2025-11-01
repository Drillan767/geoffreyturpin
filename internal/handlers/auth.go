package handlers

import (
	"database/sql"
	"geoffreyturpin/internal/repository/models"
	"net/http"
	"time"

	"geoffreyturpin/internal/config"
	repository "geoffreyturpin/internal/repository/generated"

	"github.com/gin-gonic/gin"
	"github.com/golang-jwt/jwt/v5"
	"golang.org/x/crypto/bcrypt"
)

type AuthHandler struct {
	db      *sql.DB
	cfg     *config.Config
	queries *repository.Queries
}

type Claims struct {
	UserId uint32
	Email  string
	jwt.RegisteredClaims
}

// Construct
func NewAuthHandler(db *sql.DB, cfg *config.Config) *AuthHandler {
	return &AuthHandler{
		db:      db,
		cfg:     cfg,
		queries: repository.New(db),
	}
}

func (h *AuthHandler) Login(c *gin.Context) {
	var credentials models.LoginUserRequest

	if err := c.ShouldBindJSON(&credentials); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	existingUser, err := h.queries.GetUserByEmail(c, credentials.Email)

	if err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "Invalid credentials"})
		return
	}

	notMatching := bcrypt.CompareHashAndPassword([]byte(existingUser.Password), []byte(credentials.Password))

	if notMatching != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "Invalid credentials"})
		return
	}

	token, err := h.generateAuthToken(existingUser.ID, existingUser.Email)

	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	c.JSON(http.StatusOK, gin.H{"token": token})
}

func (h *AuthHandler) ListUsers(c *gin.Context) {
	usersList, err := h.queries.ListUsers(c)

	if err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	c.JSON(http.StatusOK, gin.H{"users": usersList})
}

func (h *AuthHandler) generateAuthToken(userId uint32, email string) (string, error) {

	claims := &Claims{
		UserId: userId,
		Email:  email,
		RegisteredClaims: jwt.RegisteredClaims{
			ExpiresAt: jwt.NewNumericDate(time.Now().Add(24 * time.Hour)),
			IssuedAt:  jwt.NewNumericDate(time.Now()),
		},
	}

	token := jwt.NewWithClaims(jwt.SigningMethodHS256, claims)
	tokenString, err := token.SignedString([]byte(h.cfg.JWTSecret))

	if err != nil {
		return "", err
	}

	return tokenString, nil
}
