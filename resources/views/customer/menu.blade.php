<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Algo Coffee - Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
   
    <style>
        :root {
            --primary: #ff6b35;
            --secondary: #ff8c61;
            --accent: #ffb088;
            --dark: #0f1419;
            --gray: #64748b;
            --light-bg: #fafafa;
        }
       
        * { margin: 0; padding: 0; box-sizing: border-box; }
       
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            color: var(--dark);
            background: var(--light-bg);
            padding-bottom: 100px;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }
       
        /* Top Navigation Bar */
        .top-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.06);
            z-index: 1000;
            padding: 0.75rem 1.5rem;
        }
       
        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
       
        .logo-section {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
       
        .logo-placeholder {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            color: white;
            letter-spacing: -0.02em;
        }
       
        .nav-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            font-size: 0.875rem;
            color: var(--gray);
        }
       
        .btn-login {
            background: var(--dark);
            color: white;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-login:hover {
            background: var(--primary);
            transform: scale(1.02);
        }
       
        /* Header */
        .header {
            background: white;
            padding: 6rem 1rem 2rem;
            text-align: center;
            margin-top: 60px;
        }
       
        .header h1 {
            font-family: 'Sora', sans-serif;
            font-size: clamp(2rem, 5vw, 2.75rem);
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
            color: var(--dark);
        }
       
        .header p {
            font-size: 1rem;
            color: var(--gray);
            font-weight: 400;
        }

        .table-info {
            font-size: 0.875rem;
            color: var(--gray);
            margin-top: 0.5rem;
        }

        .table-badge {
            background: #f1f5f9;
            padding: 0.25rem 0.625rem;
            border-radius: 6px;
            font-weight: 600;
            color: var(--dark);
            display: inline-block;
        }
       
        /* Search */
        .search-bar {
            max-width: 500px;
            margin: 1.5rem auto 0;
            position: relative;
        }
       
        .search-bar input {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            background: white;
            color: var(--dark);
            font-size: 0.9375rem;
            transition: all 0.2s;
        }
       
        .search-bar input::placeholder { color: #94a3b8; }
        .search-bar input:focus { 
            outline: none; 
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255,107,53,0.1);
        }
       
        /* Categories */
        .categories {
            position: sticky;
            top: 60px;
            z-index: 100;
            background: rgba(255,255,255,0.98);
            backdrop-filter: blur(12px);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }
       
        .categories-scroll {
            display: flex;
            gap: 0.625rem;
            overflow-x: auto;
            scrollbar-width: none;
            max-width: 1400px;
            margin: 0 auto;
        }
        .categories-scroll::-webkit-scrollbar { display: none; }
       
        .category-btn {
            flex-shrink: 0;
            padding: 0.5rem 1rem;
            border: none;
            background: white;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--gray);
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }
       
        .category-btn:hover {
            background: #f8f9fa;
            color: var(--dark);
        }
       
        .category-btn.active {
            background: var(--dark);
            color: white;
        }
       
        /* Menu Grid */
        .menu-container { max-width: 1400px; margin: 0 auto; padding: 2rem 1.5rem; }
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem; }
       
        /* Menu Card */
        .menu-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.06);
            transition: all 0.25s ease;
        }
        .menu-card:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 12px 24px rgba(0,0,0,0.08);
            border-color: rgba(0,0,0,0.1);
        }
       
        .menu-card-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        }
       
        .menu-card-body { padding: 1rem; }
        .menu-card-title { 
            font-size: 1rem; 
            font-weight: 600; 
            margin-bottom: 0.375rem;
            letter-spacing: -0.01em;
        }
        .menu-card-desc { 
            font-size: 0.8125rem; 
            color: var(--gray); 
            margin-bottom: 0.875rem;
            line-height: 1.5;
        }
       
        .menu-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
        }
       
        .menu-price {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--dark);
            letter-spacing: -0.01em;
        }
       
        .btn-add {
            background: var(--dark);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.8125rem;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .btn-add:hover { 
            background: var(--primary);
            transform: scale(1.02);
        }
       
        /* Floating Mini Cart */
        .floating-cart {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--dark);
            color: white;
            padding: 0.75rem 1.25rem;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            cursor: pointer;
            z-index: 500;
            display: none;
            align-items: center;
            gap: 0.875rem;
            transition: all 0.25s;
            min-width: 160px;
        }
        .floating-cart.show { display: flex; }
        .floating-cart:hover { 
            transform: scale(1.03);
            box-shadow: 0 12px 32px rgba(0,0,0,0.25);
        }
       
        .cart-icon { 
            font-size: 1.5rem;
            line-height: 1;
        }
        .cart-info { 
            text-align: left;
            flex: 1;
        }
        .cart-items { 
            font-size: 0.75rem; 
            opacity: 0.8;
            font-weight: 500;
        }
        .cart-total { 
            font-size: 1rem; 
            font-weight: 700;
            letter-spacing: -0.01em;
        }
       
        /* Cart Modal */
        .cart-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.25s;
        }
        .cart-modal-overlay.show { opacity: 1; visibility: visible; }
       
        .cart-modal {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: white;
            border-radius: 20px 20px 0 0;
            max-height: 85vh;
            overflow-y: auto;
            z-index: 1001;
            transform: translateY(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .cart-modal.show { transform: translateY(0); }
       
        .cart-header {
            background: var(--dark);
            color: white;
            padding: 1.25rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }
       
        .cart-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }
       
        .btn-close-cart {
            background: rgba(255,255,255,0.15);
            border: none;
            color: white;
            width: 36px; 
            height: 36px;
            border-radius: 10px;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-close-cart:hover {
            background: rgba(255,255,255,0.25);
        }
       
        .cart-body { padding: 1.5rem; }
       
        .cart-item {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.875rem;
            display: flex;
            gap: 1rem;
        }
        .cart-item-img {
            width: 70px; 
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
        }
       
        .qty-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: white;
            border-radius: 10px;
            padding: 0.25rem 0.5rem;
            border: 1px solid #e2e8f0;
        }
        .qty-btn {
            width: 28px; 
            height: 28px;
            background: var(--dark);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .qty-btn:hover {
            background: var(--primary);
        }
        
        .qty-display {
            min-width: 28px;
            text-align: center;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .btn-remove {
            background: #fee2e2;
            color: #ef4444;
            border: none;
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-remove:hover {
            background: #fecaca;
        }
       
        /* Customer Name */
        .customer-name-section {
            margin: 1.25rem 0;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
        }
        
        .customer-name-section label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }
        
        .customer-name-section input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.9375rem;
            transition: all 0.2s;
        }
        .customer-name-section input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255,107,53,0.1);
        }
       
        /* Summary & Actions */
        .cart-summary {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.625rem;
            font-size: 0.9375rem;
        }
        .summary-row.total {
            padding-top: 0.875rem;
            border-top: 1.5px solid #e2e8f0;
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0;
        }
        .summary-row.total .value {
            color: var(--primary);
        }
       
        .cart-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.25rem;
        }
        .btn-order, .btn-continue {
            flex: 1;
            padding: 0.875rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9375rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-order {
            background: var(--dark);
            color: white;
        }
        .btn-order:hover {
            background: var(--primary);
            transform: scale(1.02);
        }
        .btn-continue {
            background: white;
            color: var(--dark);
            border: 1.5px solid #e2e8f0;
        }
        .btn-continue:hover {
            border-color: var(--dark);
        }

        /* Payment Modal */
        .payment-section {
            margin: 1.25rem 0;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .payment-section h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .payment-method {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.875rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .payment-method:hover {
            border-color: var(--gray);
        }

        .payment-method.selected {
            border-color: var(--primary);
            background: rgba(255,107,53,0.05);
            color: var(--primary);
        }

        .payment-icon {
            font-size: 1.5rem;
            margin-bottom: 0.375rem;
        }
       
        /* Toast */
        .toast {
            position: fixed;
            top: 80px;
            right: 20px;
            background: var(--dark);
            color: white;
            padding: 0.875rem 1.25rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            z-index: 2000;
            font-weight: 600;
            font-size: 0.875rem;
            opacity: 0;
            transform: translateX(400px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }
       
        @media (max-width: 768px) {
            .top-nav { padding: 0.625rem 1rem; }
            .logo-placeholder { font-size: 1rem; padding: 0.375rem 0.875rem; }
            .nav-info { gap: 1rem; font-size: 0.8125rem; }
            .header { padding: 5rem 1rem 1.5rem; }
            .menu-grid { grid-template-columns: 1fr; gap: 1rem; }
            .floating-cart { 
                right: 50%;
                transform: translateX(50%);
                bottom: 15px;
            }
            .floating-cart:hover {
                transform: translateX(50%) scale(1.03);
            }
            .toast {
                right: 50%;
                transform: translateX(50%) translateY(-100px);
            }
            .toast.show {
                transform: translateX(50%) translateY(0);
            }
            .payment-methods {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>

    <!-- Toast -->
    <div class="toast" id="toast">✓ Ditambahkan ke keranjang</div>
   
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="nav-container">
            <div class="logo-section">
                <div class="logo-placeholder">ALGO COFFEE</div>
            </div>
            <div class="nav-info">
                <button class="btn-login" onclick="handleLogin()">Log In</button>
            </div>
        </div>
    </nav>
   
    <!-- Header -->
    <header class="header">
        <h1>Jelajahi Menu Kami</h1>
        <p>Pilih menu favorit Anda hari ini</p>
        <div class="table-info">
            <span class="table-badge">Meja <span id="tableNumber">1</span></span>
        </div>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Cari menu atau kategori...">
        </div>
    </header>
   
    <!-- Categories -->
    <section class="categories">
        <div class="categories-scroll">
            <button class="category-btn active" data-category="all">Semua</button>
            <button class="category-btn" data-category="minuman">Minuman</button>
            <button class="category-btn" data-category="makanan">Makanan</button>
            <button class="category-btn" data-category="dessert">Dessert</button>
            <button class="category-btn" data-category="snack">Snack</button>
        </div>
    </section>
   
    <!-- Menu Grid -->
    <div class="menu-container">
        <div class="menu-grid" id="menuGrid"></div>
    </div>
   
    <!-- Floating Mini Cart -->
    <div class="floating-cart" id="floatingCart" onclick="openCartModal()">
        <div class="cart-icon">🛒</div>
        <div class="cart-info">
            <div class="cart-items"><span id="miniCartItems">0</span> item</div>
            <div class="cart-total">Rp<span id="miniCartTotal">0</span></div>
        </div>
    </div>
   
    <!-- Cart Modal -->
    <div class="cart-modal-overlay" id="cartOverlay" onclick="closeCartModal()"></div>
    <div class="cart-modal" id="cartModal">
        <div class="cart-header">
            <h2 id="cartTitle">Keranjang Belanja</h2>
            <button class="btn-close-cart" onclick="closeCartModal()">×</button>
        </div>
        <div class="cart-body">
            <div id="cartItems"></div>
           
            <div class="customer-name-section" id="customerNameSection">
                <label>Nama Pembeli</label>
                <input type="text" id="customerName" placeholder="Masukkan nama Anda...">
            </div>

            <div class="payment-section" id="paymentSection" style="display: none;">
                <h3>Metode Pembayaran</h3>
                <div class="payment-methods">
                    <div class="payment-method" data-method="ovo" onclick="selectPayment('ovo')">
                        <div class="payment-icon">💳</div>
                        <div>OVO</div>
                    </div>
                    <div class="payment-method" data-method="gopay" onclick="selectPayment('gopay')">
                        <div class="payment-icon">💰</div>
                        <div>GoPay</div>
                    </div>
                    <div class="payment-method" data-method="dana" onclick="selectPayment('dana')">
                        <div class="payment-icon">💵</div>
                        <div>DANA</div>
                    </div>
                    <div class="payment-method" data-method="shopeepay" onclick="selectPayment('shopeepay')">
                        <div class="payment-icon">🛍️</div>
                        <div>ShopeePay</div>
                    </div>
                    <div class="payment-method" data-method="linkaja" onclick="selectPayment('linkaja')">
                        <div class="payment-icon">🔗</div>
                        <div>LinkAja</div>
                    </div>
                    <div class="payment-method" data-method="cash" onclick="selectPayment('cash')">
                        <div class="payment-icon">💸</div>
                        <div>Tunai</div>
                    </div>
                </div>
            </div>
           
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Total Item</span>
                    <span id="summaryItems">0</span>
                </div>
                <div class="summary-row total">
                    <span>Total Harga</span>
                    <span class="value">Rp <span id="summaryTotal">0</span></span>
                </div>
            </div>
           
            <div class="cart-actions">
                <button class="btn-order" id="btnProceed" onclick="proceedToPayment()">Pembayaran</button>
                <button class="btn-continue" onclick="closeCartModal()">Pilih Lagi</button>
            </div>
        </div>
    </div>

    <script>
        const menuData = [
            { id: 1, name: 'Espresso', category: 'minuman', price: 25000, image: 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=400', desc: 'Kopi espresso pekat dan kaya rasa' },
            { id: 2, name: 'Cappuccino', category: 'minuman', price: 35000, image: 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400', desc: 'Espresso dengan foam susu lembut' },
            { id: 3, name: 'Latte', category: 'minuman', price: 38000, image: 'https://images.unsplash.com/photo-1561882468-9110e03e0f78?w=400', desc: 'Kopi susu dengan latte art cantik' },
            { id: 4, name: 'Americano', category: 'minuman', price: 28000, image: 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=400', desc: 'Espresso dengan air panas' },
            { id: 5, name: 'Nasi Goreng', category: 'makanan', price: 45000, image: 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=400', desc: 'Nasi goreng spesial dengan telur' },
            { id: 6, name: 'Burger', category: 'makanan', price: 55000, image: 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400', desc: 'Burger beef dengan keju leleh' },
            { id: 7, name: 'Pasta Carbonara', category: 'makanan', price: 58000, image: 'https://images.unsplash.com/photo-1612874742237-6526221588e3?w=400', desc: 'Pasta creamy dengan bacon' },
            { id: 8, name: 'Sandwich', category: 'makanan', price: 42000, image: 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=400', desc: 'Sandwich isi ayam dan sayuran' },
            { id: 9, name: 'Cheesecake', category: 'dessert', price: 38000, image: 'https://images.unsplash.com/photo-1524351199678-941a58a3df50?w=400', desc: 'Cheesecake lembut dengan topping' },
            { id: 10, name: 'Tiramisu', category: 'dessert', price: 42000, image: 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=400', desc: 'Tiramisu klasik Italia' },
            { id: 11, name: 'French Fries', category: 'snack', price: 25000, image: 'https://images.unsplash.com/photo-1576107232684-1279f390859f?w=400', desc: 'Kentang goreng renyah' },
            { id: 12, name: 'Chicken Wings', category: 'snack', price: 48000, image: 'https://images.unsplash.com/photo-1608039755401-742074f0548d?w=400', desc: 'Sayap ayam pedas manis' },
        ];

        let cart = {};
        let currentCategory = 'all';
        let selectedPaymentMethod = null;
        let isPaymentMode = false;

        // Get table number from URL
        function getTableNumber() {
            const path = window.location.pathname;
            const match = path.match(/\/meja\/(\d+)/);
            return match ? match[1] : '1';
        }

        function renderMenu() {
            const filtered = currentCategory === 'all' ? menuData : menuData.filter(i => i.category === currentCategory);
            const search = document.getElementById('searchInput').value.toLowerCase();
            const grid = document.getElementById('menuGrid');

            const items = filtered.filter(item => item.name.toLowerCase().includes(search) || item.desc.toLowerCase().includes(search));

            grid.innerHTML = items.map(item => `
                <div class="menu-card">
                    <img src="${item.image}" alt="${item.name}" class="menu-card-img">
                    <div class="menu-card-body">
                        <h3 class="menu-card-title">${item.name}</h3>
                        <p class="menu-card-desc">${item.desc}</p>
                        <div class="menu-card-footer">
                            <div class="menu-price">Rp ${item.price.toLocaleString('id-ID')}</div>
                            <button class="btn-add" onclick="addToCart(${item.id})">
                                + Tambah
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');

            if (items.length === 0) {
                grid.innerHTML = '<p class="text-center col-span-full text-gray-500">Menu tidak ditemukan</p>';
            }
        }

        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentCategory = btn.dataset.category;
                renderMenu();
            });
        });

        document.getElementById('searchInput').addEventListener('input', renderMenu);

        function addToCart(id) {
            const item = menuData.find(m => m.id === id);
            cart[id] = cart[id] ? { ...cart[id], qty: cart[id].qty + 1 } : { ...item, qty: 1 };
            updateCartUI();
            showToast();
        }

        function updateQty(id, change) {
            if (!cart[id]) return;
            cart[id].qty += change;
            if (cart[id].qty <= 0) delete cart[id];
            updateCartUI();
        }

        function removeFromCart(id) {
            delete cart[id];
            updateCartUI();
        }

        function updateCartUI() {
            const items = Object.values(cart);
            const totalItems = items.reduce((s, i) => s + i.qty, 0);
            const totalPrice = items.reduce((s, i) => s + i.price * i.qty, 0);

            // Mini cart
            document.getElementById('miniCartItems').textContent = totalItems;
            document.getElementById('miniCartTotal').textContent = totalPrice.toLocaleString('id-ID');
            document.getElementById('floatingCart').classList.toggle('show', totalItems > 0);

            // Summary
            document.getElementById('summaryItems').textContent = totalItems;
            document.getElementById('summaryTotal').textContent = totalPrice.toLocaleString('id-ID');

            // Cart items
            const container = document.getElementById('cartItems');
            if (totalItems === 0) {
                container.innerHTML = '<p class="text-center text-gray-500 py-8">Keranjang kosong</p>';
            } else {
                container.innerHTML = items.map(item => `
                    <div class="cart-item">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-img">
                        <div class="flex-1">
                            <div class="font-semibold text-sm">${item.name}</div>
                            <div class="text-gray-600" style="font-size: 0.8125rem;">Rp ${item.price.toLocaleString('id-ID')} × ${item.qty}</div>
                            <div class="qty-controls mt-2" style="display: inline-flex;">
                                <button class="qty-btn" onclick="updateQty(${item.id}, -1)">−</button>
                                <span class="qty-display">${item.qty}</span>
                                <button class="qty-btn" onclick="updateQty(${item.id}, 1)">+</button>
                            </div>
                            <button class="btn-remove" onclick="removeFromCart(${item.id})" style="margin-left: 0.5rem;">Hapus</button>
                        </div>
                    </div>
                `).join('');
            }
        }

        function openCartModal() {
            isPaymentMode = false;
            updateModalView();
            document.getElementById('cartOverlay').classList.add('show');
            document.getElementById('cartModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeCartModal() {
            document.getElementById('cartOverlay').classList.remove('show');
            document.getElementById('cartModal').classList.remove('show');
            document.body.style.overflow = '';
            isPaymentMode = false;
            selectedPaymentMethod = null;
            updateModalView();
        }

        function proceedToPayment() {
            const name = document.getElementById('customerName').value.trim();
            if (!name) return alert('Masukkan nama Anda terlebih dahulu!');
            if (Object.keys(cart).length === 0) return alert('Keranjang kosong!');

            isPaymentMode = true;
            updateModalView();
        }

        function updateModalView() {
            const cartTitle = document.getElementById('cartTitle');
            const customerNameSection = document.getElementById('customerNameSection');
            const paymentSection = document.getElementById('paymentSection');
            const btnProceed = document.getElementById('btnProceed');

            if (isPaymentMode) {
                cartTitle.textContent = 'Pembayaran';
                customerNameSection.style.display = 'none';
                paymentSection.style.display = 'block';
                btnProceed.textContent = 'Pesan Sekarang';
                btnProceed.onclick = placeOrder;
            } else {
                cartTitle.textContent = 'Keranjang Belanja';
                customerNameSection.style.display = 'block';
                paymentSection.style.display = 'none';
                btnProceed.textContent = 'Pembayaran';
                btnProceed.onclick = proceedToPayment;
            }
        }

        function selectPayment(method) {
            selectedPaymentMethod = method;
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('selected');
            });
            document.querySelector(`[data-method="${method}"]`).classList.add('selected');
        }

        function placeOrder() {
            if (!selectedPaymentMethod) {
                return alert('Silakan pilih metode pembayaran terlebih dahulu!');
            }

            const name = document.getElementById('customerName').value.trim();
            const table = getTableNumber(); // dari fungsi yang sudah ada
            const total = Object.values(cart).reduce((s, i) => s + i.price * i.qty, 0);

            // Langsung arahkan ke halaman tunggu dengan data
            const params = new URLSearchParams({
                meja: table,
                nama: name,
                total: total,
                metode: selectedPaymentMethod
            });

            window.location.href = `/waiting?${params.toString()}`;

            // Kosongkan keranjang (opsional)
            cart = {};
            selectedPaymentMethod = null;
            isPaymentMode = false;
            updateCartUI();
        }

        function showToast() {
            const toast = document.getElementById('toast');
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2500);
        }

       function handleLogin() {
    window.location.href = '/login';
}

        // Init
        document.addEventListener('DOMContentLoaded', () => {
            const tableNum = getTableNumber();
            document.getElementById('tableNumber').textContent = tableNum;
            renderMenu();
            updateCartUI();
        });
    </script>
</body>
</html>