<?php

namespace Tests\Feature;

use App\Models\Level;
use App\Models\Pelanggan;
use App\Models\Penggunaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenggunaanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $petugas;

    protected function setUp(): void
    {
        parent::setUp();

        $adminLevel = Level::factory()->create(['id' => 1, 'nama_level' => 'admin']);
        $petugasLevel = Level::factory()->create(['id' => 2, 'nama_level' => 'petugas']);

        $this->admin = User::factory()->create(['level_id' => $adminLevel->id]);
        $this->petugas = User::factory()->create(['level_id' => $petugasLevel->id]);
    }

    public function test_admin_can_access_index()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.penggunaans.index'));
        $response->assertStatus(200)->assertViewIs('penggunaan.index');
    }

    public function test_petugas_can_access_index()
    {
        $response = $this->actingAs($this->petugas)->get(route('petugas.penggunaans.index'));
        $response->assertStatus(200)->assertViewIs('penggunaan.index');
    }

    public function test_guest_cannot_access_index()
    {
        $response = $this->get(route('admin.penggunaans.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_create()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.penggunaans.create'));
        $response->assertStatus(200)->assertViewIs('penggunaan.create');
    }

    public function test_petugas_can_access_create()
    {
        $response = $this->actingAs($this->petugas)->get(route('petugas.penggunaans.create'));
        $response->assertStatus(200)->assertViewIs('penggunaan.create');
    }

    public function test_admin_can_store_penggunaan()
    {
        $pelanggan = Pelanggan::factory()->create();

        $data = [
            'pelanggan_id' => $pelanggan->id,
            'bulan' => 'Juli',
            'tahun' => '2025',
            'meter_awal' => 1000,
            'meter_akhir' => 1200,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.penggunaans.store'), $data);

        $response->assertRedirect(route('admin.penggunaans.index'));
        $this->assertDatabaseHas('penggunaan', $data);
    }

    public function test_petugas_can_store_penggunaan()
    {
        $pelanggan = Pelanggan::factory()->create();

        $data = [
            'pelanggan_id' => $pelanggan->id,
            'bulan' => 'Juli',
            'tahun' => '2025',
            'meter_awal' => 1000,
            'meter_akhir' => 1200,
        ];

        $response = $this->actingAs($this->petugas)->post(route('petugas.penggunaans.store'), $data);

        $response->assertRedirect(route('petugas.penggunaans.index'));
        $this->assertDatabaseHas('penggunaan', $data);
    }

    public function test_admin_can_access_edit()
    {
        $penggunaan = Penggunaan::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.penggunaans.edit', $penggunaan));

        $response->assertStatus(200)->assertViewIs('penggunaan.edit');
    }

    public function test_petugas_can_access_edit()
    {
        $penggunaan = Penggunaan::factory()->create();

        $response = $this->actingAs($this->petugas)->get(route('petugas.penggunaans.edit', $penggunaan));

        $response->assertStatus(200)->assertViewIs('penggunaan.edit');
    }

    public function test_admin_can_update_penggunaan()
    {
        $penggunaan = Penggunaan::factory()->create();

        $updateData = [
            'pelanggan_id' => $penggunaan->pelanggan_id,
            'bulan' => 'Agustus',
            'tahun' => '2025',
            'meter_awal' => 1100,
            'meter_akhir' => 1300,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.penggunaans.update', $penggunaan), $updateData);

        $response->assertRedirect(route('admin.penggunaans.index'));
        $this->assertDatabaseHas('penggunaan', $updateData);
    }

    public function test_petugas_can_update_penggunaan()
    {
        $penggunaan = Penggunaan::factory()->create();

        $updateData = [
            'pelanggan_id' => $penggunaan->pelanggan_id,
            'bulan' => 'Agustus',
            'tahun' => '2025',
            'meter_awal' => 1100,
            'meter_akhir' => 1300,
        ];

        $response = $this->actingAs($this->petugas)->put(route('petugas.penggunaans.update', $penggunaan), $updateData);

        $response->assertRedirect(route('petugas.penggunaans.index'));
        $this->assertDatabaseHas('penggunaan', $updateData);
    }

    public function test_admin_can_delete_penggunaan()
    {
        $penggunaan = Penggunaan::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.penggunaans.destroy', $penggunaan));

        $response->assertRedirect(route('admin.penggunaans.index'));
        $this->assertDatabaseMissing('penggunaan', ['id' => $penggunaan->id]);
    }

    public function test_petugas_can_delete_penggunaan()
    {
        $penggunaan = Penggunaan::factory()->create();

        $response = $this->actingAs($this->petugas)->delete(route('petugas.penggunaans.destroy', $penggunaan));

        $response->assertRedirect(route('petugas.penggunaans.index'));
        $this->assertDatabaseMissing('penggunaan', ['id' => $penggunaan->id]);
    }
}