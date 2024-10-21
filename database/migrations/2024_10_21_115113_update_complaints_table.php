<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->date('offence_date')->nullable();
            $table->string('detective_name')->nullable();
            $table->string('detective_phone')->nullable();
            $table->string('detective_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('offence_date');
            $table->dropColumn('detective_name');
            $table->dropColumn('detective_phone');
            $table->dropColumn('detective_email');
        });
    }
};
