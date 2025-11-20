<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Pesanan - Algo Coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<style>
    * {
        font-family: 'Sora', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary: #ff6b35;
        --primary-dark: #ff8c61;
        --dark: #0f1419;
        --light: #f5f5f5;
        --success: #10b981;
        --warning: #f59e0b;
        --info: #3b82f6;
    }

    html, body {
        height: 100%;
        width: 100%;
        overflow-x: hidden;
    }

    /* Animated Background */
    .waiting-page {
        background: linear-gradient(135deg, #0f1419 0%, #1a1f28 50%, #0f1419 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        position: relative;
        overflow: hidden;
    }

    /* Floating Coffee Beans Animation */
    .coffee-bean {
        position: absolute;
        font-size: 2rem;
        opacity: 0.1;
        animation: float 15s infinite ease-in-out;
    }

    .coffee-bean:nth-child(1) { left: 10%; animation-delay: 0s; }
    .coffee-bean:nth-child(2) { left: 30%; animation-delay: 2s; }
    .coffee-bean:nth-child(3) { left: 50%; animation-delay: 4s; }
    .coffee-bean:nth-child(4) { left: 70%; animation-delay: 6s; }
    .coffee-bean:nth-child(5) { left: 90%; animation-delay: 8s; }

    @keyframes float {
        0%, 100% {
            transform: translateY(100vh) rotate(0deg);
            opacity: 0;
        }
        10% {
            opacity: 0.1;
        }
        90% {
            opacity: 0.1;
        }
        100% {
            transform: translateY(-100px) rotate(360deg);
            opacity: 0;
        }
    }

    /* Glass Morphism Container */
    .waiting-container {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
        max-width: 650px;
        width: 100%;
        padding: 3rem;
        text-align: center;
        position: relative;
        animation: slideUp 0.6s ease-out;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Glow Effect */
    .waiting-container::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, var(--primary), var(--primary-dark), var(--primary));
        border-radius: 30px;
        opacity: 0;
        z-index: -1;
        animation: glow 3s infinite;
    }

    @keyframes glow {
        0%, 100% { opacity: 0; }
        50% { opacity: 0.3; }
    }

    /* Header with Animation */
    .header {
        margin-bottom: 2rem;
        animation: fadeIn 0.8s ease-out 0.2s both;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Animated Coffee Cup Logo */
    .logo {
        font-size: 4rem;
        margin-bottom: 1rem;
        display: inline-block;
        position: relative;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
        }
        25% {
            transform: translateY(-20px) rotate(-5deg);
        }
        50% {
            transform: translateY(0) rotate(0deg);
        }
        75% {
            transform: translateY(-10px) rotate(5deg);
        }
    }

    /* Steam Animation */
    .steam {
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1.5rem;
        opacity: 0;
        animation: steam 3s infinite;
    }

    .steam:nth-child(1) { animation-delay: 0s; left: 45%; }
    .steam:nth-child(2) { animation-delay: 1s; left: 50%; }
    .steam:nth-child(3) { animation-delay: 2s; left: 55%; }

    @keyframes steam {
        0% {
            opacity: 0;
            transform: translateY(0) translateX(-50%) scale(0.5);
        }
        50% {
            opacity: 0.5;
        }
        100% {
            opacity: 0;
            transform: translateY(-50px) translateX(-50%) scale(1);
        }
    }

    .logo-container {
        position: relative;
        display: inline-block;
    }

    .header h1 {
        font-size: 2rem;
        color: var(--dark);
        margin-bottom: 0.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--dark), var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .header p {
        color: #666;
        font-size: 1rem;
    }

    /* Order Number with Shine Effect */
    .order-number {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 20px;
        margin: 2rem 0;
        position: relative;
        overflow: hidden;
        animation: fadeIn 0.8s ease-out 0.4s both;
        box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
    }

    .order-number::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(
            45deg,
            transparent,
            rgba(255, 255, 255, 0.3),
            transparent
        );
        animation: shine 3s infinite;
    }

    @keyframes shine {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }

    .order-number-label {
        font-size: 0.875rem;
        opacity: 0.9;
        font-weight: 600;
    }

    .order-number span {
        display: block;
        font-size: 2.5rem;
        font-weight: 800;
        margin-top: 0.5rem;
        font-family: 'Courier New', monospace;
        letter-spacing: 4px;
    }

    /* Enhanced Timeline */
    .status-timeline {
        margin: 3rem 0;
        animation: fadeIn 0.8s ease-out 0.6s both;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        margin: 2rem 0;
        text-align: left;
        position: relative;
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 25px;
        top: 60px;
        width: 3px;
        height: 50px;
        background: #e5e5e5;
        transition: all 0.5s;
    }

    .timeline-item:last-child::before {
        display: none;
    }

    .timeline-item.active::before {
        background: linear-gradient(180deg, var(--primary), var(--primary-dark));
    }

    /* Timeline Icon with Ripple */
    .timeline-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 1.5rem;
        flex-shrink: 0;
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        background: #f5f5f5;
        color: #ccc;
        position: relative;
        border: 3px solid #e5e5e5;
    }

    .timeline-item.active .timeline-icon {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border-color: var(--primary);
        animation: pulse-ring 1.5s infinite;
        box-shadow: 0 5px 20px rgba(255, 107, 53, 0.4);
    }

    @keyframes pulse-ring {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 107, 53, 0.7);
        }
        70% {
            box-shadow: 0 0 0 15px rgba(255, 107, 53, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255, 107, 53, 0);
        }
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-content h3 {
        margin: 0;
        color: var(--dark);
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s;
    }

    .timeline-content p {
        margin: 0.5rem 0 0 0;
        color: #999;
        font-size: 0.875rem;
    }

    .timeline-item.active .timeline-content h3 {
        font-weight: 800;
        color: var(--primary);
    }

    /* Timer Section with Progress Ring */
    .timer-section {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05));
        border: 2px solid var(--success);
        border-radius: 20px;
        padding: 2rem;
        margin: 2rem 0;
        animation: fadeIn 0.8s ease-out 0.8s both;
        position: relative;
        overflow: hidden;
    }

    .timer-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--success), transparent);
        animation: loading 2s infinite;
    }

    @keyframes loading {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .timer-label {
        color: #666;
        font-size: 0.875rem;
        margin-bottom: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .timer-display {
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--success);
        font-family: 'Courier New', monospace;
        margin: 1rem 0;
        text-shadow: 0 2px 10px rgba(16, 185, 129, 0.3);
        animation: timerPulse 2s infinite;
    }

    @keyframes timerPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Completed Message with Confetti */
    .completed-message {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));
        border: 3px solid var(--success);
        border-radius: 20px;
        padding: 3rem;
        margin: 2rem 0;
        text-align: center;
        animation: celebrate 0.6s ease-out;
        position: relative;
        overflow: hidden;
    }

    @keyframes celebrate {
        0% {
            transform: scale(0.8) rotate(-5deg);
            opacity: 0;
        }
        50% {
            transform: scale(1.1) rotate(5deg);
        }
        100% {
            transform: scale(1) rotate(0deg);
            opacity: 1;
        }
    }

    .completed-message .check-icon {
        font-size: 5rem;
        color: var(--success);
        display: block;
        margin-bottom: 1rem;
        animation: checkmark 0.8s ease-out;
    }

    @keyframes checkmark {
        0% {
            transform: scale(0) rotate(45deg);
        }
        50% {
            transform: scale(1.2) rotate(-10deg);
        }
        100% {
            transform: scale(1) rotate(0deg);
        }
    }

    .completed-message h2 {
        color: var(--dark);
        margin-bottom: 0.5rem;
        font-size: 2rem;
        font-weight: 800;
    }

    .completed-message p {
        color: #666;
        font-size: 1rem;
    }

    /* Order Details */
    .order-details {
        background: var(--light);
        border-radius: 20px;
        padding: 2rem;
        margin: 2rem 0;
        text-align: left;
        animation: fadeIn 0.8s ease-out 1s both;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .order-details h3 {
        color: var(--dark);
        margin-bottom: 1.5rem;
        font-size: 1.2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .order-items {
        max-height: 250px;
        overflow-y: auto;
        padding-right: 0.5rem;
    }

    .order-items::-webkit-scrollbar {
        width: 6px;
    }

    .order-items::-webkit-scrollbar-track {
        background: #e5e5e5;
        border-radius: 10px;
    }

    .order-items::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 10px;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid #e5e5e5;
        font-size: 0.95rem;
        transition: all 0.3s;
        border-radius: 10px;
    }

    .order-item:hover {
        background: white;
        transform: translateX(5px);
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-item-name {
        color: var(--dark);
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .order-item-qty {
        color: #999;
        font-size: 0.875rem;
    }

    .order-item-price {
        color: var(--primary);
        font-weight: 700;
        font-size: 1rem;
    }

    .order-total {
        display: flex;
        justify-content: space-between;
        padding: 1.5rem 1rem 0 1rem;
        border-top: 3px solid var(--primary);
        margin-top: 1.5rem;
        font-weight: 800;
        color: var(--dark);
        font-size: 1.2rem;
    }

    /* Enhanced Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        animation: fadeIn 0.8s ease-out 1.2s both;
    }

    .btn {
        flex: 1;
        padding: 1rem 1.5rem;
        border: none;
        border-radius: 15px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(255, 107, 53, 0.5);
    }

    .btn-primary:active {
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: white;
        color: var(--dark);
        border: 3px solid var(--light);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary:hover {
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(255, 107, 53, 0.2);
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 700;
        margin-top: 1.5rem;
        background: linear-gradient(135deg, #fee3d3, #ffd4bd);
        color: var(--primary);
        box-shadow: 0 5px 15px rgba(255, 107, 53, 0.2);
        animation: fadeIn 0.8s ease-out 1.4s both, badge-pulse 2s infinite;
    }

    @keyframes badge-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Progress Indicator */
    .progress-bar {
        width: 100%;
        height: 6px;
        background: #e5e5e5;
        border-radius: 10px;
        overflow: hidden;
        margin: 1rem 0;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        border-radius: 10px;
        transition: width 0.5s ease;
        animation: progress-shine 2s infinite;
    }

    @keyframes progress-shine {
        0% { background-position: -100% 0; }
        100% { background-position: 200% 0; }
    }

    /* Responsive Design */
    @media (max-width: 600px) {
        .waiting-container {
            padding: 2rem 1.5rem;
            border-radius: 20px;
        }

        .header h1 {
            font-size: 1.5rem;
        }

        .logo {
            font-size: 3rem;
        }

        .timer-display {
            font-size: 2.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .timeline-item {
            margin: 1.5rem 0;
        }

        .timeline-icon {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }

        .order-number span {
            font-size: 2rem;
        }
    }
</style>

<div class="waiting-page">
    <!-- Floating Coffee Beans -->
    <div class="coffee-bean">☕</div>
    <div class="coffee-bean">☕</div>
    <div class="coffee-bean">☕</div>
    <div class="coffee-bean">☕</div>
    <div class="coffee-bean">☕</div>

    <div class="waiting-container">
        @if ($order)
            <div class="header">
                <div class="logo-container">
                    <div class="steam">☁️</div>
                    <div class="steam">☁️</div>
                    <div class="steam">☁️</div>
                    <div class="logo">☕</div>
                </div>
                <h1>Pesanan Anda Sedang Diproses</h1>
                <p>Terima kasih {{ htmlspecialchars($order->customer_name) }} telah memesan di Algo Coffee ✨</p>
            </div>

            <div class="order-number">
                <div class="order-number-label">NOMOR PESANAN ANDA</div>
                <span id="order-number">{{ $order->order_number ?? 'N/A' }}</span>
            </div>

            <!-- Progress Bar -->
            <div class="progress-bar">
                <div class="progress-fill" id="progress-fill" style="width: 25%;"></div>
            </div>

            <!-- Status Timeline -->
            <div class="status-timeline">
                <div class="timeline-item" data-status="pending">
                    <div class="timeline-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>Pesanan Diterima</h3>
                        <p>Pesanan masuk ke sistem kami</p>
                    </div>
                </div>

                <div class="timeline-item" data-status="accepted">
                    <div class="timeline-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>Dikonfirmasi Kasir</h3>
                        <p>Pesanan telah dikonfirmasi</p>
                    </div>
                </div>

                <div class="timeline-item" data-status="preparing">
                    <div class="timeline-icon">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>Sedang Diproses</h3>
                        <p>Barista sedang membuat pesanan Anda</p>
                    </div>
                </div>

                <div class="timeline-item" data-status="ready">
                    <div class="timeline-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>Siap Disajikan</h3>
                        <p>Pesanan siap untuk diambil</p>
                    </div>
                </div>
            </div>

            <!-- This section will be replaced when order is ready -->
            <div id="timer-container">
                <div class="timer-section">
                    <div class="timer-label">⏱️ Estimasi Waktu Selesai</div>
                    <div class="timer-display" id="timer">...</div>
                    <div class="timer-label">Pesanan Anda akan segera siap!</div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="order-details">
                <h3><i class="fas fa-list"></i> Detail Pesanan</h3>
                <div class="order-items" id="order-items">
                    @foreach ($order->menus as $menu)
                        <div class="order-item">
                            <div>
                                <div class="order-item-name">{{ $menu->name }}</div>
                                <div class="order-item-qty">{{ $menu->pivot->quantity }}x</div>
                            </div>
                            <div class="order-item-price">Rp {{ number_format($menu->pivot->price * $menu->pivot->quantity, 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="order-total">
                    <span>Total:</span>
                    <span id="total-price">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="status-badge" id="status-badge">
                <i class="fas fa-fire"></i> Sedang Diproses
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('customer.menu', ['no' => $order->table->id]) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Pesan Lagi
                </a>
                <button class="btn btn-primary" id="update-status-btn">
                    <i class="fas fa-sync-alt"></i> Perbarui Status
                </button>
            </div>
        @else
            <div class="header">
                <h1>Pesanan Tidak Ditemukan</h1>
                <p>Maaf, kami tidak dapat menemukan detail pesanan Anda. Silakan coba lagi atau hubungi kasir.</p>
            </div>
             <div class="action-buttons">
                <a href="/" class="btn btn-primary">
                    <i class="fas fa-home"></i> Kembali ke Home
                </a>
            </div>
        @endif
    </div>
</div>

@if ($order)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const config = {
            orderId: {{ $order->id }},
            initialStatus: '{{ $order->status }}',
            statusApiUrl: '{{ route('api.order.status', ['id' => $order->id]) }}',
            estimatedCompletion: '{{ $order->estimated_completion_at }}'
        };

        const statusMap = {
            'pending': 0,
            'accepted': 1,
            'preparing': 2,
            'ready': 3,
            'completed': 4,
            'rejected': -1
        };

        let currentStatusIndex = statusMap[config.initialStatus] || 0;
        let pollingInterval;

        function updateStatusUI(status) {
            currentStatusIndex = statusMap[status] || 0;
            const items = document.querySelectorAll('.timeline-item');
            const progressFill = document.getElementById('progress-fill');
            
            if (currentStatusIndex === -1) { // Rejected
                showRejectedMessage();
                return;
            }

            items.forEach((item, index) => {
                if (index <= currentStatusIndex) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });

            const progress = ((currentStatusIndex + 1) / items.length) * 100;
            progressFill.style.width = progress + '%';

            const badge = document.getElementById('status-badge');
            const statusTexts = [
                '<i class="fas fa-receipt"></i> Menunggu Konfirmasi',
                '<i class="fas fa-check"></i> Dikonfirmasi Kasir',
                '<i class="fas fa-fire"></i> Sedang Diproses',
                '<i class="fas fa-check-circle"></i> Siap Disajikan',
                '<i class="fas fa-star"></i> Selesai'
            ];
            badge.innerHTML = statusTexts[currentStatusIndex] || statusTexts[0];

            if (currentStatusIndex >= 3) { // Ready or Completed
                showCompletedMessage();
                if (pollingInterval) {
                    clearInterval(pollingInterval); // Stop polling
                }
            }
        }

        function showCompletedMessage() {
            const timerContainer = document.getElementById('timer-container');
            if (timerContainer && !document.querySelector('.completed-message')) {
                const completedHTML = `
                    <div class="completed-message">
                        <div class="check-icon">✅</div>
                        <h2>Pesanan Siap! 🎉</h2>
                        <p>Silakan ambil pesanan Anda di kasir</p>
                    </div>
                `;
                timerContainer.innerHTML = completedHTML;
            }
        }

        function showRejectedMessage() {
            const container = document.querySelector('.waiting-container');
            container.innerHTML = `
                <div class="header">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">❌</div>
                    <h1>Pesanan Ditolak</h1>
                    <p>Maaf, pesanan Anda tidak dapat diproses. Silakan hubungi kasir untuk informasi lebih lanjut atau pesan kembali.</p>
                </div>
                <div class="action-buttons" style="margin-top: 2rem;">
                    <a href="{{ route('customer.menu', ['no' => $order->table->id]) }}" class="btn btn-primary" style="display: inline-block; padding: 0.75rem 1.5rem; background: var(--primary); color: white; text-decoration: none; border-radius: 8px;">
                        <i class="fas fa-arrow-left"></i> Kembali Pesan
                    </a>
                </div>
            `;
        }

        function updateTimer() {
            if (!config.estimatedCompletion) {
                document.getElementById('timer').textContent = '--:--';
                return;
            }

            const endTime = new Date(config.estimatedCompletion).getTime();
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                document.getElementById('timer').textContent = "00:00";
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('timer').textContent = 
                String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
        }

        async function fetchOrderStatus() {
            try {
                const response = await fetch(config.statusApiUrl);
                if (!response.ok) {
                    console.error('Failed to fetch status');
                    return;
                }
                const data = await response.json();
                
                // Update estimated completion time if provided
                if (data.estimated_completion_at) {
                    config.estimatedCompletion = data.estimated_completion_at;
                }
                
                updateStatusUI(data.status);
            } catch (error) {
                console.error('Error fetching status:', error);
            }
        }

        // --- Init ---
        updateStatusUI(config.initialStatus);
        updateTimer(); 
        setInterval(updateTimer, 1000);

        // Start polling only if the order is not yet ready/completed/rejected
        if (currentStatusIndex < 3 && currentStatusIndex !== -1) {
            pollingInterval = setInterval(fetchOrderStatus, 7000); // Poll every 7 seconds
        }

        document.getElementById('update-status-btn').addEventListener('click', () => {
            const icon = document.querySelector('#update-status-btn i');
            icon.classList.add('fa-spin');
            fetchOrderStatus().finally(() => {
                setTimeout(() => icon.classList.remove('fa-spin'), 500);
            });
        });
    });
</script>
@endif

</body>
</html>