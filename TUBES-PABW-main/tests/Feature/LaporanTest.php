<?php

namespace Tests\Feature;

use App\Models\BuatLaporan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    public function test_web_report_uses_authenticated_reporter_and_server_priority(): void
    {
        $user = User::factory()->create([
            'name' => 'Warga Test',
            'email' => 'warga@example.com',
            'notelp' => '081234567890',
        ]);

        $response = $this->actingAs($user)->post(route('buatlaporan.simpan'), [
            'nama' => 'Nama Palsu',
            'email' => 'palsu@example.com',
            'notelp' => '089999999999',
            'kategori' => 'Vandalisme',
            'prioritas' => 'Sangat Tinggi',
            'date' => '2026-10-06',
            'time' => '12:30',
            'polres' => 'Polrestabes Palembang',
            'alamat' => 'Jl. Merdeka No. 1',
            'deskripsi' => 'Laporan pengujian.',
        ]);

        $response->assertRedirect(route('laporansaya'));
        $this->assertDatabaseHas('buatlaporan', [
            'user_id' => $user->id,
            'nama' => 'Warga Test',
            'email' => 'warga@example.com',
            'notelp' => '081234567890',
            'kategori' => 'Vandalisme',
            'prioritas' => 'Rendah',
            'status' => 'pending',
        ]);
    }

    public function test_web_report_requires_a_known_category(): void
    {
        $user = User::factory()->create(['notelp' => '081234567890']);

        $response = $this->from('/buatlaporan')->actingAs($user)->post(route('buatlaporan.simpan'), [
            'kategori' => 'Kategori Tidak Valid',
            'date' => '2026-10-06',
            'time' => '12:30',
            'polres' => 'Polrestabes Palembang',
            'alamat' => 'Jl. Merdeka No. 1',
            'deskripsi' => 'Laporan pengujian.',
        ]);

        $response->assertRedirect('/buatlaporan');
        $response->assertSessionHasErrors('kategori');
        $this->assertSame(0, BuatLaporan::count());
    }

    public function test_api_report_uses_account_phone_and_category_priority(): void
    {
        $user = User::factory()->create([
            'name' => 'Warga API',
            'email' => 'api@example.com',
            'notelp' => '+6281234567890',
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/laporan', [
            'notelp' => '089999999999',
            'kategori' => 'Perampokan',
            'prioritas' => 'Rendah',
            'date' => '2026-10-06',
            'time' => '12:30',
            'polres' => 'Polrestabes Palembang',
            'alamat' => 'Jl. Merdeka No. 1',
            'deskripsi' => 'Laporan API pengujian.',
        ]);

        $response->assertCreated();
        $response->assertJsonPath('laporan.prioritas', 'Tinggi');
        $this->assertDatabaseHas('buatlaporan', [
            'user_id' => $user->id,
            'nama' => 'Warga API',
            'email' => 'api@example.com',
            'notelp' => '+6281234567890',
            'kategori' => 'Perampokan',
            'prioritas' => 'Tinggi',
            'status' => 'pending',
        ]);
    }
}
