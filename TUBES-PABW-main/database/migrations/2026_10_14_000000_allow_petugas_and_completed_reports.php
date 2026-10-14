<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('buatlaporan', 'user_id')) {
            Schema::table('buatlaporan', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            });

            DB::table('buatlaporan')->whereNull('user_id')->orderBy('id')->chunkById(100, function ($laporans) {
                foreach ($laporans as $laporan) {
                    $userId = DB::table('users')->where('email', $laporan->email)->value('id');
                    if ($userId) {
                        DB::table('buatlaporan')->where('id', $laporan->id)->update(['user_id' => $userId]);
                    }
                }
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->change();
        });

        Schema::table('buatlaporan', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'petugas')->update(['role' => 'user']);
        DB::table('buatlaporan')->where('status', 'selesai')->update(['status' => 'approved']);

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'admin'])->default('user')->change();
        });

        Schema::table('buatlaporan', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->change();
        });

        if (Schema::hasColumn('buatlaporan', 'user_id')) {
            Schema::table('buatlaporan', function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        }
    }
};
