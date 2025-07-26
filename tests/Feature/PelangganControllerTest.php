<?php

namespace Tests\Feature;

use App\Models\Level;
use App\Models\Tarif;
use App\Models\User;
use App\Models\Pelanggan; // Pastikan ini di-import
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash; // Tambahkan ini
use Tests\TestCase;

class PelangganControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup level admin dan petugas
        Level::factory()->create(['id' => 1, 'nama_level' => 'Administrator']); // Ganti 'admin' ke 'Administrator'
        Level::factory()->create(['id' => 2, 'nama_level' => 'Petugas']);       // Ganti 'petugas' ke 'Petugas'

        // Pastikan User factory membuat user yang dapat di-autentikasi
        $this->admin = User::factory()->create(['level_id' => 1, 'password' => Hash::make('password')]);
        $this->petugas = User::factory()->create(['level_id' => 2, 'password' => Hash::make('password')]);
    }

    protected function loginAsAdmin()
    {
        $this->actingAs($this->admin, 'web'); // Lebih spesifik guard-nya
    }

    protected function loginAsPetugas()
    {
        $this->actingAs($this->petugas, 'web'); // Lebih spesifik guard-nya
    }

    // INDEX (Test ini sudah PASS, tidak perlu diubah)
    public function test_admin_can_access_index()
    {
        $this->loginAsAdmin();
        $response = $this->get(route('admin.pelanggans.index'));
        $response->assertOk();
        $response->assertViewIs('admin.pelanggans.index');
    }

    public function test_petugas_can_access_index()
    {
        $this->loginAsPetugas();
        $response = $this->get(route('petugas.pelanggans.index'));
        $response->assertOk();
        $response->assertViewIs('petugas.pelanggans.index');
    }

    public function test_guest_cannot_access_index()
    {
        $response = $this->get(route('admin.pelanggans.index'));
        $response->assertRedirect(route('login'));
    }

    // CREATE (Modifikasi assert untuk Petugas)
    public function test_admin_can_access_create()
    {
        $this->loginAsAdmin();
        $response = $this->get(route('admin.pelanggans.create'));
        $response->assertOk();
        $response->assertViewIs('admin.pelanggans.create');
    }

    public function test_petugas_cannot_access_create()
    {
        $this->loginAsPetugas();
        $response = $this->get(route('admin.pelanggans.create')); // Petugas mencoba mengakses rute Admin
        $response->assertRedirect(route('login')); // Ekspektasi redirect ke login
    }
    // STORE (KOREKSI DI SINI: Pastikan username dan nomor_kwh unik untuk test)
    public function test_admin_can_store_pelanggan()
    {
        $this->loginAsAdmin();
        $tarif = Tarif::factory()->create();

        // Data yang akan dikirim untuk membuat pelanggan baru
        $pelangganData = [
            'tarif_id' => $tarif->id,
            'nama_pelanggan' => 'Lumi Tes',
            'username' => 'lumi123' . uniqid(),
            'password' => 'password123',
            'alamat' => 'Jl. Laravel',
            'nomor_kwh' => '1234567890' . uniqid(),
        ];

        $response = $this->post(route('admin.pelanggans.store'), $pelangganData);

        $response->assertRedirect(route('admin.pelanggans.index'));
        $this->assertDatabaseHas('pelanggan', [
            // KOREKSI DI SINI: Langsung gunakan $pelangganData['username']
            'username' => $pelangganData['username'],
            'alamat' => 'Jl. Laravel',
            'nama_pelanggan' => 'Aryo Tes', // Tambahkan untuk memastikan data lengkap
            'nomor_kwh' => $pelangganData['nomor_kwh'], // Tambahkan untuk memastikan data lengkap
        ]);
    }

    // Admin dapat mengedit dan mengupdate pelanggan
    public function test_admin_can_edit_and_update_pelanggan()
    {
        $this->loginAsAdmin();
        $tarif = Tarif::factory()->create();
        $pelanggan = Pelanggan::factory()->create(['tarif_id' => $tarif->id]);

        $response = $this->get(route('admin.pelanggans.edit', $pelanggan->id));
        $response->assertOk();
        $response->assertViewIs('admin.pelanggans.edit');

        $update = $this->put(route('admin.pelanggans.update', $pelanggan->id), [
            'tarif_id' => $tarif->id,
            'nama_pelanggan' => 'Updated',
            'username' => $pelanggan->username, // Gunakan username asli
            'alamat' => 'Updated Street',
            'nomor_kwh' => $pelanggan->nomor_kwh, // Gunakan nomor_kwh asli
        ]);

        $update->assertRedirect(route('admin.pelanggans.index'));
        $this->assertDatabaseHas('pelanggan', ['nama_pelanggan' => 'Updated']);
    }

    public function test_admin_can_delete_pelanggan()
    {
        $this->loginAsAdmin();
        $pelanggan = Pelanggan::factory()->create();

        $response = $this->delete(route('admin.pelanggans.destroy', $pelanggan->id));
        $response->assertRedirect(route('admin.pelanggans.index'));
        $this->assertDatabaseMissing('pelanggan', ['id' => $pelanggan->id]);
    }

    // PETUGAS (Modifikasi assert untuk Petugas)
    public function test_petugas_cannot_edit_or_delete_pelanggan()
    {
        $this->loginAsPetugas();
        $pelanggan = Pelanggan::factory()->create();

        // Mengakses rute Admin sebagai Petugas
        $this->get(route('admin.pelanggans.edit', $pelanggan->id))->assertRedirect(route('login'));
        $this->put(route('admin.pelanggans.update', $pelanggan->id), [
            'tarif_id' => $pelanggan->tarif_id,
            'nama_pelanggan' => 'X',
            'username' => $pelanggan->username,
            'alamat' => $pelanggan->alamat,
            'nomor_kwh' => $pelanggan->nomor_kwh,
        ])->assertRedirect(route('login'));

        $this->delete(route('admin.pelanggans.destroy', $pelanggan->id))
            ->assertRedirect(route('login'));
    }
}