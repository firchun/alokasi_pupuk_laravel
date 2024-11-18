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
    protected static function getStok($id_distributor, $id_jenis = null)
    {
        $stokQuery = Self::where('id_distributor', $id_distributor)
            ->where('diterima', 1);

        if ($id_jenis) {
            $stokQuery->where('id_jenis_pupuk', $id_jenis);
        }

        $stok = $stokQuery->sum('jumlah_diterima');

        $pengajuanQuery = PengajuanPupukPetani::where('diterima', 1);

        if ($id_jenis) {
            $pengajuanQuery->where('id_jenis_pupuk', $id_jenis);
        }

        // Jika pengurangan pengajuan hanya untuk distributor tertentu
        $pengajuan = $pengajuanQuery->sum('jumlah_diterima');

        return $stok - $pengajuan ?? 0;
    }
}
