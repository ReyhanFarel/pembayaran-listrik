<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Penggunaan;
use App\Models\Tarif;
use App\Models\Level; // Untuk seeder
use App\Models\User;   // Untuk seeder
use Illuminate\Support\Facades\Hash;
use Midtrans\Config; // Untuk mocking Midtrans
use Midtrans\Snap;    // Untuk mocking Midtrans

class PelangganDashboardControllerTest extends TestCase
{
    use RefreshDatabase; // Membersihkan database sebelum setiap test
    use WithFaker;       // Untuk membuat data dummy

    /**
     * Set up untuk setiap test.
     * Membuat data yang dibutuhkan seperti level, user, tarif, dan pelanggan.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Pastikan Level ada, karena User dan Pelanggan membutuhkannya (jika di DB)
        Level::firstOrCreate(['id' => 1], ['nama_level' => 'Administrator']);
        Level::firstOrCreate(['id' => 2], ['nama_level' => 'Petugas']);

        // Buat tarif dummy
        Tarif::factory()->create([
            'id' => 1,
            'daya' => 900,
            'tarif_perkwh' => 1352.00
        ]);
        Tarif::factory()->create([
            'id' => 2,
            'daya' => 1300,
            'tarif_perkwh' => 1444.70
        ]);
    }

    /**
     * Test: Akses dashboard pelanggan tanpa login (harus redirect ke login).
     * @return void
     */
    public function test_cannot_access_pelanggan_dashboard_without_login()
    {
        $response = $this->get(route('pelanggan.dashboard'));
        $response->assertRedirect('/login'); // Pastikan redirect ke halaman login
    }

    /**
     * Test: Akses dashboard pelanggan setelah login berhasil.
     * @return void
     */
    public function test_can_access_pelanggan_dashboard_after_login()
    {
        // Buat pelanggan dummy
        $pelanggan = Pelanggan::factory()->create([
            'tarif_id' => Tarif::first()->id,
            'password' => Hash::make('password123'),
        ]);

        // Login sebagai pelanggan ini
        $response = $this->actingAs($pelanggan, 'pelanggan')
                         ->get(route('pelanggan.dashboard'));

        $response->assertOk(); // Pastikan status HTTP 200 OK
        $response->assertViewIs('pelanggan.dashboard'); // Pastikan view yang benar dimuat
        $response->assertSee($pelanggan->nama_pelanggan); // Pastikan nama pelanggan terlihat di dashboard
    }

    /**
     * Test: Metode tagihanSaya() menampilkan tagihan pelanggan yang benar.
     * @return void
     */
    public function test_tagihan_saya_displays_correct_bills()
    {
        $pelanggan1 = Pelanggan::factory()->create(['tarif_id' => Tarif::first()->id]);
        $pelanggan2 = Pelanggan::factory()->create(['tarif_id' => Tarif::first()->id]);

        // Buat tagihan untuk pelanggan1
        $penggunaan1 = Penggunaan::factory()->create(['pelanggan_id' => $pelanggan1->id, 'meter_awal' => 0, 'meter_akhir' => 100, 'bulan' => 'Januari', 'tahun' => 2024]);
        $tagihan1 = Tagihan::factory()->create(['pelanggan_id' => $pelanggan1->id, 'penggunaan_id' => $penggunaan1->id, 'bulan' => 'Januari', 'tahun' => 2024, 'status_tagihan' => 'Belum Dibayar']);

        // Buat tagihan untuk pelanggan2 (tidak boleh terlihat oleh pelanggan1)
        $penggunaan2 = Penggunaan::factory()->create(['pelanggan_id' => $pelanggan2->id, 'meter_awal' => 0, 'meter_akhir' => 50, 'bulan' => 'Februari', 'tahun' => 2024]);
        $tagihan2 = Tagihan::factory()->create(['pelanggan_id' => $pelanggan2->id, 'penggunaan_id' => $penggunaan2->id, 'bulan' => 'Februari', 'tahun' => 2024, 'status_tagihan' => 'Belum Dibayar']);

        $response = $this->actingAs($pelanggan1, 'pelanggan')
                         ->get(route('pelanggan.tagihan_saya'));

        $response->assertOk();
        $response->assertViewIs('pelanggan.tagihan_saya');
        $response->assertSee('Rp ' . number_format($tagihan1->total_tagihan, 2, ',', '.')); // Pastikan total tagihan pelanggan1 terlihat
$response->assertDontSee('Rp ' . number_format($tagihan2->total_tagihan, 2, ',', '.')); // Pastikan total tagihan pelanggan2 tidak terlihat
    }

    /**
     * Test: Metode profilSaya() menampilkan data profil yang benar.
     * @return void
     */
    public function test_profil_saya_displays_correct_profile_data()
    {
        $pelanggan = Pelanggan::factory()->create(['tarif_id' => Tarif::first()->id]);

        $response = $this->actingAs($pelanggan, 'pelanggan')
                         ->get(route('pelanggan.profil_saya'));

        $response->assertOk();
        $response->assertViewIs('pelanggan.profil_saya');
        $response->assertSee($pelanggan->nama_pelanggan);
        $response->assertSee($pelanggan->username);
        $response->assertSee($pelanggan->alamat);
        $response->assertSee($pelanggan->nomor_kwh);
    }

    /**
     * Test: Metode updateProfil() dapat memperbarui password pelanggan.
     * @return void
     */
    public function test_update_profil_can_update_password()
    {
        $pelanggan = Pelanggan::factory()->create(['password' => Hash::make('oldpassword'), 'tarif_id' => Tarif::first()->id]);

        $newPassword = 'newpassword123';
        $response = $this->actingAs($pelanggan, 'pelanggan')
                         ->put(route('pelanggan.update_profil'), [
                             'nama_pelanggan' => $pelanggan->nama_pelanggan,
                             'username' => $pelanggan->username,
                             'alamat' => $pelanggan->alamat,
                             'password' => $newPassword,
                             'password_confirmation' => $newPassword,
                         ]);

        $response->assertRedirect(route('pelanggan.profil_saya'));
        $response->assertSessionHas('success', 'Profil Anda berhasil diperbarui!');

        // Refresh model pelanggan dari database dan verifikasi password
        $this->assertTrue(Hash::check($newPassword, $pelanggan->fresh()->password));
    }

    /**
     * Test: Metode bayarTagihan() berhasil mendapatkan Snap Token dari Midtrans.
     * @return void
     */
    // public function test_bayar_tagihan_obtains_midtrans_snap_token()
    // {
    //     // Mock Midtrans Snap untuk mengembalikan token palsu
    //     $mockSnap = $this->mock(Snap::class, function ($mock) {
    //         $mock->shouldReceive('getSnapToken')
    //              ->once()
    //              ->andReturn('dummy_snap_token_123');
    //     });

    //     // Konfigurasi Midtrans agar tidak memanggil API sungguhan
    //     // Config::$serverKey = 'dummy_server_key';
    //     // Config::$isProduction = false;
    //     // Config::$isSanitized = true;
    //     // Config::$is3ds = true;
        
    //     $pelanggan = Pelanggan::factory()->create(['tarif_id' => Tarif::first()->id]);
    //     $penggunaan = Penggunaan::factory()->create(['pelanggan_id' => $pelanggan->id, 'meter_awal' => 0, 'meter_akhir' => 100, 'bulan' => 'Maret', 'tahun' => 2024]);
    //     $tagihan = Tagihan::factory()->create(['pelanggan_id' => $pelanggan->id, 'penggunaan_id' => $penggunaan->id, 'bulan' => 'Maret', 'tahun' => 2024, 'status_tagihan' => 'Belum Lunas']);

    //     $response = $this->actingAs($pelanggan, 'pelanggan')
    //                      ->post(route('pelanggan.tagihan.proses_bayar', $tagihan->id)); // Ini memanggil processPayment

    //     $response->assertOk();
    //     $response->assertJson(['snap_token' => 'dummy_snap_token_123']); // Memastikan respons JSON berisi token
    // }

    // /**
    //  * Test: Akses bayarTagihan untuk tagihan yang sudah lunas (harus redirect dengan error).
    //  * @return void
    //  */
    // public function test_cannot_pay_already_paid_tagihan()
    // {
    //     $pelanggan = Pelanggan::factory()->create(['tarif_id' => Tarif::first()->id]);
    //     $penggunaan = Penggunaan::factory()->create(['pelanggan_id' => $pelanggan->id, 'meter_awal' => 0, 'meter_akhir' => 100, 'bulan' => 'April', 'tahun' => 2024]);
    //     $tagihan = Tagihan::factory()->create(['pelanggan_id' => $pelanggan->id, 'penggunaan_id' => $penggunaan->id, 'bulan' => 'April', 'tahun' => 2024, 'status_tagihan' => 'Lunas']);

    //     $response = $this->actingAs($pelanggan, 'pelanggan')
    //                      ->post(route('pelanggan.tagihan.proses_bayar', $tagihan->id)); // Memanggil processPayment

    //     $response->assertRedirect(route('pelanggan.tagihan_saya'));
    //     $response->assertSessionHas('error', 'Tagihan tidak valid atau sudah lunas.');
    // }
}