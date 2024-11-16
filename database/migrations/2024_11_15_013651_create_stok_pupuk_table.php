<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stok_pupuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_distributor')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_jenis_pupuk')->constrained('jenis_pupuk')->onDelete('cascade');
            $table->integer('jumlah_pengajuan');
            $table->integer('jumlah_diterima')->default(0);
            //diterima == 0 belum, 1 diterima , 2 ditolak
            $table->boolean('diterima')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stok_pupuk');
    }
};