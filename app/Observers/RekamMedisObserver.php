<?php

namespace App\Observers;

use App\Models\Admin\RekamMedis;

class RekamMedisObserver
{
    public function updated(RekamMedis $rekamMedis)
    {
        // Update status antrian menjadi selesai ketika rekam medis diedit
        if ($rekamMedis->id_antrian) {
            $rekamMedis->antrian()->update(['status' => 'selesai']);
        }
    }
}