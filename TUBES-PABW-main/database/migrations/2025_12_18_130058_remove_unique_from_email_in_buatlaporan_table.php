<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasIndex('buatlaporan', 'buatlaporan_email_unique')) {
            Schema::table('buatlaporan', function (Blueprint $table) {
                $table->dropUnique('buatlaporan_email_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::table('buatlaporan', function (Blueprint $table) {
            $table->unique('email');
        });
    }
};
