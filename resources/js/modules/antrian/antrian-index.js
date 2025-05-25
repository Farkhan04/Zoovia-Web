// resources/js/modules/antrian/index.js
import { AntrianRealtime } from './antrian-realtime.js';
import { AntrianMonitor } from './antrian-monitor.js';

export class AntrianModule {
    constructor(config = {}) {
        this.config = {
            enableMonitor: false,
            pusherConfig: {},
            ...config
        };
        
        this.antrianRealtime = null;
        this.antrianMonitor = null;
        
        this.init();
    }
    
    init() {
        // Initialize Antrian Realtime
        this.antrianRealtime = new AntrianRealtime({
            onUpdate: this.handleAntrianUpdate.bind(this),
            ...this.config
        });
        
        // Initialize Monitor if enabled
        if (this.config.enableMonitor) {
            this.antrianMonitor = new AntrianMonitor(this.antrianRealtime);
        }
        
        // Setup UI event listeners
        this.setupUIListeners();
        
        // Listen to custom events
        window.addEventListener('statistics:updated', (e) => {
            this.updateStatisticsUI(e.detail);
        });
        
        window.addEventListener('data:refreshed', (e) => {
            this.refreshTableUI();
        });
    }
    
    handleAntrianUpdate(data) {
        // Update current and next queue UI
        this.updateQueueDisplay(data);
        
        // Refresh table if needed
        if (data.action === 'create' || data.action === 'update-status') {
            this.refreshTableUI();
        }
        
        // Show notification
        this.showNotification(data);
    }
    
    updateStatisticsUI(statistics) {
        // Animate number changes
        this.animateNumber('#total-antrian', statistics.total);
        this.animateNumber('#waiting-antrian', statistics.waiting);
        this.animateNumber('#processing-antrian', statistics.processing);
        this.animateNumber('#completed-antrian', statistics.completed);
    }
    
    updateQueueDisplay(data) {
        // Update current queue
        if (data.queueSummary.current_number > 0) {
            this.showElement('.current-queue-container');
            this.updateText('#current-number', data.queueSummary.current_number);
            
            if (data.action === 'update-status' && data.antrian.status === 'diproses') {
                this.updateText('#current-name', data.antrian.nama);
                this.updateText('#current-service', data.antrian.layanan.nama_layanan);
            }
        } else {
            this.hideElement('.current-queue-container');
        }
        
        // Update next queue
        if (data.queueSummary.next_number > 0) {
            this.showElement('.next-queue-container');
            this.updateText('#next-number', data.queueSummary.next_number);
        } else {
            this.hideElement('.next-queue-container');
        }
    }
    
    refreshTableUI() {
        // Throttled refresh
        if (this.refreshTimeout) {
            clearTimeout(this.refreshTimeout);
        }
        
        this.refreshTimeout = setTimeout(() => {
            fetch(window.location.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTableBody = doc.querySelector('#antrian-table-body');
                
                if (newTableBody) {
                    const currentTableBody = document.querySelector('#antrian-table-body');
                    if (currentTableBody) {
                        currentTableBody.innerHTML = newTableBody.innerHTML;
                        this.reinitializeTooltips();
                    }
                }
            })
            .catch(error => {
                console.error('Error refreshing table:', error);
            });
        }, 1000);
    }
    
    animateNumber(selector, newValue) {
        const element = document.querySelector(selector);
        if (!element) return;
        
        const currentValue = parseInt(element.textContent) || 0;
        if (currentValue === newValue) return;
        
        // Simple animation
        element.textContent = newValue;
        element.classList.add('pulse-animation');
        setTimeout(() => element.classList.remove('pulse-animation'), 600);
    }
    
    showNotification(data) {
        const type = data.action === 'create' ? 'success' : 'info';
        const message = data.action === 'create' 
            ? 'Antrian baru telah ditambahkan.' 
            : 'Status antrian telah diperbarui.';
        
        this.showToast(type, message);
    }
    
    showToast(type, message) {
        // Implementation sesuai dengan UI framework yang digunakan
        // Contoh untuk Bootstrap
        const toastHTML = `
            <div class="toast" role="alert">
                <div class="toast-header">
                    <strong class="me-auto">${type}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">${message}</div>
            </div>
        `;
        
        // Add to DOM and show
        // ...
    }
    
    setupUIListeners() {
        // Initialize tooltips
        this.reinitializeTooltips();
        
        // Handle visibility change
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden && !this.antrianRealtime.pusherManager.isConnected()) {
                console.log('Page visible again, checking connection...');
                this.antrianRealtime.pusherManager.initializePusher();
            }
        });
    }
    
    reinitializeTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Helper methods
    showElement(selector) {
        const element = document.querySelector(selector);
        if (element) {
            element.style.display = 'block';
        }
    }
    
    hideElement(selector) {
        const element = document.querySelector(selector);
        if (element) {
            element.style.display = 'none';
        }
    }
    
    updateText(selector, text) {
        const element = document.querySelector(selector);
        if (element) {
            element.textContent = text;
        }
    }
    
    destroy() {
        if (this.antrianRealtime) {
            this.antrianRealtime.destroy();
        }
        
        if (this.antrianMonitor) {
            this.antrianMonitor.destroy();
        }
        
        // Clear timeouts
        if (this.refreshTimeout) {
            clearTimeout(this.refreshTimeout);
        }
    }
}