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
        if (!Schema::hasColumn('penilaian', 'kriteria_id')) {
            Schema::table('penilaian', function (Blueprint $table) {
                $table->integer('kriteria_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('penilaian', 'kriteria_id')) {
            Schema::table('penilaian', function (Blueprint $table) {
                $table->dropColumn('kriteria_id');
            });
        }
    }
};
