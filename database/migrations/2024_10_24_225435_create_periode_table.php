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
        Schema::create('periode', function (Blueprint $table) {
            $table->bigIncrements('id_periode'); // Kolom id_periode
            $table->string('periode'); // Kolom periode
            $table->string('label');   // Kolom label
            $table->year('tahun');     // Kolom tahun
            $table->string('bulan');    // Kolom bulan
            $table->timestamps();       // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('periode');
    }
};
