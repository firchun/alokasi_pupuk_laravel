<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokPupuk extends Model
{
    use HasFactory;
    protected $table = 'stok_pupuk';
    protected $guarded = [];
    public function distributor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_distributor');
    }

    public function jenis_pupuk(): BelongsTo
    {
        return $this->belongsTo(JenisPupuk::class, 'id_jenis_pupuk');
    }
    protected function getStok($id_distributor, $jenis = null)
    {
        $stok = Self::where('id_distributor', $id_distributor)
            ->where('diterima', 1)
            ->where('id_jenis_pupuk', $jenis)
            ->sum('jumlah_diterima') ?? 0;

        $pengajuan = PengajuanPupukPetani::where('diterima', 1)
            ->where('id_jenis_pupuk', $jenis)
            ->sum('jumlah_diterima') ?? 0;

        return $stok - $pengajuan ?? 0;
    }
}