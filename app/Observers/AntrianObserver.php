<?php

namespace App\Observers;

use App\Models\Antrian;
use App\Models\Admin\RekamMedis;

class AntrianObserver
{
    public function created(Antrian $antrian)
    {
        // Buat rekam medis otomatis ketika antrian baru dibuat
        RekamMedis::create([
            'id_hewan' => $antrian->id_hewan,
            'id_dokter' => $antrian->id_dokter,
            'tanggal' => $antrian->tanggal,
            'deskripsi' => $antrian->keluhan ?? '', // Default dari keluhan
            'id_antrian' => $antrian->id,
        ]);
    }
}