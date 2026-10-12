```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan notelp hanya jika belum ada
        if (!Schema::hasColumn('users', 'notelp')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('notelp', 20)->nullable();
            });
        }

        // Tambahkan kolom laporan hanya jika belum ada
        Schema::table('buatlaporan', function (Blueprint $table) {
            if (!Schema::hasColumn('buatlaporan', 'kategori')) {
                $table->string('kategori')->nullable();
            }

            if (!Schema::hasColumn('buatlaporan', 'prioritas')) {
                $table->string('prioritas')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('buatlaporan', 'kategori')) {
            Schema::table('buatlaporan', function (Blueprint $table) {
                $table->dropColumn('kategori');
            });
        }

        if (Schema::hasColumn('buatlaporan', 'prioritas')) {
            Schema::table('buatlaporan', function (Blueprint $table) {
                $table->dropColumn('prioritas');
            });
        }

        if (Schema::hasColumn('users', 'notelp')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('notelp');
            });
        }
    }
};