<?php
$currentRoute = $_GET['route'] ?? 'home';
$isHome = ($currentRoute === 'home' || empty($currentRoute));
$navPrefix = $isHome ? '' : '?route=home';
?>
<!-- Footer -->
<footer class="custom-footer">
    <div class="container">
        <div class="row g-4 justify-content-between">

            <!-- Col 1: Company Info -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="public/assets/images/logo.png" alt="PT Samudra Kencana Mina" class="footer-logo" width="36" height="36">
                    <div>
                        <h5 class="mb-0 text-white fw-bold">PT Samudra Kencana Mina</h5>
                        <span class="small text-info">Fresh Frozen Food</span>
                    </div>
                </div>
                <p class="footer-desc">
                    Memberikan yang terbaik untuk kepuasan pelanggan kami dengan produk olahan seafood beku berkualitas tinggi.
                </p>
                <div class="footer-social-links">
                    <a href="https://www.facebook.com/" class="social-icon" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/" class="social-icon" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://x.com/" class="social-icon" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/" class="social-icon" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div class="col-lg-3 col-md-6 col-6">
                <h5 class="footer-col-title">Navigasi</h5>
                <ul class="footer-links">
                    <li><a href="<?= $navPrefix ?>#beranda"><i class="fas fa-chevron-right me-1 small"></i> Beranda</a></li>
                    <li><a href="<?= $navPrefix ?>#tentang"><i class="fas fa-chevron-right me-1 small"></i> Tentang Kami</a></li>
                    <li><a href="<?= $navPrefix ?>#produk"><i class="fas fa-chevron-right me-1 small"></i> Produk</a></li>
                    <li><a href="<?= $navPrefix ?>#forum"><i class="fas fa-chevron-right me-1 small"></i> Forum Diskusi</a></li>
                    <li><a href="<?= $navPrefix ?>#kontak"><i class="fas fa-chevron-right me-1 small"></i> Kontak</a></li>
                </ul>
            </div>

            <!-- Col 3: Hubungi Kami -->
            <div class="col-lg-4 col-md-6">
                <h5 class="footer-col-title">Hubungi Kami</h5>
                <ul class="footer-contact-list">
                    <li class="d-flex align-items-start gap-2 mb-2">
                        <i class="fas fa-map-marker-alt text-primary mt-1"></i>
                        <span>Central Square E-31, JL Ahmad Yani, No. 41-43, Gedangan, Sidoarjo, Jawa Timur, 61254, Indonesia</span>
                    </li>
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-phone text-primary"></i>
                        <a href="tel:+62318547202" class="text-white-50 text-decoration-none">+62 31 8547202</a>
                    </li>
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-envelope text-primary"></i>
                        <a href="mailto:info@skmseafood.com" class="text-white-50 text-decoration-none">info@skmseafood.com</a>
                    </li>
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-clock text-primary"></i>
                        <span>Senin - Jumat: 08:00 - 17:00 WIB</span>
                    </li>
                </ul>
            </div>

        </div>

        <hr class="footer-divider my-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <p class="mb-0 text-white-50 small">
                &copy; <?= date('Y'); ?> <strong>PT Samudra Kencana Mina</strong>. All rights reserved.
            </p>
            <div>
                <a href="?route=admin/login" class="footer-admin-link">
                    <i class="fas fa-lock me-1"></i> Panel Admin
                </a>
            </div>
        </div>
    </div>
</footer>

<!-- ======================================================================
     SKM AI CHAT ASSISTANT WIDGET
     ====================================================================== -->
<div class="skm-ai-chat-wrapper" id="skmAiChatWrapper">
    <!-- Chat Widget Window -->
    <div class="skm-ai-chat-window shadow-xl" id="skmAiChatWindow" aria-hidden="true">
        <!-- Header -->
        <div class="skm-ai-chat-header d-flex align-items-center justify-content-between px-3 py-3">
            <div class="d-flex align-items-center gap-2">
                <div class="skm-ai-avatar-badge">
                    <i class="fas fa-robot"></i>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <h6 class="mb-0 fw-bold text-white fs-6">SKM Assistant</h6>
                        <span class="skm-online-pill"><span class="skm-online-dot"></span> Online</span>
                    </div>
                    <small class="text-info" style="font-size: 0.72rem;">AI Asisten Resmi &bull; PT Samudra Kencana Mina</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-1">
                <button type="button" class="btn btn-sm skm-chat-header-btn" id="skmClearChatBtn" title="Mulai Percakapan Baru" aria-label="Reset Chat">
                    <i class="fas fa-redo-alt"></i>
                </button>
                <button type="button" class="btn-close btn-close-white ms-1" id="skmCloseChatBtn" aria-label="Tutup"></button>
            </div>
        </div>

        <!-- Customer Identity & Benefits Banner -->
        <div class="skm-chat-auth-banner px-3 py-2 bg-light border-bottom d-flex align-items-center justify-content-between small" id="skmChatAuthBanner">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="d-flex align-items-center gap-2 text-dark text-truncate">
                    <?php if (!empty($_SESSION['user_avatar'])): ?>
                        <img src="<?= htmlspecialchars($_SESSION['user_avatar']) ?>" alt="Avatar" class="rounded-circle flex-shrink-0" width="20" height="20" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user_name'] ?? 'User') ?>&background=0284c7&color=fff'">
                    <?php else: ?>
                        <i class="fas fa-user-check text-success flex-shrink-0"></i>
                    <?php endif; ?>
                    <span class="fw-semibold text-truncate">Masuk sebagai: <strong><?= htmlspecialchars(explode(' ', $_SESSION['user_name'] ?? 'Pelanggan')[0]) ?></strong></span>
                </div>
                <a href="?route=account" class="badge bg-primary text-white text-decoration-none rounded-pill px-2 py-1 flex-shrink-0">
                    <i class="fas fa-user-circle me-1"></i> Akun Saya
                </a>
            <?php else: ?>
                <div class="text-muted text-truncate" style="font-size: 0.78rem;">
                    <i class="fas fa-info-circle text-primary me-1"></i> Masuk untuk simpan riwayat & RFQ
                </div>
                <a href="?route=auth/login&return_to=<?= urlencode('?route=home#chat') ?>" class="btn btn-outline-dark btn-xs rounded-pill px-2 py-1 fw-bold d-inline-flex align-items-center gap-1 flex-shrink-0" style="font-size: 0.75rem;">
                    <i class="fab fa-google text-warning"></i> Masuk
                </a>
            <?php endif; ?>
        </div>

        <!-- 5 Touch-Friendly Quick Action Suggestion Chips (>= 44px) -->
        <div class="skm-ai-quick-prompts px-3 py-2 border-bottom d-flex gap-2 overflow-x-auto" id="skmQuickPrompts">
            <button type="button" class="skm-chip-prompt" data-prompt="Apa saja produk seafood olahan beku yang tersedia?">
                <span class="chip-icon">🐟</span> <span>Produk</span>
            </button>
            <button type="button" class="skm-chip-prompt" data-prompt="Cek ketersediaan stok produk seafood saat ini">
                <span class="chip-icon">📦</span> <span>Cek Stok</span>
            </button>
            <button type="button" class="skm-chip-prompt chip-primary" data-prompt="Saya ingin mengajukan permintaan penawaran harga pasokan seafood.">
                <span class="chip-icon">💰</span> <span>Minta Penawaran</span>
            </button>
            <button type="button" class="skm-chip-prompt" data-prompt="Bagaimana sistem pengiriman dan rantai dingin (cold chain)?">
                <span class="chip-icon">🚚</span> <span>Pengiriman</span>
            </button>
            <button type="button" class="skm-chip-prompt" data-prompt="Informasi profil perusahaan, alamat kantor, dan jam operasional PT SKM">
                <span class="chip-icon">🏢</span> <span>Tentang SKM</span>
            </button>
        </div>

        <!-- Chat Message Stream -->
        <div class="skm-ai-chat-body p-3" id="skmChatMessageContainer">
            <div class="skm-chat-bubble-row ai-row">
                <div class="skm-chat-avatar ai-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="skm-chat-bubble ai-bubble">
                    <div class="skm-chat-text">
                        Halo! 👋 Saya <strong>SKM Assistant</strong>, asisten AI resmi dari PT Samudra Kencana Mina.<br><br>
                        Saya siap membantu Anda mengenai:
                        <ul class="mb-2 ps-3 mt-1 small">
                            <li>Informasi katalog produk seafood segar beku</li>
                            <li>Pengecekan stok terkini di database</li>
                            <li>Pembuatan Permintaan Penawaran Harga (RFQ)</li>
                            <li>Kontak dan konsultasi pasokan resmi</li>
                        </ul>
                        Ada yang ingin Anda tanyakan atau butuhkan hari ini?
                    </div>
                    <div class="skm-chat-time"><?= date('H:i') ?></div>
                </div>
            </div>
        </div>

        <!-- Typing Indicator (Hidden by default) -->
        <div class="skm-typing-container px-3 py-2 d-none" id="skmTypingIndicator">
            <div class="skm-typing-bubble">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <small class="text-muted ms-2" style="font-size: 0.75rem;">SKM Assistant sedang mengetik...</small>
        </div>

        <!-- Chat Input Form -->
        <div class="skm-ai-chat-footer p-2 p-sm-3 border-top bg-white">
            <form id="skmChatForm" class="d-flex align-items-end gap-2">
                <textarea
                    id="skmChatInput"
                    class="form-control skm-chat-textarea"
                    rows="1"
                    placeholder="Tulis pertanyaan atau kebutuhan Anda..."
                    maxlength="3000"
                    required
                ></textarea>
                <button type="submit" class="btn btn-primary rounded-circle skm-chat-send-btn flex-shrink-0" id="skmChatSendBtn" aria-label="Kirim Pesan" title="Kirim">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
            <div class="d-flex justify-content-between align-items-center mt-1 px-1 text-muted" style="font-size: 0.7rem;">
                <span>Tekan Enter untuk kirim &bull; Shift+Enter baris baru</span>
                <span id="skmChatCharCount">0/3000</span>
            </div>
        </div>
    </div>

    <!-- Floating AI Trigger Button (Single, Dedicated Trigger) -->
    <button type="button" class="skm-ai-floating-trigger d-none d-md-flex" id="skmAiChatTrigger" aria-label="Buka SKM Assistant AI Chat" title="Tanya SKM Assistant (AI)">
        <span class="skm-ai-sparkle-icon"><i class="fas fa-sparkles"></i></span>
        <span class="skm-ai-trigger-label ms-1 fw-bold">✨ SKM Assistant</span>
    </button>
</div>

<!-- Back to Top Button -->
<button type="button" class="btn-back-to-top shadow" id="backToTopBtn" aria-label="Kembali ke atas" title="Kembali ke atas">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Toast Notification Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" id="skm-toast-container" style="z-index: 1100;"></div>

<!-- Mobile Sticky Quick Bar (Hidden on desktop & admin) -->
<div class="skm-mobile-bottom-bar d-md-none">
    <button type="button" class="btn btn-sm btn-info text-dark fw-bold flex-fill py-2" id="skmMobileAiChatBtn">
        <i class="fas fa-sparkles me-1"></i> SKM Assistant
    </button>
    <a href="https://wa.me/62318547202?text=Halo%20PT%20Samudra%20Kencana%20Mina,%20saya%20ingin%20konsultasi%20produk%20seafood." target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-success flex-fill py-2">
        <i class="fab fa-whatsapp me-1"></i> WhatsApp
    </a>
    <button type="button" class="btn btn-sm btn-primary flex-fill py-2" data-bs-toggle="modal" data-bs-target="#rfqModal">
        <i class="fas fa-file-invoice me-1"></i> Penawaran
    </button>
</div>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Application JS -->
<script src="public/js/main.js"></script>

</body>
</html>

