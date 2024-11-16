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
        Schema::table('pengajuan_pupuk_petani', function (Blueprint $table) {
            $table->string('invoice')->after('id_jenis_pupuk')->unique();
            $table->boolean('diambil')->default(0)->after('diterima');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_pupuk_petani', function (Blueprint $table) {
            //
        });
    }
};
