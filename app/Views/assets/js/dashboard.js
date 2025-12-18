// dashboard.js - Main Dashboard JavaScript

class TPIDashboard {
    constructor() {
        this.init();
    }
    
    init() {
        this.initClock();
        this.initSearch();
        this.initHoverEffects();
        this.initKeyboardShortcuts();
        this.initPrintFunctionality();
        this.initDataRefresh();
        this.initThemeToggle();
        this.initOfflineDetection();
        this.initScrollToTop();
        this.initMobileMenu();
        this.initNotificationHandlers();
        this.initCharts();
    }
    
    initClock() {
        this.updateClock();
        setInterval(() => this.updateClock(), 60000);
    }
    
    updateClock() {
        const now = new Date();
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            timeElement.textContent = `${hours}:${minutes}`;
        }
        
        this.updateGreeting();
    }
    
    updateGreeting() {
        const now = new Date();
        let greeting = 'Pagi';
        if (now.getHours() >= 12 && now.getHours() < 17) {
            greeting = 'Siang';
        } else if (now.getHours() >= 17) {
            greeting = 'Malam';
        }
        
        const greetingElement = document.querySelector('.page-info p');
        if (greetingElement) {
            const nama = document.querySelector('.user-info h4')?.textContent || '';
            greetingElement.textContent = `Selamat ${greeting}, ${nama}`;
        }
    }
    
    initSearch() {
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.handleSearch(e.target.value);
            });
            
            // Debounce search
            this.debouncedSearch = this.debounce(this.handleSearch, 300);
            
            // Clear search on Escape
            searchInput.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    searchInput.value = '';
                    this.clearSearchResults();
                }
            });
        }
    }
    
    handleSearch(term) {
        if (term.length > 2) {
            console.log('Searching for:', term);
            this.showSearchLoading();
            
            // Simulate API call
            setTimeout(() => {
                this.showSearchResults(this.mockSearchResults(term));
            }, 500);
        } else if (term.length === 0) {
            this.clearSearchResults();
        }
    }
    
    mockSearchResults(term) {
        // Mock search results
        return [
            { id: 1, type: 'bakul', name: 'Budi ' + term, date: '2024-01-15', status: 'verified' },
            { id: 2, type: 'kapal', name: 'KM. ' + term, date: '2024-01-15', status: 'pending' },
            { id: 3, type: 'transaksi', name: 'Transaksi #TRX' + term, date: '2024-01-14', status: 'verified' }
        ];
    }
    
    showSearchLoading() {
        // Implement loading state
        console.log('Searching...');
    }
    
    showSearchResults(results) {
        console.log('Search results:', results);
        // Implement display of search results
    }
    
    clearSearchResults() {
        console.log('Clearing search results');
    }
    
    initHoverEffects() {
        // Add hover effects to cards
        document.querySelectorAll('.stat-card, .action-card, .summary-item').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-4px)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });
        
        // Add ripple effect to buttons
        document.querySelectorAll('.btn-primary, .btn-outline').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.7);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    width: ${size}px;
                    height: ${size}px;
                    top: ${y}px;
                    left: ${x}px;
                    pointer-events: none;
                `;
                
                this.appendChild(ripple);
                setTimeout(() => ripple.remove(), 600);
            });
        });
    }
    
    initKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl + / untuk focus search
            if (e.ctrlKey && e.key === '/') {
                e.preventDefault();
                document.querySelector('.search-input')?.focus();
            }
            
            // F1 untuk bantuan
            if (e.key === 'F1') {
                e.preventDefault();
                this.showHelpModal();
            }
            
            // F5 untuk refresh data
            if (e.key === 'F5' && !e.ctrlKey) {
                e.preventDefault();
                this.refreshDashboardData();
            }
            
            // Ctrl + P untuk print
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
            
            // Escape untuk close modals
            if (e.key === 'Escape') {
                this.closeAllModals();
            }
        });
    }
    
    showHelpModal() {
        const helpModal = new bootstrap.Modal(document.getElementById('helpModal'));
        helpModal.show();
    }
    
    closeAllModals() {
        document.querySelectorAll('.modal.show').forEach(modal => {
            bootstrap.Modal.getInstance(modal)?.hide();
        });
    }
    
    initPrintFunctionality() {
        // Add print button functionality
        const printBtn = document.querySelector('[title="Print"]');
        if (printBtn) {
            printBtn.addEventListener('click', () => {
                window.print();
            });
        }
        
        // Add print styles
        this.addPrintStyles();
    }
    
    addPrintStyles() {
        const style = document.createElement('style');
        style.textContent = `
            @media print {
                .no-print { display: none !important; }
                .print-only { display: block !important; }
                body { font-size: 12pt; }
                .stat-value { font-size: 24pt !important; }
            }
        `;
        document.head.appendChild(style);
    }
    
    initDataRefresh() {
        // Auto-refresh data setiap 30 detik
        this.refreshInterval = setInterval(() => {
            this.refreshStats();
        }, 30000);
        
        // Manual refresh button
        const refreshBtn = document.querySelector('[title="Refresh"]');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => this.refreshDashboardData());
        }
    }
    
    async refreshDashboardData() {
        try {
            this.showLoadingState();
            
            // Refresh all data
            await Promise.all([
                this.refreshStats(),
                this.refreshTransactions(),
                this.refreshNotifications()
            ]);
            
            this.hideLoadingState();
            this.showToast('Data berhasil diperbarui', 'success');
            
        } catch (error) {
            console.error('Failed to refresh data:', error);
            this.showToast('Gagal memperbarui data', 'error');
        }
    }
    
    async refreshStats() {
        try {
            const response = await fetch('/petugas/api/dashboard-stats');
            const data = await response.json();
            this.updateStats(data);
        } catch (error) {
            console.error('Failed to refresh stats:', error);
        }
    }
    
    updateStats(data) {
        // Update stat cards with new data
        const stats = {
            'total_bakul': document.querySelector('.stat-card:nth-child(1) .stat-value'),
            'total_kapal': document.querySelector('.stat-card:nth-child(2) .stat-value'),
            'pendapatan_harian': document.querySelector('.stat-card:nth-child(3) .stat-value'),
            'menunggu_verifikasi': document.querySelector('.stat-card:nth-child(4) .stat-value')
        };
        
        for (const [key, element] of Object.entries(stats)) {
            if (element && data[key]) {
                if (key === 'pendapatan_harian') {
                    element.textContent = `Rp ${this.formatNumber(data[key])}`;
                } else {
                    element.textContent = data[key];
                }
            }
        }
    }
    
    async refreshTransactions() {
        try {
            const response = await fetch('/petugas/api/recent-transactions');
            const data = await response.json();
            this.updateTransactionsTable(data);
        } catch (error) {
            console.error('Failed to refresh transactions:', error);
        }
    }
    
    updateTransactionsTable(transactions) {
        const tableBody = document.getElementById('transactionsTable');
        if (!tableBody) return;
        
        if (transactions.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                        <p class="text-muted">Belum ada transaksi hari ini</p>
                    </td>
                </tr>
            `;
            return;
        }
        
        let html = '';
        transactions.forEach(transaksi => {
            const statusClass = transaksi.status === 'verified' ? 'text-success' : 
                               transaksi.status === 'pending' ? 'text-warning' : 'text-danger';
            const statusIcon = transaksi.status === 'verified' ? 'check-circle' : 
                             transaksi.status === 'pending' ? 'clock' : 'times-circle';
            const badgeClass = transaksi.jenis === 'bakul' ? 'badge-blue' : 'badge-orange';
            
            html += `
                <tr>
                    <td><strong>#${transaksi.id}</strong></td>
                    <td>
                        <span class="type-badge ${badgeClass}">
                            ${transaksi.jenis === 'bakul' ? 'Bakul' : 'Kapal'}
                        </span>
                    </td>
                    <td>${transaksi.nama}</td>
                    <td>${transaksi.waktu}</td>
                    <td>
                        <i class="fas fa-${statusIcon} ${statusClass} me-1"></i>
                        ${this.capitalizeFirst(transaksi.status)}
                    </td>
                    <td>Rp ${this.formatNumber(transaksi.total)}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="/petugas/detail/${transaksi.id}" class="btn-icon btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            ${transaksi.status === 'pending' ? `
                            <a href="/petugas/verifikasi/${transaksi.id}" class="btn-icon btn-sm btn-success" title="Verifikasi">
                                <i class="fas fa-check"></i>
                            </a>
                            ` : ''}
                        </div>
                    </td>
                </tr>
            `;
        });
        
        tableBody.innerHTML = html;
    }
    
    async refreshNotifications() {
        try {
            const response = await fetch('/petugas/api/notifications');
            const data = await response.json();
            this.updateNotifications(data);
        } catch (error) {
            console.error('Failed to refresh notifications:', error);
        }
    }
    
    updateNotifications(notifications) {
        const notificationList = document.getElementById('notificationList');
        if (!notificationList) return;
        
        let html = '';
        notifications.forEach(notification => {
            const iconClass = notification.type === 'warning' ? 'icon-warning' :
                             notification.type === 'info' ? 'icon-info' : 'icon-success';
            const icon = notification.type === 'warning' ? 'exclamation' :
                        notification.type === 'info' ? 'info-circle' : 'check-circle';
            
            html += `
                <div class="notification-item ${notification.unread ? 'unread' : ''}">
                    <div class="notification-icon ${iconClass}">
                        <i class="fas fa-${icon}"></i>
                    </div>
                    <div class="notification-content">
                        <h4>${notification.title}</h4>
                        <p>${notification.message}</p>
                        <span class="notification-time">${notification.time}</span>
                    </div>
                </div>
            `;
        });
        
        notificationList.innerHTML = html;
    }
    
    initThemeToggle() {
        const themeToggle = document.getElementById('themeToggle');
        if (!themeToggle) return;
        
        // Check saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-mode');
            themeToggle.checked = true;
        }
        
        // Toggle theme
        themeToggle.addEventListener('change', () => {
            if (themeToggle.checked) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
            }
        });
    }
    
    initOfflineDetection() {
        window.addEventListener('online', () => this.updateConnectionStatus(true));
        window.addEventListener('offline', () => this.updateConnectionStatus(false));
        
        // Initial check
        this.updateConnectionStatus(navigator.onLine);
    }
    
    updateConnectionStatus(online) {
        const statusElement = document.getElementById('connectionStatus');
        if (!statusElement) return;
        
        const warningElement = document.querySelector('.offline-warning');
        
        if (online) {
            statusElement.innerHTML = '<i class="fas fa-circle"></i> Online';
            statusElement.className = 'text-success';
            if (warningElement) warningElement.style.display = 'none';
            
            // Sync data when back online
            this.syncPendingData();
            
        } else {
            statusElement.innerHTML = '<i class="fas fa-circle"></i> Offline';
            statusElement.className = 'text-danger';
            if (warningElement) warningElement.style.display = 'block';
        }
    }
    
    syncPendingData() {
        console.log('Syncing pending data...');
        // Implement offline data sync
    }
    
    initScrollToTop() {
        const scrollBtn = document.querySelector('.scroll-to-top');
        if (!scrollBtn) return;
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollBtn.classList.add('visible');
            } else {
                scrollBtn.classList.remove('visible');
            }
        });
        
        scrollBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    
    initMobileMenu() {
        const mobileMenuBtn = document.querySelector('.mobile-menu');
        const sidebar = document.querySelector('.sidebar');
        
        if (mobileMenuBtn && sidebar) {
            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 1024) {
                    if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                        sidebar.classList.remove('active');
                    }
                }
            });
        }
    }
    
    initNotificationHandlers() {
        // Mark all as read
        const markAllBtn = document.querySelector('[onclick="markAllAsRead()"]');
        if (markAllBtn) {
            markAllBtn.addEventListener('click', () => this.markAllNotificationsAsRead());
        }
        
        // Notification click handlers
        document.addEventListener('click', (e) => {
            if (e.target.closest('.notification-item')) {
                const notification = e.target.closest('.notification-item');
                notification.classList.remove('unread');
                // Handle notification click
            }
        });
    }
    
    markAllNotificationsAsRead() {
        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.classList.remove('unread');
        });
        
        // Update badge count
        const badge = document.querySelector('.btn-icon .badge');
        if (badge) {
            badge.style.display = 'none';
        }
        
        this.showToast('Semua notifikasi ditandai sudah dibaca', 'success');
    }
    
    initCharts() {
        // Chart initialization is done inline in dashboard.php
        // This method can be used for dynamic chart updates
    }
    
    showLoadingState() {
        // Show loading overlay
        const overlay = document.createElement('div');
        overlay.id = 'loadingOverlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        `;
        
        overlay.innerHTML = `
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
        `;
        
        document.body.appendChild(overlay);
    }
    
    hideLoadingState() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) {
            overlay.remove();
        }
    }
    
    showToast(message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        // Add to container
        const container = document.getElementById('toastContainer') || this.createToastContainer();
        container.appendChild(toast);
        
        // Initialize and show
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remove after hide
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }
    
    createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toastContainer';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        `;
        document.body.appendChild(container);
        return container;
    }
    
    // Utility functions
    formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    capitalizeFirst(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Initialize dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Add ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
    
    // Initialize dashboard
    window.dashboard = new TPIDashboard();
    
    // Global functions for inline event handlers
    window.toggleSidebar = () => {
        document.querySelector('.sidebar')?.classList.toggle('active');
    };
    
    window.scrollToTop = () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
    
    window.refreshTransactions = () => {
        window.dashboard.refreshTransactions();
    };
    
    window.markAllAsRead = () => {
        window.dashboard.markAllNotificationsAsRead();
    };
});

// Service Worker for PWA
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js')
            .then(registration => {
                console.log('ServiceWorker registered: ', registration.scope);
            })
            .catch(error => {
                console.log('ServiceWorker registration failed: ', error);
            });
    });
}