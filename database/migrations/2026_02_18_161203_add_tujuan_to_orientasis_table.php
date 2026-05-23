<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('orientasis', function (Blueprint $table) {
        $table->longText('tujuan')->nullable()->after('course_id');
    });
}

public function down()
{
    Schema::table('orientasis', function (Blueprint $table) {
        $table->dropColumn('tujuan');
    });
}

};