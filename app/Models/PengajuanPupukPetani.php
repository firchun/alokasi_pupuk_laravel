<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanPupukPetani extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_pupuk_petani';
    protected $guarded = [];
    public function poktan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_poktan');
    }
    public function anggota(): BelongsTo
    {
        return $this->belongsTo(KelompokTani::class, 'id_anggota');
    }
    public function jenis_pupuk(): BelongsTo
    {
        return $this->belongsTo(JenisPupuk::class, 'id_jenis_pupuk');
    }
}
