package handlers

import (
	"database/sql"
	repository "geoffreyturpin/internal/repository/generated"
	"geoffreyturpin/internal/repository/models"
	"net/http"
	"strconv"

	"github.com/gin-gonic/gin"
)

type TestimonialHandler struct {
	db      *sql.DB
	queries *repository.Queries
}

func NewTestimonialHandler(db *sql.DB) *TestimonialHandler {
	return &TestimonialHandler{
		db:      db,
		queries: repository.New(db),
	}
}

func (h *TestimonialHandler) ListTestimonials(c *gin.Context) {
	testimonials, err := h.queries.ListTestimonials(c)

	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	c.JSON(http.StatusOK, gin.H{"data": testimonials})
}

func (h *TestimonialHandler) Create(c *gin.Context) {
	var testimonial models.TestimonialRequest

	if err := c.ShouldBindJSON(&testimonial); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	// Get total of testimonials
	totalRows, err := h.queries.CountTestimonials(c)

	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	newTestimonial := repository.CreateTestimonialParams{
		ClientName:       testimonial.ClientName,
		ClientOccupation: testimonial.ClientOccupation,
		DisplayOrder:     int32(totalRows + 1),
	}

	if err := h.queries.CreateTestimonial(c, newTestimonial); err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	c.JSON(http.StatusCreated, nil)
}

func (h *TestimonialHandler) Update(c *gin.Context) {
	var testimonial models.TestimonialRequest

	idStr := c.Param("id")

	id, err := strconv.ParseUint(idStr, 10, 32)

	if err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	if err := c.ShouldBindJSON(&testimonial); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	updatedTestimonial := repository.UpdateTestimonialParams{
		ID:               uint32(id),
		ClientName:       testimonial.ClientName,
		ClientOccupation: testimonial.ClientOccupation,
		TestimonialText:  testimonial.TestimonialText,
	}

	if err := h.queries.UpdateTestimonial(c, updatedTestimonial); err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	c.JSON(http.StatusNoContent, nil)
}

func (h *TestimonialHandler) UpdateOrder(c *gin.Context) {
	var order []models.UpdateTestimonialDisplayOrderRequest

	if err := c.ShouldBindJSON(&order); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	// Begin transaction
	tx, err := h.db.Begin()

	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	txQueries := repository.New(tx)

	for _, item := range order {
		newOrder := repository.UpdateTestimonialOrderParams{
			ID:           item.Id,
			DisplayOrder: item.DisplayOrder,
		}

		if err := txQueries.UpdateTestimonialOrder(c, newOrder); err != nil {
			c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
			tx.Rollback()
			return
		}
	}

	// Commit transaction
	if err := tx.Commit(); err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	c.JSON(http.StatusNoContent, nil)
}

func (h *TestimonialHandler) Delete(c *gin.Context) {
	idStr := c.Param("id")

	id, err := strconv.ParseUint(idStr, 10, 32)

	if err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	if err := h.queries.DeleteTestimonial(c, uint32(id)); err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	c.JSON(http.StatusNoContent, nil)
}
