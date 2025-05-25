// Import dependencies
import './bootstrap'; // Untuk memuat konfigurasi axios dan setup global lainnya
import { AntrianModule } from './modules/antrian/antrian-index.js';
import { getPusherManager } from './modules/antrian/pusher-manager.js';

// Inisialisasi AntrianModule saat DOM sudah siap
document.addEventListener('DOMContentLoaded', function () {
    console.log(import.meta.env.VITE_PUSHER_APP_KEY);
    const pusherConfig = {
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    };
   // Cek apakah Pusher sudah terhubung, jika belum baru inisialisasi
    if (!this.pusherManager || !this.pusherManager.isConnected()) {
        console.log('Inisialisasi Pusher');
        // Pastikan Pusher hanya diinisialisasi sekali
        this.pusherManager = getPusherManager(pusherConfig);
        
        // Inisialisasi instance dari AntrianModule
        const antrianModule = new AntrianModule({
            enableMonitor: true,  // Aktifkan monitor untuk memantau koneksi Pusher
            pusherConfig: pusherConfig,  // Pass pusherConfig ke AntrianModule
        });
    } else {
        console.log('Pusher sudah terhubung sebelumnya');
        // Jika sudah terhubung, tidak perlu inisialisasi ulang
        // Anda bisa melakukan tindakan lain jika diperlukan
    }

    // (Opsional) Menambahkan custom event listeners untuk pengujian atau debugging
    window.addEventListener('statistics:updated', (e) => {
        console.log('Updated statistics:', e.detail);
    });

    window.addEventListener('data:refreshed', (e) => {
        console.log('Data refreshed:', e.detail);
    });
});
