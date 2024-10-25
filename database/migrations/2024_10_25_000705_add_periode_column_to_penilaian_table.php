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
        Schema::table('penilaian', function (Blueprint $table) {
            // Menambahkan kolom 'periode' dengan tipe data string
            $table->string('periode')->nullable()->after('kriteria_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penilaian', function (Blueprint $table) {
            // Menghapus kolom 'periode' jika dibatalkan
            $table->dropColumn('periode');
        });
    }
};
