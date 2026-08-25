/**
 * PT Samudra Kencana Mina - Corporate Application Script
 * Robust, Fail-Safe, and Modular Design (2026 Edition)
 * 
 * Modules:
 * 1. Deduplicated Toast Notification System
 * 2. Scroll Progress & Smart Navbar
 * 3. Fail-Safe Scroll Reveal
 * 4. Product Search & Category Filtering
 * 5. Product Quick View Modal & RFQ Trigger
 * 6. Request for Quotation (RFQ) Modal & WhatsApp Handler
 * 7. Interactive Star Rating Picker
 * 8. Floating Action Contact Widget
 * 9. Forum Comment Form & Character Counter
 * 10. SKM AI Assistant & Integrated Inquiry System (Customer Auth Aware)
 */

document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    // -------------------------------------------------------------------------
    // 1. DEDUPLICATED TOAST NOTIFICATION SYSTEM
    // -------------------------------------------------------------------------
    (function initToast() {
        const toastContainer = document.getElementById("skm-toast-container");
        let lastToastMsg = "";
        let lastToastTime = 0;

        window.skmToast = {
            show: function (message, type = "success", duration = 4000) {
                if (!toastContainer || !message) return;

                const now = Date.now();
                // Prevent duplicate toast within 1.8 seconds
                if (message === lastToastMsg && (now - lastToastTime) < 1800) {
                    return;
                }
                lastToastMsg = message;
                lastToastTime = now;

                // Limit active toasts to 3
                const activeToasts = toastContainer.querySelectorAll(".skm-toast-item");
                if (activeToasts.length >= 3) {
                    activeToasts[0].remove();
                }

                const toast = document.createElement("div");
                toast.className = "skm-toast-item";
                toast.setAttribute("role", "alert");
                toast.setAttribute("aria-live", "assertive");

                let iconClass = "fas fa-check-circle skm-toast-icon-success";
                if (type === "warning") iconClass = "fas fa-exclamation-triangle skm-toast-icon-warning";
                if (type === "error") iconClass = "fas fa-times-circle skm-toast-icon-error";

                toast.innerHTML = `
                    <i class="${iconClass} fs-5 flex-shrink-0"></i>
                    <div class="flex-grow-1 small fw-semibold text-dark">${message}</div>
                    <button type="button" class="btn-close btn-sm ms-2" aria-label="Tutup"></button>
                `;

                toastContainer.appendChild(toast);

                const closeBtn = toast.querySelector(".btn-close");
                if (closeBtn) {
                    closeBtn.addEventListener("click", () => {
                        toast.remove();
                    });
                }

                setTimeout(() => {
                    toast.style.opacity = "0";
                    toast.style.transform = "translateY(10px) scale(0.95)";
                    toast.style.transition = "all 0.3s ease";
                    setTimeout(() => toast.remove(), 300);
                }, duration);
            }
        };
    })();

    // -------------------------------------------------------------------------
    // 2. SCROLL PROGRESS INDICATOR & SMART NAVBAR
    // -------------------------------------------------------------------------
    (function initNavbarAndScroll() {
        try {
            const progressBar = document.getElementById("scroll-progress-bar");
            const navbar = document.getElementById("mainNavbar") || document.querySelector(".custom-navbar, .navbar");
            const navLinks = document.querySelectorAll(".custom-navbar .nav-link, .navbar .nav-link");
            const sections = document.querySelectorAll("section[id]");
            const backToTopBtn = document.getElementById("backToTopBtn");

            function updateScrollEffects() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;

                if (progressBar && scrollHeight > 0) {
                    const progress = (scrollTop / scrollHeight) * 100;
                    progressBar.style.width = progress + "%";
                }

                if (navbar) {
                    if (scrollTop > 40) {
                        navbar.classList.add("scrolled");
                    } else {
                        navbar.classList.remove("scrolled");
                    }
                }

                if (backToTopBtn) {
                    if (scrollTop > 350) {
                        backToTopBtn.classList.add("active");
                    } else {
                        backToTopBtn.classList.remove("active");
                    }
                }

                let currentSectionId = "";
                const scrollPosition = scrollTop + 150;

                sections.forEach((section) => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                        currentSectionId = section.getAttribute("id");
                    }
                });

                navLinks.forEach((link) => {
                    const href = link.getAttribute("href");
                    if (href && (href.startsWith("#") || href.includes("#"))) {
                        const targetId = href.split("#")[1];
                        if (targetId && targetId === currentSectionId) {
                            link.classList.add("active");
                        } else if (targetId) {
                            link.classList.remove("active");
                        }
                    }
                });
            }

            window.addEventListener("scroll", updateScrollEffects, { passive: true });
            updateScrollEffects();

            if (backToTopBtn) {
                backToTopBtn.addEventListener("click", function () {
                    window.scrollTo({ top: 0, behavior: "smooth" });
                });
            }

            const navbarCollapse = document.getElementById("navbarContent");
            if (navbarCollapse) {
                navLinks.forEach((link) => {
                    link.addEventListener("click", () => {
                        if (navbarCollapse.classList.contains("show")) {
                            if (typeof bootstrap !== "undefined" && bootstrap.Collapse) {
                                const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse) || new bootstrap.Collapse(navbarCollapse, { toggle: false });
                                bsCollapse.hide();
                            }
                        }
                    });
                });
            }
        } catch (err) {
            console.warn("Navbar / scroll effects error:", err);
        }
    })();

    // -------------------------------------------------------------------------
    // 3. FAIL-SAFE SCROLL REVEAL
    // -------------------------------------------------------------------------
    (function initScrollReveal() {
        try {
            const revealElements = document.querySelectorAll(".skm-fade-up");
            revealElements.forEach((el) => {
                el.classList.add("active");
            });

            if ("IntersectionObserver" in window && revealElements.length > 0) {
                const revealObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add("active");
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.05 });

                revealElements.forEach((el) => revealObserver.observe(el));
            }
        } catch (err) {
            console.warn("Scroll reveal error:", err);
        }
    })();

    // -------------------------------------------------------------------------
    // 4. PRODUCT SEARCH & CATEGORY FILTERING
    // -------------------------------------------------------------------------
    (function initProductSearch() {
        try {
            const searchInput = document.getElementById("product-search");
            const categoryButtons = document.querySelectorAll(".btn-filter, .skm-filter-btn");
            const productItems = document.querySelectorAll(".product-grid-item, .skm-product-item");
            const emptyNotice = document.getElementById("product-empty-notice");
            const resetSearchBtn = document.getElementById("resetSearchBtn");

            let currentCategory = "all";
            let searchQuery = "";

            function filterProducts() {
                let visibleCount = 0;

                productItems.forEach((item) => {
                    const name = (item.getAttribute("data-name") || "").toLowerCase();
                    const desc = (item.getAttribute("data-description") || "").toLowerCase();
                    const category = (item.getAttribute("data-category") || "all").toLowerCase();

                    const matchesCategory = currentCategory === "all" || category === currentCategory;
                    const matchesSearch = searchQuery === "" || name.includes(searchQuery) || desc.includes(searchQuery);

                    if (matchesCategory && matchesSearch) {
                        item.classList.remove("d-none");
                        item.style.display = "";
                        visibleCount++;
                    } else {
                        item.classList.add("d-none");
                        item.style.display = "none";
                    }
                });

                if (emptyNotice) {
                    if (visibleCount === 0) {
                        emptyNotice.classList.remove("d-none");
                    } else {
                        emptyNotice.classList.add("d-none");
                    }
                }
            }

            if (searchInput) {
                let debounceTimer;
                searchInput.addEventListener("input", function (e) {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        searchQuery = e.target.value.trim().toLowerCase();
                        filterProducts();
                    }, 120);
                });
            }

            if (categoryButtons.length > 0) {
                categoryButtons.forEach((btn) => {
                    btn.addEventListener("click", function () {
                        categoryButtons.forEach((b) => b.classList.remove("active"));
                        this.classList.add("active");
                        currentCategory = (this.getAttribute("data-filter") || "all").toLowerCase();
                        filterProducts();
                    });
                });
            }

            if (resetSearchBtn) {
                resetSearchBtn.addEventListener("click", function () {
                    if (searchInput) searchInput.value = "";
                    searchQuery = "";
                    currentCategory = "all";
                    categoryButtons.forEach((b) => {
                        if (b.getAttribute("data-filter") === "all") b.classList.add("active");
                        else b.classList.remove("active");
                    });
                    filterProducts();
                });
            }
        } catch (err) {
            console.warn("Product search error:", err);
        }
    })();

    // -------------------------------------------------------------------------
    // 5. PRODUCT QUICK VIEW MODAL & RFQ PRE-FILL
    // -------------------------------------------------------------------------
    (function initQuickView() {
        try {
            const quickViewButtons = document.querySelectorAll(".btn-quick-view");
            const qvImage = document.getElementById("qvProductImage");
            const qvName = document.getElementById("qvProductName");
            const qvDesc = document.getElementById("qvProductDesc");
            const qvStockBadge = document.getElementById("qvStockBadge");
            const qvStars = document.getElementById("qvStars");
            const qvRatingAvg = document.getElementById("qvRatingAvg");
            const qvRatingCount = document.getElementById("qvRatingCount");
            const qvWhatsAppBtn = document.getElementById("qvWhatsAppBtn");
            const qvRfqBtn = document.querySelector(".btn-qv-rfq");

            let currentSelectedProductForRfq = "";
            let currentSelectedProductId = 0;

            quickViewButtons.forEach((btn) => {
                btn.addEventListener("click", function () {
                    const id = parseInt(this.getAttribute("data-id") || "0", 10);
                    const name = this.getAttribute("data-name") || "Produk Seafood";
                    const desc = this.getAttribute("data-description") || "";
                    const stock = parseInt(this.getAttribute("data-stock") || "0", 10);
                    const image = this.getAttribute("data-image") || "";
                    const rating = parseFloat(this.getAttribute("data-rating") || "0").toFixed(1);
                    const count = this.getAttribute("data-count") || "0";

                    currentSelectedProductForRfq = name;
                    currentSelectedProductId = id;

                    if (qvName) qvName.textContent = name;
                    if (qvDesc) qvDesc.textContent = desc;

                    if (qvImage) {
                        if (image && image !== "") {
                            qvImage.src = "public/assets/images/" + encodeURIComponent(image);
                        } else {
                            qvImage.src = "public/assets/images/logo.png";
                        }
                    }

                    if (qvStockBadge) {
                        if (stock > 20) {
                            qvStockBadge.className = "badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fs-6";
                            qvStockBadge.innerHTML = `<i class="fas fa-check-circle me-1"></i> Stok Tersedia (${stock} kg)`;
                        } else if (stock > 0) {
                            qvStockBadge.className = "badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2 rounded-pill fs-6";
                            qvStockBadge.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i> Stok Terbatas (${stock} kg)`;
                        } else {
                            qvStockBadge.className = "badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill fs-6";
                            qvStockBadge.innerHTML = `<i class="fas fa-times-circle me-1"></i> Stok Habis (0 kg)`;
                        }
                    }

                    if (qvStars) {
                        const roundedRating = Math.round(rating);
                        let starHtml = "";
                        for (let i = 1; i <= 5; i++) {
                            starHtml += i <= roundedRating ? '<i class="fas fa-star"></i> ' : '<i class="far fa-star"></i> ';
                        }
                        qvStars.innerHTML = starHtml;
                    }

                    if (qvRatingAvg) qvRatingAvg.textContent = rating > 0 ? rating : "0.0";
                    if (qvRatingCount) qvRatingCount.textContent = `(${count} ulasan)`;

                    if (qvWhatsAppBtn) {
                        const waMessage = `Halo PT Samudra Kencana Mina, saya tertarik dengan produk ${name}. Saya ingin mengetahui informasi harga dan ketersediaan pasokannya.`;
                        qvWhatsAppBtn.href = `https://wa.me/62318547202?text=${encodeURIComponent(waMessage)}`;
                    }
                });
            });

            if (qvRfqBtn) {
                qvRfqBtn.addEventListener("click", function () {
                    const rfqModalEl = document.getElementById("rfqModal");
                    if (rfqModalEl && typeof bootstrap !== "undefined") {
                        const rfqSelect = document.getElementById("rfqProductSelect");
                        const rfqIdInput = document.getElementById("rfqProductId");
                        if (rfqSelect && currentSelectedProductForRfq) {
                            rfqSelect.value = currentSelectedProductForRfq;
                        }
                        if (rfqIdInput && currentSelectedProductId) {
                            rfqIdInput.value = currentSelectedProductId;
                        }
                        const rfqModalInstance = bootstrap.Modal.getInstance(rfqModalEl) || new bootstrap.Modal(rfqModalEl);
                        rfqModalInstance.show();
                    }
                });
            }

            const rfqTriggers = document.querySelectorAll(".btn-rfq-trigger");
            rfqTriggers.forEach((btn) => {
                btn.addEventListener("click", function () {
                    const productName = this.getAttribute("data-product-name") || "";
                    const productId = this.getAttribute("data-product-id") || "";
                    const rfqSelect = document.getElementById("rfqProductSelect");
                    const rfqIdInput = document.getElementById("rfqProductId");
                    if (rfqSelect && productName) {
                        rfqSelect.value = productName;
                    }
                    if (rfqIdInput && productId) {
                        rfqIdInput.value = productId;
                    }
                });
            });
        } catch (err) {
            console.warn("Quick view modal error:", err);
        }
    })();

    // -------------------------------------------------------------------------
    // 6. REQUEST FOR QUOTATION (RFQ) MODAL & WHATSAPP GENERATOR
    // -------------------------------------------------------------------------
    (function initRfqModal() {
        const rfqForm = document.getElementById("rfqForm");
        const btnSendRfqWhatsApp = document.getElementById("btnSendRfqWhatsApp");
        const rfqModalBody = document.getElementById("rfqModalBody");
        const rfqModalEl = document.getElementById("rfqModal");

        if (!rfqForm) return;

        // Guard against duplicate initialization
        if (rfqForm.dataset.initialized === "true") return;
        rfqForm.dataset.initialized = "true";

        function getRfqFormData() {
            const productSelect = document.getElementById("rfqProductSelect");
            const selectedOption = productSelect ? productSelect.options[productSelect.selectedIndex] : null;
            const productId = selectedOption ? (selectedOption.getAttribute("data-id") || "") : "";
            const product = productSelect ? productSelect.value.trim() : "";

            const quantity = document.getElementById("rfqQuantity")?.value.trim() || "";
            const name = document.getElementById("rfqName")?.value.trim() || "";
            const company = document.getElementById("rfqCompany")?.value.trim() || "";
            const whatsapp = document.getElementById("rfqWhatsApp")?.value.trim() || "";
            const email = document.getElementById("rfqEmail")?.value.trim() || "";
            const notes = document.getElementById("rfqNotes")?.value.trim() || "";

            return { product, productId, quantity, name, company, whatsapp, email, notes };
        }

        function renderRfqSuccessCard(refNumber, data) {
            if (!rfqModalBody) return;

            const waText = `Halo PT Samudra Kencana Mina,\nSaya telah mengajukan Permintaan Penawaran melalui website:\n\n*No. Referensi:* ${refNumber}\n*Nama Pemesan:* ${data.name}\n${data.company ? `*Perusahaan:* ${data.company}\n` : ""}*Produk:* ${data.product}\n*Estimasi Kebutuhan:* ${data.quantity}\n*Kontak / WA:* ${data.whatsapp}\n${data.notes ? `*Catatan:* ${data.notes}\n` : ""}\nMohon informasi harga dan ketersediaan pasokannya. Terima kasih.`;
            const waUrl = `https://wa.me/62318547202?text=${encodeURIComponent(waText)}`;

            rfqModalBody.innerHTML = `
                <div class="p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-circle mb-3" style="width: 64px; height: 64px; font-size: 1.75rem;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">Permintaan Penawaran Berhasil Dikirim!</h4>
                    <p class="text-muted small mb-3">Terima kasih. Permintaan Anda telah tersimpan di sistem kami dengan nomor referensi resmi:</p>
                    
                    <div class="card border border-primary-subtle bg-light p-3 rounded-4 mb-4 text-start">
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <span class="small text-muted">Nomor Referensi:</span>
                            <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill font-monospace">${refNumber}</span>
                        </div>
                        <div class="small mb-1"><strong>Produk:</strong> ${data.product || "Seafood"}</div>
                        <div class="small mb-1"><strong>Estimasi Kebutuhan:</strong> ${data.quantity}</div>
                        <div class="small mb-1"><strong>Nama Pemesan:</strong> ${data.name}</div>
                        <div class="small mb-0"><strong>WhatsApp:</strong> ${data.whatsapp}</div>
                    </div>

                    <p class="small text-muted mb-4">Tim sales PT Samudra Kencana Mina akan segera menghubungi nomor WhatsApp Anda pada jam kerja.</p>

                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <a href="${waUrl}" target="_blank" rel="noopener noreferrer" class="btn btn-success rounded-pill px-4 fw-semibold">
                            <i class="fab fa-whatsapp me-2"></i> Konfirmasi via WhatsApp Kantor
                        </a>
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </div>
            `;
        }

        // Form Submit Handler
        rfqForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const data = getRfqFormData();

            if (!data.product || !data.quantity || !data.name || !data.whatsapp) {
                window.skmToast?.show("Mohon lengkapi Produk, Estimasi Jumlah, Nama, dan Nomor WhatsApp.", "warning");
                return;
            }

            const submitBtn = document.getElementById("btnSubmitRfqForm") || this.querySelector("button[type='submit']");
            const originalBtnHtml = submitBtn ? submitBtn.innerHTML : "";

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin me-1"></i> Mengirim Permintaan...`;
            }

            const formData = new FormData(this);
            formData.set("is_ajax", "1");
            formData.set("product_name", data.product);
            formData.set("product_id", data.productId);
            formData.set("quantity", data.quantity);
            formData.set("name", data.name);
            formData.set("company", data.company);
            formData.set("phone", data.whatsapp);
            formData.set("email", data.email);
            formData.set("message", data.notes);

            fetch("?route=inquiry/store", {
                method: "POST",
                body: formData,
            })
                .then((res) => res.json())
                .then((resData) => {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnHtml;
                    }

                    if (resData.success) {
                        const refNumber = resData.reference_number || "SKM-INQ";
                        window.skmToast?.show(`Permintaan Penawaran Berhasil! Ref: ${refNumber}`, "success", 5000);
                        renderRfqSuccessCard(refNumber, data);
                    } else {
                        window.skmToast?.show(resData.error || "Gagal mengirim permintaan penawaran.", "error");
                    }
                })
                .catch((err) => {
                    console.error("RFQ Form submission error:", err);
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnHtml;
                    }
                    window.skmToast?.show("Terjadi kendala koneksi saat mengirimkan penawaran.", "error");
                });
        });

        // Send via WhatsApp Button Handler
        if (btnSendRfqWhatsApp) {
            btnSendRfqWhatsApp.addEventListener("click", function () {
                const data = getRfqFormData();

                if (!data.product || !data.quantity || !data.name || !data.whatsapp) {
                    window.skmToast?.show("Mohon lengkapi Produk, Estimasi Jumlah, Nama, dan Nomor WhatsApp.", "warning");
                    return;
                }

                const originalBtnHtml = btnSendRfqWhatsApp.innerHTML;
                btnSendRfqWhatsApp.disabled = true;
                btnSendRfqWhatsApp.innerHTML = `<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...`;

                const formData = new FormData(rfqForm);
                formData.set("is_ajax", "1");
                formData.set("product_name", data.product);
                formData.set("product_id", data.productId);
                formData.set("quantity", data.quantity);
                formData.set("name", data.name);
                formData.set("company", data.company);
                formData.set("phone", data.whatsapp);
                formData.set("email", data.email);
                formData.set("message", data.notes);

                fetch("?route=inquiry/store", {
                    method: "POST",
                    body: formData,
                })
                    .then((res) => res.json())
                    .then((resData) => {
                        btnSendRfqWhatsApp.disabled = false;
                        btnSendRfqWhatsApp.innerHTML = originalBtnHtml;

                        const refNumber = resData.reference_number || "SKM-INQ";
                        const waMessage = `Halo PT Samudra Kencana Mina,\nSaya ingin mengajukan permintaan penawaran harga pasokan seafood:\n\n*No. Referensi:* ${refNumber}\n*Nama Pemesan:* ${data.name}\n${data.company ? `*Perusahaan:* ${data.company}\n` : ""}*Produk:* ${data.product}\n*Estimasi Kebutuhan:* ${data.quantity}\n*Kontak / WhatsApp:* ${data.whatsapp}\n${data.notes ? `*Catatan Spesifikasi:* ${data.notes}\n` : ""}\nMohon informasi harga dan jadwal pasokan. Terima kasih.`;
                        const waUrl = `https://wa.me/62318547202?text=${encodeURIComponent(waMessage)}`;

                        window.open(waUrl, "_blank", "noopener,noreferrer");
                        window.skmToast?.show(`Permintaan Penawaran Tersimpan! Ref: ${refNumber}`, "success", 5000);
                        renderRfqSuccessCard(refNumber, data);
                    })
                    .catch((err) => {
                        console.error("WhatsApp RFQ error:", err);
                        btnSendRfqWhatsApp.disabled = false;
                        btnSendRfqWhatsApp.innerHTML = originalBtnHtml;
                        window.skmToast?.show("Terjadi kendala saat memproses WhatsApp.", "error");
                    });
            });
        }
    })();

    // -------------------------------------------------------------------------
    // 7. INTERACTIVE STAR RATING PICKER & MODAL
    // -------------------------------------------------------------------------
    (function initStarRating() {
        try {
            const rateModalTriggers = document.querySelectorAll(".btn-rate-modal-trigger");
            const modalRatingProductId = document.getElementById("modalRatingProductId");
            const modalRatingProductName = document.getElementById("modalRatingProductName");
            const modalRatingScoreInput = document.getElementById("modalRatingScoreInput");
            const ratingFeedbackLabel = document.getElementById("ratingFeedbackLabel");
            const starPickerStars = document.querySelectorAll(".skm-picker-star");

            const ratingLabels = {
                1: "1 — Sangat Kurang",
                2: "2 — Kurang Baik",
                3: "3 — Cukup",
                4: "4 — Baik (Puas)",
                5: "5 — Sangat Baik (Sangat Puas)"
            };

            function setStarScore(score) {
                if (modalRatingScoreInput) modalRatingScoreInput.value = score;
                if (ratingFeedbackLabel) ratingFeedbackLabel.textContent = ratingLabels[score] || `${score} Bintang`;

                starPickerStars.forEach((star) => {
                    const starScore = parseInt(star.getAttribute("data-score") || "0", 10);
                    if (starScore <= score) {
                        star.classList.add("active");
                    } else {
                        star.classList.remove("active");
                    }
                });
            }

            rateModalTriggers.forEach((btn) => {
                btn.addEventListener("click", function () {
                    const productId = this.getAttribute("data-product-id");
                    const productName = this.getAttribute("data-product-name") || "Produk Seafood";

                    if (modalRatingProductId) modalRatingProductId.value = productId;
                    if (modalRatingProductName) modalRatingProductName.textContent = productName;

                    setStarScore(5);
                });
            });

            starPickerStars.forEach((star) => {
                star.addEventListener("click", function () {
                    const score = parseInt(this.getAttribute("data-score") || "5", 10);
                    setStarScore(score);
                });

                star.addEventListener("mouseenter", function () {
                    const hoverScore = parseInt(this.getAttribute("data-score") || "5", 10);
                    starPickerStars.forEach((s) => {
                        const sScore = parseInt(s.getAttribute("data-score") || "0", 10);
                        if (sScore <= hoverScore) s.classList.add("active");
                        else s.classList.remove("active");
                    });
                    if (ratingFeedbackLabel) ratingFeedbackLabel.textContent = ratingLabels[hoverScore];
                });
            });

            const starContainer = document.getElementById("starPickerContainer");
            if (starContainer) {
                starContainer.addEventListener("mouseleave", function () {
                    const currentScore = parseInt(modalRatingScoreInput?.value || "5", 10);
                    setStarScore(currentScore);
                });
            }
        } catch (err) {
            console.warn("Rating picker error:", err);
        }
    })();

    // -------------------------------------------------------------------------
    // 8. QUICK CONTACT HELPER STUB
    // -------------------------------------------------------------------------
    window.closeFloatingMenu = function () {
        // Safe no-op stub
    };

    // -------------------------------------------------------------------------
    // 9. FORUM COMMENT FORM & CHARACTER COUNTER
    // -------------------------------------------------------------------------
    (function initForumComment() {
        try {
            const commentInput = document.getElementById("user-comment");
            const commentCharCount = document.getElementById("commentCharCount");
            const commentForm = document.getElementById("commentForm");

            if (commentInput && commentCharCount) {
                commentInput.addEventListener("input", function () {
                    const length = this.value.length;
                    commentCharCount.textContent = `${length} / 5000`;
                    if (length > 4800) {
                        commentCharCount.className = "text-danger small fw-bold";
                    } else {
                        commentCharCount.className = "text-muted small";
                    }
                });
            }

            if (commentForm) {
                commentForm.addEventListener("submit", function () {
                    const submitBtn = this.querySelector(".btn-submit-comment");
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin me-1"></i> Mengirim...`;
                    }
                });
            }
        } catch (err) {
            console.warn("Forum comment error:", err);
        }
    })();

    // -------------------------------------------------------------------------
    // 10. SKM AI CHAT ASSISTANT & INQUIRY SYSTEM (CUSTOMER AUTH AWARE)
    // -------------------------------------------------------------------------
    (function initAiChat() {
        try {
            const aiChatTrigger = document.getElementById("skmAiChatTrigger");
            const aiChatWindow = document.getElementById("skmAiChatWindow");
            const aiCloseChatBtn = document.getElementById("skmCloseChatBtn");
            const aiClearChatBtn = document.getElementById("skmClearChatBtn");
            const mobileAiChatBtn = document.getElementById("skmMobileAiChatBtn");
            const chatForm = document.getElementById("skmChatForm");
            const chatInput = document.getElementById("skmChatInput");
            const chatSendBtn = document.getElementById("skmChatSendBtn");
            const chatMessageContainer = document.getElementById("skmChatMessageContainer");
            const typingIndicator = document.getElementById("skmTypingIndicator");
            const chatCharCount = document.getElementById("skmChatCharCount");
            const quickPrompts = document.querySelectorAll(".skm-chip-prompt");
            const authBanner = document.getElementById("skmChatAuthBanner");

            if (!aiChatTrigger && !aiChatWindow) return;

            // Session Management
            let sessionId = localStorage.getItem("skm_ai_session_id");
            if (!sessionId) {
                sessionId = "SKM-CHAT-" + Math.random().toString(36).substring(2, 10) + Date.now().toString(36);
                localStorage.setItem("skm_ai_session_id", sessionId);
            }

            let currentCustomerUser = null;

            function escapeHtml(text) {
                if (!text) return "";
                const div = document.createElement("div");
                div.textContent = text;
                return div.innerHTML;
            }

            function formatAiText(raw) {
                if (!raw) return "";
                let clean = raw.replace(/```inquiry_data\s*\{.*?\}\s*```/s, "").trim();
                let escaped = escapeHtml(clean);
                escaped = escaped.replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>");
                escaped = escaped.replace(/^[•\-\*]\s+(.*)$/gm, "<li class='ms-3'>$1</li>");
                escaped = escaped.replace(/\n/g, "<br>");
                return escaped;
            }

            function scrollChatToBottom() {
                if (chatMessageContainer) {
                    chatMessageContainer.scrollTop = chatMessageContainer.scrollHeight;
                }
            }

            function appendMessage(sender, text, timestamp = null, inquiryData = null) {
                if (!chatMessageContainer) return;

                const timeStr = timestamp ? new Date(timestamp).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" }) : new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
                const row = document.createElement("div");
                row.className = `skm-chat-bubble-row ${sender === "user" ? "user-row" : "ai-row"}`;

                if (sender === "ai") {
                    let inquiryHtml = "";
                    if (inquiryData) {
                        const isUserLoggedIn = (currentCustomerUser !== null);
                        inquiryHtml = `
                            <div class="skm-chat-inquiry-card" data-inquiry='${escapeHtml(JSON.stringify(inquiryData))}'>
                                <h6><i class="fas fa-file-invoice text-primary me-1"></i> Rangkuman Permintaan Penawaran</h6>
                                <div class="skm-chat-inquiry-item"><strong>Produk:</strong> ${escapeHtml(inquiryData.product_name || "Seafood")}</div>
                                <div class="skm-chat-inquiry-item"><strong>Jumlah:</strong> ${escapeHtml(inquiryData.quantity || "-")}</div>
                                <div class="skm-chat-inquiry-item"><strong>Pemesan:</strong> ${escapeHtml(inquiryData.name || "-")}</div>
                                <div class="skm-chat-inquiry-item"><strong>WhatsApp:</strong> ${escapeHtml(inquiryData.phone || "-")}</div>
                                ${inquiryData.company ? `<div class="skm-chat-inquiry-item"><strong>Perusahaan:</strong> ${escapeHtml(inquiryData.company)}</div>` : ""}
                                
                                <div class="d-flex flex-wrap gap-2 mt-3 pt-2 border-top align-items-center">
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold btn-submit-chat-inquiry">
                                        <i class="fas fa-check-circle me-1"></i> Kirim Permintaan Penawaran
                                    </button>
                                    ${!isUserLoggedIn ? `
                                        <a href="?route=auth/login&return_to=${encodeURIComponent('?route=home#chat')}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-bold">
                                            <i class="fab fa-google text-warning me-1"></i> Masuk & Simpan di Akun
                                        </a>
                                    ` : ''}
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 btn-edit-chat-inquiry">
                                        <i class="fas fa-edit me-1"></i> Ubah Data
                                    </button>
                                </div>
                            </div>
                        `;
                    }

                    row.innerHTML = `
                        <div class="skm-chat-avatar ai-avatar">
                            <i class="fas fa-robot"></i>
                        </div>
                        <div class="skm-chat-bubble ai-bubble">
                            <div class="skm-chat-text">${formatAiText(text)}</div>
                            ${inquiryHtml}
                            <div class="skm-chat-time">${timeStr}</div>
                        </div>
                    `;
                } else {
                    const avatarContent = currentCustomerUser && currentCustomerUser.avatar ?
                        `<img src="${escapeHtml(currentCustomerUser.avatar)}" class="rounded-circle" width="32" height="32">` :
                        `<i class="fas fa-user"></i>`;

                    row.innerHTML = `
                        <div class="skm-chat-bubble user-bubble">
                            <div class="skm-chat-text">${escapeHtml(text).replace(/\n/g, "<br>")}</div>
                            <div class="skm-chat-time">${timeStr}</div>
                        </div>
                        <div class="skm-chat-avatar user-avatar">
                            ${avatarContent}
                        </div>
                    `;
                }

                chatMessageContainer.appendChild(row);
                scrollChatToBottom();
            }

            function openChatWindow() {
                if (aiChatWindow) {
                    aiChatWindow.classList.add("active");
                    if (chatInput) chatInput.focus();
                    scrollChatToBottom();
                }
            }

            function closeChatWindow() {
                if (aiChatWindow) {
                    aiChatWindow.classList.remove("active");
                }
            }

            if (aiChatTrigger) {
                aiChatTrigger.addEventListener("click", function (e) {
                    e.stopPropagation();
                    if (aiChatWindow && aiChatWindow.classList.contains("active")) {
                        closeChatWindow();
                    } else {
                        openChatWindow();
                    }
                });
            }

            if (mobileAiChatBtn) {
                mobileAiChatBtn.addEventListener("click", function (e) {
                    e.preventDefault();
                    openChatWindow();
                });
            }

            if (aiCloseChatBtn) {
                aiCloseChatBtn.addEventListener("click", function (e) {
                    e.stopPropagation();
                    closeChatWindow();
                });
            }

            if (aiClearChatBtn) {
                aiClearChatBtn.addEventListener("click", function () {
                    if (confirm("Mulai percakapan baru dengan SKM Assistant?")) {
                        localStorage.removeItem("skm_ai_session_id");
                        sessionId = "SKM-CHAT-" + Math.random().toString(36).substring(2, 10) + Date.now().toString(36);
                        localStorage.setItem("skm_ai_session_id", sessionId);
                        if (chatMessageContainer) {
                            const greetName = currentCustomerUser ? ` ${escapeHtml(currentCustomerUser.name.split(' ')[0])}` : '';
                            chatMessageContainer.innerHTML = `
                                <div class="skm-chat-bubble-row ai-row">
                                    <div class="skm-chat-avatar ai-avatar"><i class="fas fa-robot"></i></div>
                                    <div class="skm-chat-bubble ai-bubble">
                                        <div class="skm-chat-text">Halo${greetName}! 👋 Saya <strong>SKM Assistant</strong>. Percakapan baru telah dimulai. Ada yang bisa saya bantu mengenai produk seafood atau penawaran pasokan?</div>
                                        <div class="skm-chat-time">${new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })}</div>
                                    </div>
                                </div>
                            `;
                        }
                        window.skmToast?.show("Sesi percakapan baru telah siap.", "success");
                    }
                });
            }

            // Load Chat History on startup
            let historyLoaded = false;
            function loadChatHistory() {
                if (historyLoaded) return;
                historyLoaded = true;

                fetch(`?route=chat/init&session_id=${encodeURIComponent(sessionId)}`)
                    .then((res) => res.json())
                    .then((data) => {
                        if (data.success) {
                            if (data.logged_in && data.user) {
                                currentCustomerUser = data.user;

                                // Pre-fill RFQ Form if empty
                                const rfqNameInput = document.getElementById("rfqName");
                                const rfqEmailInput = document.getElementById("rfqEmail");
                                const rfqWhatsAppInput = document.getElementById("rfqWhatsApp");
                                const rfqCompanyInput = document.getElementById("rfqCompany");

                                if (rfqNameInput && !rfqNameInput.value) rfqNameInput.value = data.user.name || "";
                                if (rfqEmailInput && !rfqEmailInput.value) rfqEmailInput.value = data.user.email || "";
                                if (rfqWhatsAppInput && !rfqWhatsAppInput.value) rfqWhatsAppInput.value = data.user.phone || "";
                                if (rfqCompanyInput && !rfqCompanyInput.value) rfqCompanyInput.value = data.user.company || "";
                            }

                            if (Array.isArray(data.messages) && data.messages.length > 0) {
                                if (chatMessageContainer) chatMessageContainer.innerHTML = "";
                                data.messages.forEach((msg) => {
                                    let inqData = null;
                                    if (msg.sender_type === "ai") {
                                        const match = msg.message.match(/```inquiry_data\s*(\{.*?\})\s*```/s);
                                        if (match) {
                                            try { inqData = JSON.parse(match[1]); } catch (err) {}
                                        }
                                    }
                                    appendMessage(msg.sender_type, msg.message, msg.created_at, inqData);
                                });
                            }
                        }
                    })
                    .catch((err) => {
                        console.warn("Could not fetch chat history:", err);
                    });
            }
            loadChatHistory();

            // Auto-expanding textarea
            if (chatInput) {
                chatInput.addEventListener("input", function () {
                    this.style.height = "auto";
                    this.style.height = Math.min(this.scrollHeight, 100) + "px";
                    if (chatCharCount) {
                        chatCharCount.textContent = `${this.value.length}/3000`;
                    }
                });

                chatInput.addEventListener("keydown", function (e) {
                    if (e.key === "Enter" && !e.shiftKey) {
                        e.preventDefault();
                        if (chatForm) {
                            chatForm.dispatchEvent(new Event("submit", { cancelable: true, bubbles: true }));
                        }
                    }
                });
            }

            // Quick Prompt Suggestion Chips (5 interactive chips)
            quickPrompts.forEach((chip) => {
                chip.addEventListener("click", function () {
                    const promptText = this.getAttribute("data-prompt") || this.textContent.trim();
                    if (chatInput) {
                        chatInput.value = promptText;
                        chatInput.focus();
                        if (chatForm) {
                            chatForm.dispatchEvent(new Event("submit", { cancelable: true, bubbles: true }));
                        }
                    }
                });
            });

            // Chat Message Submission Handler
            if (chatForm) {
                chatForm.addEventListener("submit", function (e) {
                    e.preventDefault();
                    const message = chatInput.value.trim();
                    if (!message) return;

                    // 1. Immediately Render User Message to DOM
                    appendMessage("user", message);
                    chatInput.value = "";
                    chatInput.style.height = "auto";
                    if (chatCharCount) chatCharCount.textContent = "0/3000";

                    // 2. Show Typing Indicator & Loading State
                    if (typingIndicator) typingIndicator.classList.remove("d-none");
                    if (chatSendBtn) {
                        chatSendBtn.disabled = true;
                        chatSendBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;
                    }
                    scrollChatToBottom();

                    // 3. Send to Server via Fetch POST
                    const formData = new FormData();
                    formData.append("session_id", sessionId);
                    formData.append("message", message);

                    fetch("?route=chat/send", {
                        method: "POST",
                        body: formData,
                    })
                        .then((res) => res.json())
                        .then((data) => {
                            if (typingIndicator) typingIndicator.classList.add("d-none");
                            if (chatSendBtn) {
                                chatSendBtn.disabled = false;
                                chatSendBtn.innerHTML = `<i class="fas fa-paper-plane"></i>`;
                            }

                            if (data.success && data.ai_response) {
                                appendMessage("ai", data.ai_response.message, data.ai_response.created_at, data.ai_response.inquiry_data);
                            } else {
                                appendMessage("ai", "Maaf, terjadi kendala saat memproses jawaban. Silakan hubungi kantor kami via WhatsApp di +62 31 8547202.");
                            }
                        })
                        .catch((err) => {
                            console.error("Chat send error:", err);
                            if (typingIndicator) typingIndicator.classList.add("d-none");
                            if (chatSendBtn) {
                                chatSendBtn.disabled = false;
                                chatSendBtn.innerHTML = `<i class="fas fa-paper-plane"></i>`;
                            }
                            appendMessage("ai", "Maaf, koneksi jaringan sedang tidak stabil. Silakan coba lagi atau hubungi kantor kami di +62 31 8547202.");
                        });
                });
            }

            // In-Chat Inquiry Confirmation Button Handler
            if (chatMessageContainer) {
                chatMessageContainer.addEventListener("click", function (e) {
                    const submitInquiryBtn = e.target.closest(".btn-submit-chat-inquiry");
                    const editInquiryBtn = e.target.closest(".btn-edit-chat-inquiry");

                    if (submitInquiryBtn) {
                        const card = submitInquiryBtn.closest(".skm-chat-inquiry-card");
                        if (!card) return;

                        const rawJson = card.getAttribute("data-inquiry");
                        let inqData = {};
                        try { inqData = JSON.parse(rawJson); } catch (err) { return; }

                        submitInquiryBtn.disabled = true;
                        submitInquiryBtn.innerHTML = `<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan ke Database...`;

                        const formData = new FormData();
                        formData.append("is_ajax", "1");
                        formData.append("name", inqData.name || (currentCustomerUser ? currentCustomerUser.name : "Customer"));
                        formData.append("phone", inqData.phone || (currentCustomerUser ? currentCustomerUser.phone : ""));
                        formData.append("product_name", inqData.product_name || "");
                        formData.append("product_id", inqData.product_id || 0);
                        formData.append("quantity", inqData.quantity || "");
                        formData.append("company", inqData.company || (currentCustomerUser ? currentCustomerUser.company : ""));
                        formData.append("email", inqData.email || (currentCustomerUser ? currentCustomerUser.email : ""));
                        formData.append("message", inqData.message || "Permintaan penawaran via AI Chat");

                        fetch("?route=inquiry/store", {
                            method: "POST",
                            body: formData,
                        })
                            .then((res) => res.json())
                            .then((resData) => {
                                if (resData.success) {
                                    const refNum = resData.reference_number;
                                    card.innerHTML = `
                                        <div class="p-3 bg-success-subtle rounded-3 border border-success text-center">
                                            <div class="text-success fs-4 mb-1"><i class="fas fa-check-circle"></i></div>
                                            <h6 class="fw-bold text-success mb-1">Permintaan Penawaran Berhasil Disimpan!</h6>
                                            <div class="small text-muted mb-2">Nomor Referensi Anda:</div>
                                            <div class="badge bg-primary fs-6 px-3 py-2 rounded-pill font-monospace mb-3">${escapeHtml(refNum)}</div>
                                            <p class="small text-muted mb-3">Tim sales PT Samudra Kencana Mina akan segera menghubungi nomor WhatsApp Anda.</p>
                                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                                <a href="https://wa.me/62318547202?text=Halo%20PT%20Samudra%20Kencana%20Mina,%20saya%20telah%20mengirimkan%20Inquiry%20No:%20${encodeURIComponent(refNum)}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold">
                                                    <i class="fab fa-whatsapp me-1"></i> WhatsApp Kantor
                                                </a>
                                                <a href="?route=account" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                    <i class="fas fa-user-circle me-1"></i> Pantau di Akun
                                                </a>
                                            </div>
                                        </div>
                                    `;
                                    window.skmToast?.show(`Permintaan penawaran tersimpan dengan No: ${refNum}`, "success", 5000);
                                } else {
                                    submitInquiryBtn.disabled = false;
                                    submitInquiryBtn.innerHTML = `<i class="fas fa-check-circle me-1"></i> Coba Kirim Lagi`;
                                    window.skmToast?.show(resData.error || "Gagal menyimpan permintaan penawaran.", "error");
                                }
                            })
                            .catch((err) => {
                                console.error("Inquiry submit error:", err);
                                submitInquiryBtn.disabled = false;
                                submitInquiryBtn.innerHTML = `<i class="fas fa-check-circle me-1"></i> Coba Kirim Lagi`;
                                window.skmToast?.show("Terjadi kendala koneksi saat menyimpan penawaran.", "error");
                            });
                    }

                    if (editInquiryBtn) {
                        if (chatInput) {
                            chatInput.value = "Saya ingin mengubah data penawaran: ";
                            chatInput.focus();
                        }
                    }
                });
            }
        } catch (err) {
            console.warn("AI Chat init error:", err);
        }
    })();
});