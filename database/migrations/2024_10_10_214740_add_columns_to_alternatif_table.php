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
        Schema::table('alternatif', function (Blueprint $table) {
                $table->string('agama')->after('nik');
                $table->string('umur')->after('agama');
                $table->string('jk')->after('umur');
                $table->string('jabatan')->after('jk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alternatif', function (Blueprint $table) {
            $table->dropColumn(['agama', 'umur', 'jk', 'jabatan']);
        });
    }
};
