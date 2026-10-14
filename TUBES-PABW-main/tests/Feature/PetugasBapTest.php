<?php

namespace Tests\Feature;

use App\Models\BuatLaporan;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetugasBapTest extends TestCase
{
    use RefreshDatabase;

    public function test_petugas_can_complete_report_and_notify_reporter_with_bap_access(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $pelapor = User::factory()->create();
        $laporan = $this->createReport($pelapor, 'approved');

        $this->actingAs($petugas)
            ->get(route('petugas.laporan'))
            ->assertOk()
            ->assertSee($laporan->nama);
        $this->get(route('petugas.laporan.show', $laporan))
            ->assertOk()
            ->assertSee($laporan->deskripsi);

        $response = $this->actingAs($petugas)->post(route('petugas.laporan.complete', $laporan));

        $response->assertRedirect(route('petugas.laporan.show', $laporan));
        $this->assertDatabaseHas('buatlaporan', ['id' => $laporan->id, 'status' => 'selesai']);
        $notification = Notification::where('laporan_id', $laporan->id)->firstOrFail();
        $this->assertSame($pelapor->id, $notification->user_id);

        $this->actingAs($pelapor)
            ->get(route('notifikasi'))
            ->assertOk()
            ->assertSee(route('notifikasi.bap', $notification), false);
        $this->actingAs($pelapor)
            ->get(route('notifikasi.bap', $notification))
            ->assertOk()
            ->assertSee('BERITA ACARA PEMERIKSAAN')
            ->assertSee('Uraian laporan pengujian.');
    }

    public function test_only_petugas_can_access_petugas_reports_and_only_reporter_can_open_bap(): void
    {
        $pelapor = User::factory()->create();
        $laporan = $this->createReport($pelapor, 'selesai');
        $notification = Notification::create([
            'user_id' => $pelapor->id,
            'laporan_id' => $laporan->id,
            'title' => 'BAP Laporan Selesai',
            'message' => 'BAP tersedia.',
        ]);

        $this->actingAs($pelapor)->get(route('petugas.laporan'))->assertForbidden();
        $this->actingAs(User::factory()->create())
            ->get(route('notifikasi.bap', $notification))
            ->assertNotFound();
    }

    public function test_bap_is_not_available_before_report_is_completed(): void
    {
        $pelapor = User::factory()->create();
        $laporan = $this->createReport($pelapor, 'approved');
        $notification = Notification::create([
            'user_id' => $pelapor->id,
            'laporan_id' => $laporan->id,
            'title' => 'Status Laporan',
            'message' => 'Laporan diproses.',
        ]);

        $this->actingAs($pelapor)
            ->get(route('notifikasi.bap', $notification))
            ->assertNotFound();
    }

    private function createReport(User $pelapor, string $status): BuatLaporan
    {
        return BuatLaporan::create([
            'user_id' => $pelapor->id,
            'nama' => $pelapor->name,
            'email' => $pelapor->email,
            'notelp' => '081234567890',
            'kategori' => 'Pencurian',
            'prioritas' => 'Sedang',
            'status' => $status,
            'date' => '2026-10-14',
            'time' => '12:00',
            'polres' => 'Polrestabes',
            'alamat' => 'Jl. Merdeka',
            'deskripsi' => 'Uraian laporan pengujian.',
        ]);
    }
}
