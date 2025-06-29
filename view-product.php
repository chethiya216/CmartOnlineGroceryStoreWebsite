<?php 
include("config.php");
session_start();
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
} else {
    $user_id = null;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product View - Premium Wireless Headphones</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

:root {
  --primary-color: #2c3e50;
  --secondary-color: #3498db;
  --accent-color: #e74c3c;
  --success-color: #27ae60;
  --warning-color: #f39c12;
  --light-gray: #ecf0f1;
  --dark-gray: #7f8c8d;
  --text-color: #2c3e50;
  --border-color: #bdc3c7;
  --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  --shadow-hover: 0 5px 20px rgba(0, 0, 0, 0.15);
  --transition: all 0.3s ease;
}

body {
  font-family: "Poppins", sans-serif;
  line-height: 1.6;
  color: var(--text-color);
  background-color: #fff;
  font-size: large;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}



.badge {
  position: absolute;
  top: -8px;
  right: -8px;
  background: var(--accent-color);
  color: white;
  border-radius: 50%;
  width: 18px;
  height: 18px;
  font-size: 0.7rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.mobile-menu-toggle {
  display: none;
  font-size: 1.5rem;
  cursor: pointer;
}

/* Breadcrumb */
.breadcrumb {
  background: var(--light-gray);
  padding: 1rem 0;
}

.breadcrumb .container {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.9rem;
}

.breadcrumb-link {
  color: var(--dark-gray);
  text-decoration: none;
  transition: var(--transition);
}

.breadcrumb-link:hover {
  color: var(--secondary-color);
}

.breadcrumb-current {
  color: var(--text-color);
  font-weight: 500;
}

/* Main Product Section */
.product-main {
  padding: 2rem 0;
}

.product-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3rem;
  margin-bottom: 3rem;
}

/* Product Images */
.product-images {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.main-image {
  position: relative;
  background: var(--light-gray);
  border-radius: 12px;
  overflow: hidden;
  aspect-ratio: 1;
}

.main-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: var(--transition);
}

.main-image:hover img {
  transform: scale(1.05);
}

.image-badges {
  position: absolute;
  top: 1rem;
  left: 1rem;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.badge-new,
.badge-sale {
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
  color: white;
}

.badge-new {
  background: var(--success-color);
}

.badge-sale {
  background: var(--accent-color);
}

.zoom-icon {
  position: absolute;
  top: 1rem;
  right: 1rem;
  width: 40px;
  height: 40px;
  background: rgba(255, 255, 255, 0.9);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  opacity: 0;
  transition: var(--transition);
}

.main-image:hover .zoom-icon {
  opacity: 1;
}

.thumbnail-images {
  display: flex;
  gap: 0.5rem;
  overflow-x: auto;
}

.thumbnail {
  flex-shrink: 0;
  width: 80px;
  height: 80px;
  border-radius: 8px;
  overflow: hidden;
  cursor: pointer;
  border: 2px solid transparent;
  transition: var(--transition);
}

.thumbnail.active {
  border-color: var(--secondary-color);
}

.thumbnail img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Product Details */
.product-details {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.product-title {
  font-size: 2rem;
  font-weight: 600;
  line-height: 1.3;
  margin-bottom: 0.5rem;
}

.product-rating {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.stars {
  display: flex;
  gap: 0.2rem;
  color: var(--warning-color);
}

.rating-text {
  color: var(--dark-gray);
  font-size: 0.9rem;
}

.product-price {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin: 1rem 0;
}

.current-price {
  font-size: 2rem;
  font-weight: 700;
  color: var(--accent-color);
}

.original-price {
  font-size: 1.2rem;
  color: var(--dark-gray);
  text-decoration: line-through;
}

.discount {
  background: var(--success-color);
  color: white;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.9rem;
  font-weight: 600;
}

.product-description {
  color: var(--dark-gray);
  line-height: 1.7;
}

/* Product Options */
.product-options {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.option-group {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.option-label {
  font-weight: 600;
  color: var(--text-color);
}

.color-options {
  display: flex;
  gap: 0.75rem;
}

.color-option {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  cursor: pointer;
  border: 3px solid transparent;
  transition: var(--transition);
  position: relative;
}

.color-option.active {
  border-color: var(--secondary-color);
  transform: scale(1.1);
}

.color-option[style*="white"] {
  border: 3px solid var(--border-color);
}

.size-options {
  display: flex;
  gap: 0.75rem;
}

.size-option {
  padding: 0.75rem 1.5rem;
  border: 2px solid var(--border-color);
  border-radius: 8px;
  cursor: pointer;
  transition: var(--transition);
  font-weight: 500;
}

.size-option.active,
.size-option:hover {
  border-color: var(--secondary-color);
  background: var(--secondary-color);
  color: white;
}

.quantity-selector {
  display: flex;
  align-items: center;
  width: fit-content;
  border: 2px solid var(--border-color);
  border-radius: 8px;
  overflow: hidden;
}

.quantity-btn {
  background: none;
  border: none;
  padding: 0.75rem 1rem;
  cursor: pointer;
  font-size: 1.2rem;
  font-weight: 600;
  transition: var(--transition);
}

.quantity-btn:hover {
  background: var(--light-gray);
}

.quantity-input {
  border: none;
  padding: 0.75rem;
  width: 60px;
  text-align: center;
  font-weight: 600;
  border-left: 1px solid var(--border-color);
  border-right: 1px solid var(--border-color);
}

/* Action Buttons */
.product-actions {
  display: flex;
  gap: 1rem;
  margin-top: 1rem;
}

.btn {
  padding: 1rem 2rem;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
  display: flex;
  align-items: center;
  gap: 0.5rem;
  text-decoration: none;
  justify-content: center;
}

.btn-primary {
  background: var(--secondary-color);
  color: white;
  flex: 1;
}

.btn-primary:hover {
  background: #2980b9;
  transform: translateY(-2px);
  box-shadow: var(--shadow-hover);
}

.btn-secondary {
  background: var(--primary-color);
  color: white;
  flex: 1;
}

.btn-secondary:hover {
  background: #1a252f;
  transform: translateY(-2px);
  box-shadow: var(--shadow-hover);
}

.btn-wishlist {
  background: white;
  color: var(--accent-color);
  border: 2px solid var(--accent-color);
  width: 60px;
  padding: 1rem;
}

.btn-wishlist:hover {
  background: var(--accent-color);
  color: white;
  transform: translateY(-2px);
}

/* Product Features */
.product-features {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
  margin-top: 2rem;
  padding-top: 2rem;
  border-top: 1px solid var(--border-color);
}

.feature {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.feature i {
  font-size: 1.5rem;
  color: var(--secondary-color);
}

.feature-text {
  display: flex;
  flex-direction: column;
}

.feature-text strong {
  font-weight: 600;
  margin-bottom: 0.25rem;
}

.feature-text span {
  color: var(--dark-gray);
  font-size: 0.9rem;
}

/* Product Tabs */
.product-tabs {
  margin-top: 3rem;
}

.tab-navigation {
  display: flex;
  border-bottom: 2px solid var(--light-gray);
  margin-bottom: 2rem;
}

.tab-btn {
  background: none;
  border: none;
  padding: 1rem 2rem;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  color: var(--dark-gray);
  border-bottom: 3px solid transparent;
  transition: var(--transition);
}

.tab-btn.active,
.tab-btn:hover {
  color: var(--secondary-color);
  border-bottom-color: var(--secondary-color);
}

.tab-panel {
  display: none;
  animation: fadeIn 0.3s ease;
}

.tab-panel.active {
  display: block;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.tab-panel h3 {
  margin-bottom: 1rem;
  color: var(--primary-color);
}

.tab-panel h4 {
  margin: 1.5rem 0 0.75rem;
  color: var(--primary-color);
}

.tab-panel ul {
  list-style: none;
  padding-left: 0;
}

.tab-panel li {
  padding: 0.5rem 0;
  border-bottom: 1px solid var(--light-gray);
}

.tab-panel li:last-child {
  border-bottom: none;
}

/* Specifications */
.specs-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1rem;
}

.spec-item {
  display: flex;
  justify-content: space-between;
  padding: 1rem;
  background: var(--light-gray);
  border-radius: 8px;
}

.spec-label {
  font-weight: 600;
  color: var(--text-color);
}

.spec-value {
  color: var(--dark-gray);
}

/* Reviews */
.reviews-summary {
  margin-bottom: 2rem;
}

.rating-overview {
  display: grid;
  grid-template-columns: 1fr 2fr;
  gap: 2rem;
  padding: 2rem;
  background: var(--light-gray);
  border-radius: 12px;
}

.overall-rating {
  text-align: center;
}

.rating-number {
  font-size: 3rem;
  font-weight: 700;
  color: var(--warning-color);
  display: block;
}

.rating-stars {
  margin: 0.5rem 0;
  color: var(--warning-color);
}

.rating-count {
  color: var(--dark-gray);
  font-size: 0.9rem;
}

.rating-breakdown {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.rating-bar {
  display: flex;
  align-items: center;
  gap: 1rem;
  font-size: 0.9rem;
}

.rating-bar span:first-child {
  width: 60px;
  color: var(--dark-gray);
}

.bar {
  flex: 1;
  height: 8px;
  background: #ddd;
  border-radius: 4px;
  overflow: hidden;
}

.fill {
  height: 100%;
  background: var(--warning-color);
  transition: width 0.3s ease;
}

.rating-bar span:last-child {
  width: 40px;
  text-align: right;
  color: var(--dark-gray);
}

.reviews-list {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.review-item {
  padding: 2rem;
  border: 1px solid var(--border-color);
  border-radius: 12px;
}

.review-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.reviewer-info {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.reviewer-avatar {
  width: 50px;
  height: 50px;
  background: var(--secondary-color);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
}

.reviewer-name {
  font-weight: 600;
  margin-bottom: 0.25rem;
  display: block;
}

.review-rating {
  color: var(--warning-color);
}

.review-date {
  color: var(--dark-gray);
  font-size: 0.9rem;
}

.review-content h4 {
  margin-bottom: 0.5rem;
  color: var(--primary-color);
}

.review-actions {
  display: flex;
  gap: 1rem;
  margin-top: 1rem;
}

.review-action {
  background: none;
  border: none;
  color: var(--dark-gray);
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.9rem;
  transition: var(--transition);
}

.review-action:hover {
  color: var(--secondary-color);
}

/* Shipping Info */
.shipping-info {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
}

.info-section {
  padding: 2rem;
  background: var(--light-gray);
  border-radius: 12px;
}

.info-section h4 {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1rem;
  color: var(--primary-color);
}

.info-section ul {
  list-style: none;
}

.info-section li {
  padding: 0.5rem 0;
  border-bottom: 1px solid #ddd;
}

.info-section li:last-child {
  border-bottom: none;
}

/* Related Products */
.related-products {
  margin-top: 4rem;
}

.related-products h2 {
  margin-bottom: 2rem;
  text-align: center;
  color: var(--primary-color);
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
}

.product-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: var(--shadow);
  transition: var(--transition);
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-hover);
}

.product-image {
  position: relative;
  aspect-ratio: 1;
  overflow: hidden;
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: var(--transition);
}

.product-card:hover .product-image img {
  transform: scale(1.1);
}

.product-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: var(--transition);
}

.product-card:hover .product-overlay {
  opacity: 1;
}

.quick-view {
  background: white;
  color: var(--primary-color);
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 25px;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
}

.quick-view:hover {
  background: var(--secondary-color);
  color: white;
}

.product-info {
  padding: 1.5rem;
}

.product-info h3 {
  margin-bottom: 0.5rem;
  font-size: 1.1rem;
  color: var(--primary-color);
}

.product-info .product-rating {
  margin-bottom: 0.75rem;
}

.product-info .product-rating span {
  font-size: 0.8rem;
}

.product-info .product-price {
  margin: 0;
}

.product-info .current-price {
  font-size: 1.2rem;
}

.product-info .original-price {
  font-size: 1rem;
}

.payment-methods {
  display: flex;
  gap: 1rem;
  font-size: 1.5rem;
}

.payment-methods i {
  color: #bdc3c7;
}

/* Responsive Design */
@media (max-width: 768px) {
  .nav-links {
    display: none;
  }

  .mobile-menu-toggle {
    display: block;
  }

  .product-container {
    grid-template-columns: 1fr;
    gap: 2rem;
  }

  .product-title {
    font-size: 1.5rem;
  }

  .current-price {
    font-size: 1.5rem;
  }

  .product-actions {
    flex-direction: column;
  }

  .btn-wishlist {
    width: 100%;
  }

  .product-features {
    grid-template-columns: 1fr;
  }

  .tab-navigation {
    overflow-x: auto;
  }

  .tab-btn {
    white-space: nowrap;
    padding: 1rem 1.5rem;
  }

  .rating-overview {
    grid-template-columns: 1fr;
    text-align: center;
  }

  .products-grid {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
  }

  .footer-bottom {
    flex-direction: column;
    gap: 1rem;
    text-align: center;
  }
}

@media (max-width: 480px) {
  .container {
    padding: 0 15px;
  }

  .nav-container {
    padding: 1rem 15px;
  }

  .product-main {
    padding: 1rem 0;
  }

  .product-container {
    gap: 1.5rem;
  }

  .color-options,
  .size-options {
    flex-wrap: wrap;
  }

  .specs-grid {
    grid-template-columns: 1fr;
  }

  .shipping-info {
    grid-template-columns: 1fr;
  }

  .products-grid {
    grid-template-columns: 1fr;
  }
}

    </style>
</head>
    <?php include 'header.php'; ?>

    <!-- Breadcrumb -->
    <!-- <div class="breadcrumb">
        <div class="container">
            <a href="#" class="breadcrumb-link">Home</a>
            <i class="fas fa-chevron-right"></i>
            <a href="#" class="breadcrumb-link">Electronics</a>
            <i class="fas fa-chevron-right"></i>
            <a href="#" class="breadcrumb-link">Audio</a>
            <i class="fas fa-chevron-right"></i>
            <span class="breadcrumb-current">Wireless Headphones</span>
        </div>
    </div> -->

    <!-- Main Product Section -->
    <main class="product-main">
        <div class="container">
            <div class="product-container">
                <!-- Product Images -->
                <div class="product-images">
                    <div class="main-image">
                        <img src="/placeholder.svg?height=500&width=500" alt="Premium Wireless Headphones" id="mainImage">
                    </div>
                    
                </div>

                <!-- Product Details -->
                <div class="product-details">
                    <div class="product-header">
                        <h1 class="product-title">Premium Wireless Noise-Cancelling Headphones</h1>
                        <div class="product-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-text">(4.5) 2,847 reviews</span>
                        </div>
                    </div>

                    <div class="product-price">
                        <span class="current-price">$199.99</span>
                    </div>

                    <div class="product-description">
                        <p>Experience premium sound quality with our latest wireless noise-cancelling headphones. Featuring advanced ANC technology, 30-hour battery life, and premium comfort padding for all-day listening.</p>
                    </div>

                    <!-- Product Options -->
                    <div class="product-options">
                        <div class="option-group">
                            <label class="option-label">Variation:</label>
                            <div class="size-options">
                                <div class="size-option active">Small</div>
                                <div class="size-option">Medium</div>
                                <div class="size-option">Large</div>
                            </div>
                        </div>

                        <div class="option-group">
                            <label class="option-label">Quantity:</label>
                            <div class="quantity-selector">
                                <button class="quantity-btn minus">-</button>
                                <input type="number" class="quantity-input" value="1" min="1" max="10">
                                <button class="quantity-btn plus">+</button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="product-actions">
                        <button class="btn btn-primary add-to-cart">
                            <i class="fas fa-shopping-cart"></i>
                            Add to Cart
                        </button>
                        <button class="btn btn-secondary buy-now">
                            <i class="fas fa-bolt"></i>
                            Buy Now
                        </button>
                    </div>

                </div>
            </div>

            <!-- Product Tabs -->
            <div class="product-tabs">
                <div class="tab-navigation">
                    <button class="tab-btn" data-tab="reviews">Reviews (2,847)</button>
                </div>

                <div class="tab-content">
                    <div class="tab-panel active" id="reviews">
                        <h3>Customer Reviews</h3>
                        <div class="reviews-summary">
                            <div class="rating-overview">
                                <div class="overall-rating">
                                    <span class="rating-number">4.5</span>
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="rating-count">Based on 2,847 reviews</span>
                                </div>
                                <div class="rating-breakdown">
                                    <div class="rating-bar">
                                        <span>5 stars</span>
                                        <div class="bar"><div class="fill" style="width: 65%"></div></div>
                                        <span>65%</span>
                                    </div>
                                    <div class="rating-bar">
                                        <span>4 stars</span>
                                        <div class="bar"><div class="fill" style="width: 25%"></div></div>
                                        <span>25%</span>
                                    </div>
                                    <div class="rating-bar">
                                        <span>3 stars</span>
                                        <div class="bar"><div class="fill" style="width: 7%"></div></div>
                                        <span>7%</span>
                                    </div>
                                    <div class="rating-bar">
                                        <span>2 stars</span>
                                        <div class="bar"><div class="fill" style="width: 2%"></div></div>
                                        <span>2%</span>
                                    </div>
                                    <div class="rating-bar">
                                        <span>1 star</span>
                                        <div class="bar"><div class="fill" style="width: 1%"></div></div>
                                        <span>1%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="reviews-list">
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="reviewer-info">
                                        <div class="reviewer-avatar">JD</div>
                                        <div class="reviewer-details">
                                            <span class="reviewer-name">John Doe</span>
                                            <div class="review-rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="review-date">2 days ago</span>
                                </div>
                                <div class="review-content">
                                    <h4>Excellent sound quality!</h4>
                                    <p>These headphones exceeded my expectations. The noise cancellation is fantastic, and the sound quality is crystal clear. Battery life is exactly as advertised. Highly recommend!</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
     <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>
    <script>
        // DOM Elements
const thumbnails = document.querySelectorAll(".thumbnail")
const mainImage = document.getElementById("mainImage")
const colorOptions = document.querySelectorAll(".color-option")
const sizeOptions = document.querySelectorAll(".size-option")
const quantityInput = document.querySelector(".quantity-input")
const quantityBtns = document.querySelectorAll(".quantity-btn")
const tabBtns = document.querySelectorAll(".tab-btn")
const tabPanels = document.querySelectorAll(".tab-panel")
const addToCartBtn = document.querySelector(".add-to-cart")
const buyNowBtn = document.querySelector(".buy-now")
const wishlistBtn = document.querySelector(".btn-wishlist")

// Image Gallery
thumbnails.forEach((thumbnail, index) => {
  thumbnail.addEventListener("click", () => {
    // Remove active class from all thumbnails
    thumbnails.forEach((thumb) => thumb.classList.remove("active"))

    // Add active class to clicked thumbnail
    thumbnail.classList.add("active")

    // Update main image
    const newImageSrc = thumbnail.querySelector("img").src
    mainImage.src = newImageSrc

    // Add animation effect
    mainImage.style.opacity = "0"
    setTimeout(() => {
      mainImage.style.opacity = "1"
    }, 150)
  })
})

// Color Selection
colorOptions.forEach((option) => {
  option.addEventListener("click", () => {
    colorOptions.forEach((opt) => opt.classList.remove("active"))
    option.classList.add("active")

    // Add selection animation
    option.style.transform = "scale(0.9)"
    setTimeout(() => {
      option.style.transform = "scale(1.1)"
    }, 100)
  })
})

// Size Selection
sizeOptions.forEach((option) => {
  option.addEventListener("click", () => {
    sizeOptions.forEach((opt) => opt.classList.remove("active"))
    option.classList.add("active")

    // Add selection animation
    option.style.transform = "scale(0.95)"
    setTimeout(() => {
      option.style.transform = "scale(1)"
    }, 150)
  })
})

// Quantity Controls
quantityBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    const isPlus = btn.classList.contains("plus")
    const currentValue = Number.parseInt(quantityInput.value)
    const min = Number.parseInt(quantityInput.min)
    const max = Number.parseInt(quantityInput.max)

    if (isPlus && currentValue < max) {
      quantityInput.value = currentValue + 1
    } else if (!isPlus && currentValue > min) {
      quantityInput.value = currentValue - 1
    }

    // Add button animation
    btn.style.transform = "scale(0.9)"
    setTimeout(() => {
      btn.style.transform = "scale(1)"
    }, 100)
  })
})

// Quantity Input Validation
quantityInput.addEventListener("input", () => {
  const min = Number.parseInt(quantityInput.min)
  const max = Number.parseInt(quantityInput.max)
  const value = Number.parseInt(quantityInput.value)

  if (value < min) quantityInput.value = min
  if (value > max) quantityInput.value = max
})

// Product Tabs
tabBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    const targetTab = btn.dataset.tab

    // Remove active class from all tabs and panels
    tabBtns.forEach((tab) => tab.classList.remove("active"))
    tabPanels.forEach((panel) => panel.classList.remove("active"))

    // Add active class to clicked tab and corresponding panel
    btn.classList.add("active")
    document.getElementById(targetTab).classList.add("active")

    // Smooth scroll to tabs section
    document.querySelector(".product-tabs").scrollIntoView({
      behavior: "smooth",
      block: "start",
    })
  })
})

// Add to Cart Animation
addToCartBtn.addEventListener("click", (e) => {
  e.preventDefault()

  // Get selected options
  const selectedColor = document.querySelector(".color-option.active").dataset.color
  const selectedSize = document.querySelector(".size-option.active").textContent
  const quantity = quantityInput.value

  // Create cart item object
  const cartItem = {
    name: document.querySelector(".product-title").textContent,
    price: document.querySelector(".current-price").textContent,
    color: selectedColor,
    size: selectedSize,
    quantity: quantity,
    image: mainImage.src,
  }

  // Add loading state
  addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...'
  addToCartBtn.disabled = true

  // Simulate API call
  setTimeout(() => {
    // Reset button
    addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart'
    addToCartBtn.disabled = false

    // Show success message
    showNotification("Product added to cart successfully!", "success")

    // Update cart badge (simulate)
    const cartBadge = document.querySelector(".nav-icon .badge")
    if (cartBadge) {
      const currentCount = Number.parseInt(cartBadge.textContent)
      cartBadge.textContent = currentCount + Number.parseInt(quantity)

      // Animate badge
      cartBadge.style.transform = "scale(1.5)"
      setTimeout(() => {
        cartBadge.style.transform = "scale(1)"
      }, 200)
    }

    // Add button success animation
    addToCartBtn.style.background = "#27ae60"
    setTimeout(() => {
      addToCartBtn.style.background = ""
    }, 1000)
  }, 1500)
})

// Buy Now Button
buyNowBtn.addEventListener("click", (e) => {
  e.preventDefault()

  // Add loading state
  buyNowBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...'
  buyNowBtn.disabled = true

  // Simulate redirect to checkout
  setTimeout(() => {
    showNotification("Redirecting to checkout...", "info")

    // Reset button after delay
    setTimeout(() => {
      buyNowBtn.innerHTML = '<i class="fas fa-bolt"></i> Buy Now'
      buyNowBtn.disabled = false
    }, 2000)
  }, 1000)
})

// Wishlist Button
wishlistBtn.addEventListener("click", (e) => {
  e.preventDefault()

  const icon = wishlistBtn.querySelector("i")
  const isWishlisted = icon.classList.contains("fas")

  if (isWishlisted) {
    icon.classList.remove("fas")
    icon.classList.add("far")
    wishlistBtn.style.background = "white"
    wishlistBtn.style.color = "#e74c3c"
    showNotification("Removed from wishlist", "info")
  } else {
    icon.classList.remove("far")
    icon.classList.add("fas")
    wishlistBtn.style.background = "#e74c3c"
    wishlistBtn.style.color = "white"
    showNotification("Added to wishlist!", "success")

    // Update wishlist badge
    const wishlistBadge = document.querySelector(".nav-icon .badge")
    if (wishlistBadge) {
      const currentCount = Number.parseInt(wishlistBadge.textContent)
      wishlistBadge.textContent = currentCount + 1
    }
  }

  // Add animation
  wishlistBtn.style.transform = "scale(0.9)"
  setTimeout(() => {
    wishlistBtn.style.transform = "scale(1)"
  }, 150)
})

// Image Zoom Effect
const zoomIcon = document.querySelector(".zoom-icon")
zoomIcon.addEventListener("click", () => {
  // Create modal for image zoom
  const modal = document.createElement("div")
  modal.className = "image-modal"
  modal.innerHTML = `
        <div class="modal-backdrop">
            <div class="modal-content">
                <img src="${mainImage.src}" alt="Product Image">
                <button class="close-modal">&times;</button>
            </div>
        </div>
    `

  // Add modal styles
  const modalStyles = `
        .image-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            animation: fadeIn 0.3s ease;
        }
        
        .modal-content {
            position: relative;
            max-width: 90%;
            max-height: 90%;
        }
        
        .modal-content img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .close-modal {
            position: absolute;
            top: -40px;
            right: 0;
            background: none;
            border: none;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    `

  // Add styles to head
  const styleSheet = document.createElement("style")
  styleSheet.textContent = modalStyles
  document.head.appendChild(styleSheet)

  // Add modal to body
  document.body.appendChild(modal)

  // Close modal functionality
  const closeModal = () => {
    modal.remove()
    styleSheet.remove()
  }

  modal.querySelector(".close-modal").addEventListener("click", closeModal)
  modal.querySelector(".modal-backdrop").addEventListener("click", (e) => {
    if (e.target === e.currentTarget) {
      closeModal()
    }
  })

  // Close on escape key
  document.addEventListener("keydown", function escapeHandler(e) {
    if (e.key === "Escape") {
      closeModal()
      document.removeEventListener("keydown", escapeHandler)
    }
  })
})

// Review Actions
document.querySelectorAll(".review-action").forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault()

    const action = btn.textContent.trim().toLowerCase()

    if (action.includes("helpful")) {
      const countSpan = btn.querySelector("span") || btn
      const currentCount = Number.parseInt(countSpan.textContent.match(/\d+/)[0])
      countSpan.textContent = countSpan.textContent.replace(/\d+/, currentCount + 1)

      btn.style.color = "#27ae60"
      showNotification("Thank you for your feedback!", "success")
    } else if (action.includes("reply")) {
      showNotification("Reply feature coming soon!", "info")
    }
  })
})

// Related Products Quick View
document.querySelectorAll(".quick-view").forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault()
    showNotification("Quick view feature coming soon!", "info")
  })
})

// Mobile Menu Toggle
const mobileMenuToggle = document.querySelector(".mobile-menu-toggle")
const navLinks = document.querySelector(".nav-links")

if (mobileMenuToggle) {
  mobileMenuToggle.addEventListener("click", () => {
    navLinks.classList.toggle("active")

    const icon = mobileMenuToggle.querySelector("i")
    if (icon.classList.contains("fa-bars")) {
      icon.classList.remove("fa-bars")
      icon.classList.add("fa-times")
    } else {
      icon.classList.remove("fa-times")
      icon.classList.add("fa-bars")
    }
  })
}

// Smooth Scrolling for Navigation Links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault()
    const target = document.querySelector(this.getAttribute("href"))
    if (target) {
      target.scrollIntoView({
        behavior: "smooth",
        block: "start",
      })
    }
  })
})

// Notification System
function showNotification(message, type = "info") {
  // Remove existing notifications
  const existingNotifications = document.querySelectorAll(".notification")
  existingNotifications.forEach((notification) => notification.remove())

  // Create notification element
  const notification = document.createElement("div")
  notification.className = `notification notification-${type}`
  notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${getNotificationIcon(type)}"></i>
            <span>${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `

  // Add notification styles
  const notificationStyles = `
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            min-width: 300px;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: slideInRight 0.3s ease;
        }
        
        .notification-success {
            background: #27ae60;
            color: white;
        }
        
        .notification-error {
            background: #e74c3c;
            color: white;
        }
        
        .notification-info {
            background: #3498db;
            color: white;
        }
        
        .notification-warning {
            background: #f39c12;
            color: white;
        }
        
        .notification-content {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
        }
        
        .notification-close {
            background: none;
            border: none;
            color: inherit;
            font-size: 1.2rem;
            cursor: pointer;
            margin-left: auto;
            opacity: 0.8;
            transition: opacity 0.2s ease;
        }
        
        .notification-close:hover {
            opacity: 1;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `

  // Add styles if not already added
  if (!document.querySelector("#notification-styles")) {
    const styleSheet = document.createElement("style")
    styleSheet.id = "notification-styles"
    styleSheet.textContent = notificationStyles
    document.head.appendChild(styleSheet)
  }

  // Add notification to body
  document.body.appendChild(notification)

  // Auto remove after 5 seconds
  const autoRemove = setTimeout(() => {
    removeNotification(notification)
  }, 5000)

  // Close button functionality
  notification.querySelector(".notification-close").addEventListener("click", () => {
    clearTimeout(autoRemove)
    removeNotification(notification)
  })
}

function getNotificationIcon(type) {
  switch (type) {
    case "success":
      return "check-circle"
    case "error":
      return "exclamation-circle"
    case "warning":
      return "exclamation-triangle"
    case "info":
    default:
      return "info-circle"
  }
}

function removeNotification(notification) {
  notification.style.animation = "slideOutRight 0.3s ease"
  setTimeout(() => {
    if (notification.parentNode) {
      notification.remove()
    }
  }, 300)
}

// Lazy Loading for Images
const images = document.querySelectorAll('img[src*="placeholder"]')
const imageObserver = new IntersectionObserver((entries, observer) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      const img = entry.target
      // In a real application, you would replace this with actual image URLs
      // img.src = img.dataset.src;
      observer.unobserve(img)
    }
  })
})

images.forEach((img) => imageObserver.observe(img))

// Page Load Animation
window.addEventListener("load", () => {
  document.body.classList.add("loaded")

  // Add loaded styles
  const loadedStyles = `
        body {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        body.loaded {
            opacity: 1;
        }
    `

  const styleSheet = document.createElement("style")
  styleSheet.textContent = loadedStyles
  document.head.appendChild(styleSheet)
})

// Initialize page
document.addEventListener("DOMContentLoaded", () => {
  // Set initial quantity
  if (quantityInput) {
    quantityInput.value = 1
  }

  // Show welcome message
  setTimeout(() => {
    showNotification("Welcome to our product page!", "info")
  }, 1000)
})

    </script>
</body>
</html>
