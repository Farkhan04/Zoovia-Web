import Pusher from "pusher-js";

// resources/js/modules/antrian/pusher-manager.js
export class PusherManager {
    constructor(config = {}) {
        this.config = {
            key: config.key,
            cluster: config.cluster,
            encrypted: true,
            authEndpoint: '/broadcasting/auth',
            ...config
        };

        this.pusher = null;
        this.channels = new Map();
        this.reconnectAttempts = 0;
        this.maxReconnectAttempts = 10;
        this.reconnectDelay = 1000;
        this.isConnecting = false;
        this.connectionStateCallbacks = [];
        if (!this.pusher || this.pusher.connection.state === 'disconnected') {
            this.initializePusher();
        }

        window.addEventListener('beforeunload', () => {
            if (this.pusher) {
                console.log("Disconnecting Pusher before page unload");
                this.pusher.disconnect(); 
            }
        });
    }

    initializePusher() {
        if (this.isConnecting || (this.pusher && this.pusher.connection.state === 'connected')) {
            console.log('Pusher sudah terkoneksi atau sedang menghubungkan');
            return;
        }

        this.isConnecting = true;

        try {
            this.pusher = new Pusher(this.config.key, {
                cluster: this.config.cluster,
                encrypted: this.config.encrypted,
                authEndpoint: this.config.authEndpoint,
                auth: {
                    headers: {
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content
                    }
                },
                enabledTransports: ['ws', 'wss'],
                disableStats: true,
                activityTimeout: 10000,
                pongTimeout: 5000,
                unavailableTimeout: 10000
            });

            this.setupConnectionListeners();

        } catch (error) {
            console.error('Error inisialisasi Pusher:', error);
            this.isConnecting = false;
            this.scheduleReconnect();
        }
    }

    setupConnectionListeners() {
        this.pusher.connection.bind('state_change', (states) => {
            console.log(`Pusher state: ${states.previous} → ${states.current}`);

            this.connectionStateCallbacks.forEach(callback => {
                callback(states.current, states.previous);
            });

            switch (states.current) {
                case 'connected':
                    console.log('✅ Pusher terkoneksi');
                    this.isConnecting = false;
                    this.reconnectAttempts = 0;
                    this.reconnectDelay = 1000;
                    this.resubscribeChannels();
                    break;

                case 'disconnected':
                case 'unavailable':
                    console.log('❌ Pusher terputus');
                    this.isConnecting = false;
                    this.scheduleReconnect();
                    break;

                case 'connecting':
                    console.log('🔄 Menghubungkan ke Pusher...');
                    break;

                case 'failed':
                    console.error('❌ Koneksi Pusher gagal');
                    this.isConnecting = false;
                    this.scheduleReconnect();
                    break;
            }
        });

        this.pusher.connection.bind('error', (error) => {
            console.error('Pusher connection error:', error);
        });
    }

    scheduleReconnect() {
        if (this.reconnectAttempts >= this.maxReconnectAttempts) {
            console.error('Max reconnect attempts reached');
            return;
        }

        this.reconnectAttempts++;
        const delay = Math.min(this.reconnectDelay * Math.pow(2, this.reconnectAttempts - 1), 30000);

        console.log(`Mencoba reconnect #${this.reconnectAttempts} dalam ${delay / 1000} detik...`);

        setTimeout(() => {
            if (this.pusher) {
                this.pusher.disconnect();
            }
            this.initializePusher();
        }, delay);
    }

    subscribe(channelName, eventCallbacks = {}) {
        if (this.channels.has(channelName)) {
            console.log(`Channel "${channelName}" sudah di-subscribe`);
            const channelInfo = this.channels.get(channelName);

            Object.entries(eventCallbacks).forEach(([event, callback]) => {
                if (!channelInfo.events[event]) {
                    channelInfo.events[event] = [];
                }
                channelInfo.events[event].push(callback);
                channelInfo.channel.bind(event, callback);
            });

            return channelInfo.channel;
        }

        const channel = this.pusher.subscribe(channelName);

        this.channels.set(channelName, {
            channel: channel,
            events: {}
        });

        Object.entries(eventCallbacks).forEach(([event, callback]) => {
            channel.bind(event, callback);
            if (!this.channels.get(channelName).events[event]) {
                this.channels.get(channelName).events[event] = [];
            }
            this.channels.get(channelName).events[event].push(callback);
        });

        channel.bind('pusher:subscription_succeeded', () => {
            console.log(`✅ Berhasil subscribe ke channel: ${channelName}`);
        });

        channel.bind('pusher:subscription_error', (error) => {
            console.error(`❌ Error subscribe ke channel ${channelName}:`, error);
        });

        return channel;
    }

    unsubscribe(channelName) {
        if (this.channels.has(channelName)) {
            const channelInfo = this.channels.get(channelName);

            Object.entries(channelInfo.events).forEach(([event, callbacks]) => {
                callbacks.forEach(callback => {
                    channelInfo.channel.unbind(event, callback);
                });
            });

            this.pusher.unsubscribe(channelName);
            this.channels.delete(channelName);

            console.log(`Unsubscribed dari channel: ${channelName}`);
        }
    }

    resubscribeChannels() {
        console.log('Re-subscribing ke semua channels...');

        this.channels.forEach((channelInfo, channelName) => {
            const newChannel = this.pusher.subscribe(channelName);

            Object.entries(channelInfo.events).forEach(([event, callbacks]) => {
                callbacks.forEach(callback => {
                    newChannel.bind(event, callback);
                });
            });

            channelInfo.channel = newChannel;
        });
    }

    onConnectionStateChange(callback) {
        this.connectionStateCallbacks.push(callback);
    }

    getConnectionState() {
        return this.pusher ? this.pusher.connection.state : 'disconnected';
    }

    isConnected() {
        return this.getConnectionState() === 'connected';
    }


    disconnect() {
        if (this.pusher) {
            this.channels.forEach((_, channelName) => {
                this.unsubscribe(channelName);
            });

            this.pusher.disconnect();
            this.pusher = null;
            this.isConnecting = false;
        }
    }
}

// Singleton instance
let instance = null;

export function getPusherManager(config) {
    if (!instance) {
        instance = new PusherManager(config);
    }
    return instance;
}