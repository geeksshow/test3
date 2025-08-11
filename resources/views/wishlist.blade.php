<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wishlist - DND COMPUTERS</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);
            color: #fff;
            min-height: 100vh;
        }

        .navbar-custom {
            background: rgba(0, 0, 0, 0.95) !important;
            backdrop-filter: blur(20px);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 193, 7, 0.2);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 2rem;
            color: #fff !important;
            text-decoration: none;
            background: linear-gradient(45deg, #ffc107, #ffb400);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .main-content {
            padding-top: 100px;
            min-height: 100vh;
        }

        .wishlist-header {
            background: rgba(20, 20, 20, 0.95);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .wishlist-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(45deg, #fff, #ffc107);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .wishlist-item {
            background: rgba(20, 20, 20, 0.95);
            border-radius: 20px;
            padding: 1.5rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .wishlist-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(45deg, #ffc107, #ffb400);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .wishlist-item:hover::before {
            transform: scaleX(1);
        }

        .wishlist-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 193, 7, 0.3);
        }

        .item-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 1rem;
        }

        .item-title {
            color: #fff;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .item-brand {
            color: #ffc107;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .item-price {
            color: #ffc107;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .item-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-add-cart {
            background: linear-gradient(45deg, #ffc107, #ffb400);
            color: #000;
            border: none;
            padding: 0.6rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            flex: 1;
            transition: all 0.3s ease;
        }

        .btn-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4);
        }

        .btn-remove {
            background: #dc3545;
            color: #fff;
            border: none;
            padding: 0.6rem;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-remove:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        .empty-wishlist {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(20, 20, 20, 0.95);
            border-radius: 20px;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .empty-wishlist i {
            font-size: 4rem;
            color: #ffc107;
            margin-bottom: 1.5rem;
        }

        .filter-bar {
            background: rgba(20, 20, 20, 0.95);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .filter-select {
            background: rgba(40, 40, 40, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: #fff;
            padding: 0.5rem 1rem;
        }

        .wishlist-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(40, 40, 40, 0.8);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #ffc107;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">DND COMPUTERS</a>
            <div class="navbar-nav d-none d-lg-flex mx-auto">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="/laptops">Laptops</a>
                <a class="nav-link" href="/keyboard">Keyboards</a>
                <a class="nav-link" href="/mouse">Mice</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Header -->
            <div class="wishlist-header">
                <h1 class="wishlist-title">
                    <i class="fas fa-heart text-red-400 mr-3"></i>My Wishlist
                </h1>
                <p class="text-gray-400 text-lg">Save your favorite items for later</p>
            </div>

            <!-- Stats -->
            <div class="wishlist-stats">
                <div class="stat-card">
                    <div class="stat-number">5</div>
                    <div class="stat-label">Total Items</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">$1,250</div>
                    <div class="stat-label">Total Value</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">2</div>
                    <div class="stat-label">On Sale</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">3</div>
                    <div class="stat-label">In Stock</div>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="filter-bar">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <label class="text-yellow-400 font-semibold">Sort by:</label>
                            <select class="filter-select">
                                <option>Recently Added</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                                <option>Name A-Z</option>
                                <option>Brand</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="btn btn-outline-light" onclick="clearWishlist()">
                            <i class="fas fa-trash mr-2"></i>Clear All
                        </button>
                    </div>
                </div>
            </div>

            <!-- Wishlist Items -->
            <div class="wishlist-grid" id="wishlistGrid">
                <!-- Sample Wishlist Items -->
                <div class="wishlist-item">
                    <img src="https://images.pexels.com/photos/205421/pexels-photo-205421.jpeg?auto=compress&cs=tinysrgb&w=400" 
                         alt="MacBook Pro" class="item-image">
                    <div class="item-brand">Apple</div>
                    <h5 class="item-title">MacBook Pro 14-inch M3 Pro</h5>
                    <div class="item-price">$1,999.00</div>
                    <div class="item-actions">
                        <button class="btn-add-cart" onclick="addToCart(1)">
                            <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                        </button>
                        <button class="btn-remove" onclick="removeFromWishlist(1)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="wishlist-item">
                    <img src="https://images.pexels.com/photos/1772123/pexels-photo-1772123.jpeg?auto=compress&cs=tinysrgb&w=400" 
                         alt="Dell XPS" class="item-image">
                    <div class="item-brand">Dell</div>
                    <h5 class="item-title">Dell XPS 13 Plus</h5>
                    <div class="item-price">$1,499.00</div>
                    <div class="item-actions">
                        <button class="btn-add-cart" onclick="addToCart(2)">
                            <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                        </button>
                        <button class="btn-remove" onclick="removeFromWishlist(2)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="wishlist-item">
                    <img src="https://images.pexels.com/photos/2115256/pexels-photo-2115256.jpeg?auto=compress&cs=tinysrgb&w=400" 
                         alt="Gaming Laptop" class="item-image">
                    <div class="item-brand">ASUS</div>
                    <h5 class="item-title">ASUS ROG Zephyrus G14</h5>
                    <div class="item-price">$1,599.00</div>
                    <div class="item-actions">
                        <button class="btn-add-cart" onclick="addToCart(3)">
                            <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                        </button>
                        <button class="btn-remove" onclick="removeFromWishlist(3)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="wishlist-item">
                    <img src="https://images.pexels.com/photos/205421/pexels-photo-205421.jpeg?auto=compress&cs=tinysrgb&w=400" 
                         alt="HP Spectre" class="item-image">
                    <div class="item-brand">HP</div>
                    <h5 class="item-title">HP Spectre x360 14</h5>
                    <div class="item-price">$1,299.00</div>
                    <div class="item-actions">
                        <button class="btn-add-cart" onclick="addToCart(4)">
                            <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                        </button>
                        <button class="btn-remove" onclick="removeFromWishlist(4)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="wishlist-item">
                    <img src="https://images.pexels.com/photos/1772123/pexels-photo-1772123.jpeg?auto=compress&cs=tinysrgb&w=400" 
                         alt="ThinkPad" class="item-image">
                    <div class="item-brand">Lenovo</div>
                    <h5 class="item-title">ThinkPad X1 Carbon</h5>
                    <div class="item-price">$1,699.00</div>
                    <div class="item-actions">
                        <button class="btn-add-cart" onclick="addToCart(5)">
                            <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                        </button>
                        <button class="btn-remove" onclick="removeFromWishlist(5)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Empty State (hidden by default) -->
            <div class="empty-wishlist d-none" id="emptyWishlist">
                <i class="fas fa-heart-broken"></i>
                <h3 class="text-white text-2xl font-bold mb-3">Your wishlist is empty</h3>
                <p class="text-gray-400 mb-4">Start adding items you love to your wishlist!</p>
                <a href="/laptops" class="btn btn-warning">
                    <i class="fas fa-shopping-bag mr-2"></i>Browse Products
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addToCart(itemId) {
            const btn = event.target;
            const originalText = btn.innerHTML;
            
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            btn.disabled = true;

            // Simulate API call
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-check"></i> Added!';
                btn.style.background = '#28a745';
                
                showNotification('Item added to cart successfully!', 'success');
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.background = '';
                    btn.disabled = false;
                }, 2000);
            }, 1000);
        }

        function removeFromWishlist(itemId) {
            if (confirm('Are you sure you want to remove this item from your wishlist?')) {
                const item = event.target.closest('.wishlist-item');
                item.style.transform = 'scale(0)';
                item.style.opacity = '0';
                
                setTimeout(() => {
                    item.remove();
                    updateStats();
                    checkEmptyState();
                }, 300);
                
                showNotification('Item removed from wishlist', 'info');
            }
        }

        function clearWishlist() {
            if (confirm('Are you sure you want to clear your entire wishlist?')) {
                const items = document.querySelectorAll('.wishlist-item');
                items.forEach((item, index) => {
                    setTimeout(() => {
                        item.style.transform = 'scale(0)';
                        item.style.opacity = '0';
                        setTimeout(() => item.remove(), 300);
                    }, index * 100);
                });
                
                setTimeout(() => {
                    updateStats();
                    checkEmptyState();
                }, items.length * 100 + 300);
                
                showNotification('Wishlist cleared', 'info');
            }
        }

        function updateStats() {
            const items = document.querySelectorAll('.wishlist-item');
            const totalItems = items.length;
            
            // Update stats (simplified)
            document.querySelector('.stat-number').textContent = totalItems;
        }

        function checkEmptyState() {
            const items = document.querySelectorAll('.wishlist-item');
            const emptyState = document.getElementById('emptyWishlist');
            const grid = document.getElementById('wishlistGrid');
            
            if (items.length === 0) {
                grid.classList.add('d-none');
                emptyState.classList.remove('d-none');
            }
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} position-fixed`;
            notification.style.cssText = 'top: 100px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }
    </script>
</body>
</html>