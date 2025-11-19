<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Sedang Diproses - Algo Coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700&family=Sora:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #ff6b35;
            --dark: #0f1419;
            --gray: #64748b;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body, html {
            height: 100%; 
            background: linear-gradient(135deg, #fafafa 0%, #f1f5f9 100%);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        
        .waiting-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }
        
        .logo {
            font-family: 'Sora', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), #ff8c61);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }
        
        .loading-gif {
            width: 180px;
            height: 180px;
            margin: 2rem 0;
            border-radius: 50%;
            object-fit: contain;
            background: white;
            padding: 1rem;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }
        
        .status-badge {
            display: inline-block;
            background: rgba(255,107,53,0.1);
            color: var(--primary);
            padding: 0.5rem 1.25rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .status-text {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            letter-spacing: -0.01em;
        }
        
        .order-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin: 2rem 0;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            max-width: 400px;
            width: 100%;
        }
        
        .order-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .order-info:last-child {
            border-bottom: none;
        }
        
        .order-label {
            color: var(--gray);
            font-size: 0.9375rem;
        }
        
        .order-value {
            color: var(--dark);
            font-weight: 600;
            font-size: 0.9375rem;
        }
        
        .order-value.highlight {
            color: var(--primary);
            font-size: 1.125rem;
        }
        
        .detail-text {
            font-size: 1rem;
            color: var(--gray);
            margin: 1rem 0 2rem;
            line-height: 1.6;
        }
        
        .timer-section {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            margin: 1.5rem 0;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            max-width: 400px;
            width: 100%;
        }
        
        .timer-label {
            color: var(--gray);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        .timer-display {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            font-family: 'Sora', sans-serif;
            letter-spacing: -0.02em;
        }
        
        .progress-bar {
            width: 100%;
            height: 6px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 1rem;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), #ff8c61);
            border-radius: 10px;
            animation: progress 900s linear;
        }
        
        @keyframes progress {
            from { width: 0%; }
            to { width: 100%; }
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .btn {
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background: var(--dark);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary);
            transform: scale(1.02);
        }
        
        .btn-secondary {
            background: white;
            color: var(--dark);
            border: 2px solid #e2e8f0;
        }
        
        .btn-secondary:hover {
            border-color: var(--dark);
        }
        
        .refresh-note {
            font-size: 0.8125rem;
            color: var(--gray);
            margin-top: 1.5rem;
            padding: 0.75rem;
            background: white;
            border-radius: 8px;
        }
        
        @media (max-width: 480px) {
            .logo { font-size: 1.5rem; }
            .loading-gif { width: 140px; height: 140px; }
            .status-text { font-size: 1.5rem; }
            .timer-display { font-size: 2rem; }
            .order-card, .timer-section { padding: 1rem; }
            .action-buttons { flex-direction: column; }
            .btn { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="waiting-container">
        <div class="logo">ALGO COFFEE</div>
        
        <div class="status-badge">● Sedang Diproses</div>
        
        <!-- GIF Loading -->
        <img src="../masak.gif" alt="Loading..." class="loading-gif">

        <div class="status-text">Pesanan Sedang Disiapkan</div>
        
        <!-- Order Details Card -->
        <div class="order-card">
            <div class="order-info">
                <span class="order-label">Nomor Meja</span>
                <span class="order-value">Meja {{ request()->get('meja', '1') }}</span>
            </div>
            <div class="order-info">
                <span class="order-label">Nama Pemesan</span>
                <span class="order-value">{{ request()->get('nama', 'Guest') }}</span>
            </div>
            <div class="order-info">
                <span class="order-label">Metode Pembayaran</span>
                <span class="order-value" style="text-transform: uppercase;">
                    {{ request()->get('metode', 'Tunai') }}
                </span>
            </div>
            <div class="order-info">
                <span class="order-label">Total Pembayaran</span>
                <span class="order-value highlight">
                    Rp {{ number_format(request()->get('total', 0), 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Timer Section -->
        <div class="timer-section">
            <div class="timer-label">Estimasi Waktu</div>
            <div class="timer-display" id="countdown">10:00</div>
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
        </div>

        <div class="detail-text">
            Tim kami sedang menyiapkan pesanan Anda<br>
            dengan penuh cinta dan perhatian ❤️
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn btn-primary" onclick="location.reload()">
                🔄 Refresh Status
            </button>
            <button class="btn btn-secondary" onclick="window.location.href='/meja/{{ request()->get('meja', '1') }}'">
                ← Kembali ke Menu
            </button>
        </div>

        <div class="refresh-note">
            💡 Status pesanan akan diperbarui secara otomatis oleh kasir
        </div>
    </div>

    <script>
        // Countdown Timer (15 menit)
        let totalSeconds = 10 * 60; // 15 menit
        
        function updateCountdown() {
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;
            
            document.getElementById('countdown').textContent = 
                `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            
            if (totalSeconds > 0) {
                totalSeconds--;
            } else {
                document.getElementById('countdown').textContent = 'Selesai!';
            }
        }
        
        // Update setiap detik
        setInterval(updateCountdown, 1000);
        updateCountdown();

        // Auto refresh setiap 30 detik untuk cek status dari kasir
        setInterval(() => {
            console.log('Auto-checking order status...');
            // Nanti bisa diganti dengan AJAX request ke backend
            // untuk cek apakah status sudah diupdate kasir
        }, 30000);
    </script>
</body>
</html>