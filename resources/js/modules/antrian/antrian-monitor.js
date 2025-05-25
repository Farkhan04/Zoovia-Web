// resources/js/modules/antrian/antrian-monitor.js
export class AntrianMonitor {
    constructor(antrianRealtime) {
        this.antrianRealtime = antrianRealtime;
        this.connectionStartTime = null;
        this.eventsCount = 0;
        this.reconnectCount = 0;
        this.uptimeInterval = null;
        
        this.init();
    }
    
    init() {
        // Listen to events
        window.addEventListener('antrian:updated', () => {
            this.eventsCount++;
            this.updateUI();
        });
        
        // Monitor connection
        this.antrianRealtime.pusherManager.onConnectionStateChange((currentState, previousState) => {
            this.onConnectionStateChange(currentState, previousState);
        });
    }
    
    onConnectionStateChange(currentState, previousState) {
        if (currentState === 'connected') {
            this.connectionStartTime = Date.now();
            this.startUptimeCounter();
            
            if (previousState === 'disconnected' || previousState === 'failed') {
                this.reconnectCount++;
            }
        } else if (currentState === 'disconnected' || currentState === 'failed') {
            this.stopUptimeCounter();
        }
        
        this.updateUI();
    }
    
    startUptimeCounter() {
        this.stopUptimeCounter();
        
        this.uptimeInterval = setInterval(() => {
            this.updateUptime();
        }, 1000);
    }
    
    stopUptimeCounter() {
        if (this.uptimeInterval) {
            clearInterval(this.uptimeInterval);
            this.uptimeInterval = null;
        }
    }
    
    updateUptime() {
        if (this.connectionStartTime) {
            const uptime = Date.now() - this.connectionStartTime;
            const hours = Math.floor(uptime / 3600000);
            const minutes = Math.floor((uptime % 3600000) / 60000);
            const seconds = Math.floor((uptime % 60000) / 1000);
            
            const uptimeString = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            
            // Update UI
            const uptimeElement = document.getElementById('connection-uptime');
            if (uptimeElement) {
                uptimeElement.textContent = uptimeString;
            }
        }
    }
    
    updateUI() {
        // Update connection status
        const state = this.antrianRealtime.pusherManager.getConnectionState();
        const statusElement = document.getElementById('connection-status-text');
        if (statusElement) {
            statusElement.textContent = state;
        }
        
        // Update counters
        const eventsElement = document.getElementById('events-received');
        if (eventsElement) {
            eventsElement.textContent = this.eventsCount;
        }
        
        const reconnectElement = document.getElementById('reconnect-count');
        if (reconnectElement) {
            reconnectElement.textContent = this.reconnectCount;
        }
    }
    
    destroy() {
        this.stopUptimeCounter();
    }
}