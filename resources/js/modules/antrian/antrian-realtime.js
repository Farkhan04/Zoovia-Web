// resources/js/modules/antrian/antrian-realtime.js
import { getPusherManager } from './pusher-manager.js';

export class AntrianRealtime {
    constructor(options = {}) {
        this.pusherManager = getPusherManager();
        this.channel = null;
        this.options = {
            channelName: 'antrian',
            eventName: 'App\\Events\\AntrianUpdated',
            onUpdate: null,
            ...options
        };
        
        this.lastUpdateTime = Date.now();
        this.statistics = {
            total: 0,
            waiting: 0,
            processing: 0,
            completed: 0
        };
        
        this.init();
    }
    
    init() {
        // Subscribe ke channel dengan event handler
        this.channel = this.pusherManager.subscribe(this.options.channelName, {
            [this.options.eventName]: this.handleAntrianUpdate.bind(this)
        });
        
        // Monitor koneksi
        this.pusherManager.onConnectionStateChange((currentState, previousState) => {
            if (currentState === 'connected' && previousState !== 'connecting') {
                this.onReconnected();
            }
        });
    }
    
    handleAntrianUpdate(data) {
        console.log('Antrian Updated:', data);
        
        // Prevent duplicate updates
        const now = Date.now();
        if (now - this.lastUpdateTime < 500) {
            console.log('Ignoring duplicate update');
            return;
        }
        this.lastUpdateTime = now;
        
        // Update statistics
        if (data.queueSummary) {
            this.updateStatistics(data.queueSummary);
        }
        
        // Call custom handler if provided
        if (this.options.onUpdate) {
            this.options.onUpdate(data);
        }
        
        // Emit custom event
        this.emit('antrian:updated', data);
    }
    
    updateStatistics(summary) {
        this.statistics = {
            total: summary.total || 0,
            waiting: summary.waiting || 0,
            processing: summary.processing || 0,
            completed: summary.completed || 0
        };
        
        this.emit('statistics:updated', this.statistics);
    }
    
    onReconnected() {
        console.log('Reconnected! Refreshing data...');
        this.refreshData();
    }
    
    refreshData() {
        // Fetch latest data dari server
        fetch(window.location.href + '?ajax=1', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.summary) {
                this.updateStatistics(data.summary);
            }
            this.emit('data:refreshed', data);
        })
        .catch(error => {
            console.error('Error refreshing data:', error);
        });
    }
    
    emit(eventName, data) {
        const event = new CustomEvent(eventName, { detail: data });
        window.dispatchEvent(event);
    }
    
    destroy() {
        if (this.channel) {
            this.pusherManager.unsubscribe(this.options.channelName);
            this.channel = null;
        }
    }
}