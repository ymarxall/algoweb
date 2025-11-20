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
        <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
            <!-- QR Code Display -->
            <div id="qrCodeContainer" style="background: white; padding: 1rem; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: 2px solid #f0f0f0;">
                <div id="qrCode" style="width: 120px; height: 120px; margin: 0 auto; background: #f5f5f5; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; color: #999; font-weight: 500;">
                    Memuat QR...
                </div>
                <p style="text-align: center; font-size: 0.75rem; color: #999; margin-top: 0.5rem; font-weight: 600;">Scan untuk pesan</p>
            </div>

            <h1>Jelajahi Menu Kami</h1>
            <p>Pilih menu favorit Anda hari ini</p>
            <div class="table-info">
                <span class="table-badge">Meja <span id="tableNumber">1</span></span>
            </div>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Cari menu atau kategori...">
            </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        // Ambil data menu dari database via API
        let menuData = [];
        let cart = {};
        let currentCategory = 'all';
        let selectedPaymentMethod = null;
        let isPaymentMode = false;

        // Generate QR Code
        function generateQRCode(tableNumber) {
            const qrContainer = document.getElementById('qrCode');
            qrContainer.innerHTML = ''; // Clear previous QR
            
            const currentUrl = window.location.origin + '/meja/' + tableNumber;
            
            // Generate QR Code
            new QRCode(qrContainer, {
                text: currentUrl,
                width: 120,
                height: 120,
                colorDark: '#0f1419',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });
        }

        // Fetch menu data saat halaman load
        async function loadMenuData() {
            try {
                const response = await fetch('/api/menus');
                menuData = await response.json();
                renderMenu(); // Render setelah data loaded
            } catch (error) {
                console.error('Error loading menu:', error);
                // Fallback ke data kosong jika error
                menuData = [];
                renderMenu();
            }
        }

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

            // Clear grid
            grid.innerHTML = '';

            if (items.length === 0) {
                const emptyMsg = document.createElement('p');
                emptyMsg.className = 'text-center col-span-full text-gray-500';
                emptyMsg.textContent = 'Menu tidak ditemukan';
                grid.appendChild(emptyMsg);
                return;
            }

            // Render items safely (prevent XSS)
            items.forEach(item => {
                const card = document.createElement('div');
                card.className = 'menu-card';
                
                const img = document.createElement('img');
                img.src = item.image || '/images/placeholder.png';
                img.alt = item.name;
                img.className = 'menu-card-img';
                
                const body = document.createElement('div');
                body.className = 'menu-card-body';
                
                const title = document.createElement('h3');
                title.className = 'menu-card-title';
                title.textContent = item.name;
                
                const desc = document.createElement('p');
                desc.className = 'menu-card-desc';
                desc.textContent = item.desc;
                
                const footer = document.createElement('div');
                footer.className = 'menu-card-footer';
                
                const price = document.createElement('div');
                price.className = 'menu-price';
                price.textContent = 'Rp ' + item.price.toLocaleString('id-ID');
                
                const btn = document.createElement('button');
                btn.className = 'btn-add';
                btn.textContent = '+ Tambah';
                btn.onclick = () => addToCart(item.id);
                
                footer.appendChild(price);
                footer.appendChild(btn);
                
                body.appendChild(title);
                body.appendChild(desc);
                body.appendChild(footer);
                
                card.appendChild(img);
                card.appendChild(body);
                
                grid.appendChild(card);
            });
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
            if (!item) return;
            
            cart[id] = cart[id] ? { ...cart[id], qty: cart[id].qty + 1 } : { ...item, qty: 1 };
            updateCartUI();
            showToast();

            // Kirim ke backend via AJAX
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id })
            }).catch(err => console.error('Error adding to cart:', err));
        }

        function updateQty(id, change) {
            if (!cart[id]) return;
            
            const newQty = cart[id].qty + change;

            if (newQty <= 0) {
                removeFromCart(id); // Panggil fungsi hapus jika kuantitas jadi 0 atau kurang
                return;
            }
            
            cart[id].qty = newQty;
            updateCartUI();

            // Kirim ke backend via AJAX
            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id, quantity: newQty })
            }).catch(err => console.error('Error updating quantity:', err));
        }

        function removeFromCart(id) {
            delete cart[id];
            updateCartUI();

            // Kirim ke backend via AJAX
            fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id })
            }).catch(err => console.error('Error removing item:', err));
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

            // Cart items - render safely (prevent XSS)
            const container = document.getElementById('cartItems');
            container.innerHTML = '';
            
            if (totalItems === 0) {
                const emptyMsg = document.createElement('p');
                emptyMsg.className = 'text-center text-gray-500 py-8';
                emptyMsg.textContent = 'Keranjang kosong';
                container.appendChild(emptyMsg);
            } else {
                items.forEach(item => {
                    const cartItem = document.createElement('div');
                    cartItem.className = 'cart-item';
                    
                    const img = document.createElement('img');
                    img.src = item.image || '/images/placeholder.png';
                    img.alt = item.name;
                    img.className = 'cart-item-img';
                    
                    const details = document.createElement('div');
                    details.className = 'flex-1';
                    details.style.flex = '1';
                    
                    const itemName = document.createElement('div');
                    itemName.className = 'font-semibold text-sm';
                    itemName.textContent = item.name;
                    
                    const itemPrice = document.createElement('div');
                    itemPrice.className = 'text-gray-600';
                    itemPrice.style.fontSize = '0.8125rem';
                    itemPrice.textContent = 'Rp ' + item.price.toLocaleString('id-ID') + ' × ' + item.qty;
                    
                    const qtyControls = document.createElement('div');
                    qtyControls.className = 'qty-controls mt-2';
                    qtyControls.style.display = 'inline-flex';
                    
                    const btnMinus = document.createElement('button');
                    btnMinus.className = 'qty-btn';
                    btnMinus.textContent = '−';
                    btnMinus.onclick = () => updateQty(item.id, -1);
                    
                    const qtyDisplay = document.createElement('span');
                    qtyDisplay.className = 'qty-display';
                    qtyDisplay.textContent = item.qty;
                    
                    const btnPlus = document.createElement('button');
                    btnPlus.className = 'qty-btn';
                    btnPlus.textContent = '+';
                    btnPlus.onclick = () => updateQty(item.id, 1);
                    
                    const btnRemove = document.createElement('button');
                    btnRemove.className = 'btn-remove';
                    btnRemove.textContent = 'Hapus';
                    btnRemove.style.marginLeft = '0.5rem';
                    btnRemove.onclick = () => removeFromCart(item.id);
                    
                    qtyControls.appendChild(btnMinus);
                    qtyControls.appendChild(qtyDisplay);
                    qtyControls.appendChild(btnPlus);
                    
                    details.appendChild(itemName);
                    details.appendChild(itemPrice);
                    details.appendChild(qtyControls);
                    details.appendChild(btnRemove);
                    
                    cartItem.appendChild(img);
                    cartItem.appendChild(details);
                    
                    container.appendChild(cartItem);
                });
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
            if (!name) {
                return alert('Silakan masukkan nama Anda!');
            }

            // Kirim order ke backend
            fetch('/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    customer_name: name,
                    payment_method: selectedPaymentMethod
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect ke halaman waiting dengan order ID
                    window.location.href = data.redirect_url;
                    
                    // Kosongkan keranjang lokal
                    cart = {};
                    selectedPaymentMethod = null;
                    isPaymentMode = false;
                    updateCartUI();
                } else {
                    alert(data.error || 'Terjadi kesalahan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses pesanan');
            });
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
            generateQRCode(tableNum);
            
            // Load menu data dari database, lalu render
            loadMenuData();
            updateCartUI();
        });
    </script>
</body>
</html>