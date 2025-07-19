<?php

namespace Tests\Feature;

use App\Models\Level;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PembayaranControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $petugas;

    protected function setUp(): void
    {
        parent::setUp();

        Level::factory()->create(['id' => 1, 'nama_level' => 'admin']);
        Level::factory()->create(['id' => 2, 'nama_level' => 'petugas']);

        $this->admin = User::factory()->create(['level_id' => 1]);
        $this->petugas = User::factory()->create(['level_id' => 2]);
    }

    // ============================
    //         ADMIN TESTS
    // ============================

    public function test_admin_can_view_pembayaran_index()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pembayarans.index'));
        $response->assertStatus(200)->assertViewIs('pembayaran.index');
    }

    public function test_admin_can_access_create_form()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pembayarans.create'));
        $response->assertStatus(200)->assertViewIs('pembayaran.create');
    }

    public function test_admin_can_store_new_pembayaran()
    {
        $pelanggan = Pelanggan::factory()->hasTarifs()->create();
        $tagihan = Tagihan::factory()->create([
            'status_tagihan' => 'Belum Dibayar',
            'pelanggan_id' => $pelanggan->id,
        ]);

        $data = [
            'tagihan_id' => $tagihan->id,
            'tanggal_pembayaran' => now()->toDateString(),
            'biaya_admin' => 2000,
        ];

        $response = $this->actingAs($this->admin)
            ->from(route('admin.pembayarans.create'))
            ->post(route('admin.pembayarans.store'), $data);

        $response->assertRedirect(route('admin.pembayarans.index'));
        $this->assertDatabaseHas('pembayaran', [
            'tagihan_id' => $tagihan->id,
            'user_id' => $this->admin->id,
        ]);
    }

    public function test_admin_can_edit_pembayaran()
    {
        $pembayaran = Pembayaran::factory()->create();
        $response = $this->actingAs($this->admin)->get(route('admin.pembayarans.edit', $pembayaran));
        $response->assertStatus(200)->assertViewIs('pembayaran.edit');
    }

    public function test_admin_can_update_pembayaran()
    {
        $pembayaran = Pembayaran::factory()->create([
            'biaya_admin' => 1000,
        ]);

        $data = [
            'tanggal_pembayaran' => now()->toDateString(),
            'biaya_admin' => 3000,
        ];

        $response = $this->actingAs($this->admin)
            ->from(route('admin.pembayarans.edit', $pembayaran))
            ->put(route('admin.pembayarans.update', $pembayaran), $data);

        $response->assertRedirect(route('admin.pembayarans.index'));
        $this->assertDatabaseHas('pembayaran', [
            'id' => $pembayaran->id,
            'biaya_admin' => 3000,
        ]);
    }

    public function test_admin_can_delete_pembayaran()
    {
        $pembayaran = Pembayaran::factory()->create();
        $tagihan = $pembayaran->tagihan;

        $response = $this->actingAs($this->admin)->delete(route('admin.pembayarans.destroy', $pembayaran));
        $response->assertRedirect(route('admin.pembayarans.index'));

        $this->assertDatabaseMissing('pembayaran', ['id' => $pembayaran->id]);
        $this->assertDatabaseHas('tagihan', [
            'id' => $tagihan->id,
            'status_tagihan' => 'Belum Dibayar',
        ]);
    }

    // ============================
    //        PETUGAS TESTS
    // ============================

    public function test_petugas_can_view_pembayaran_index()
    {
        $response = $this->actingAs($this->petugas)->get(route('petugas.pembayarans.index'));
        $response->assertStatus(200)->assertViewIs('pembayaran.index');
    }

    public function test_petugas_can_access_create_form()
    {
        $response = $this->actingAs($this->petugas)->get(route('petugas.pembayarans.create'));
        $response->assertStatus(200)->assertViewIs('pembayaran.create');
    }

    public function test_petugas_can_store_new_pembayaran()
    {
        $pelanggan = Pelanggan::factory()->hasTarifs()->create();
        $tagihan = Tagihan::factory()->create([
            'status_tagihan' => 'Belum Dibayar',
            'pelanggan_id' => $pelanggan->id,
        ]);

        $data = [
            'tagihan_id' => $tagihan->id,
            'tanggal_pembayaran' => now()->toDateString(),
            'biaya_admin' => 2500,
        ];

        $response = $this->actingAs($this->petugas)
            ->from(route('petugas.pembayarans.create'))
            ->post(route('petugas.pembayarans.store'), $data);

        $response->assertRedirect(route('petugas.pembayarans.index'));
        $this->assertDatabaseHas('pembayaran', [
            'tagihan_id' => $tagihan->id,
            'user_id' => $this->petugas->id,
        ]);
    }

    public function test_petugas_can_edit_pembayaran()
    {
        $pembayaran = Pembayaran::factory()->create();
        $response = $this->actingAs($this->petugas)->get(route('petugas.pembayarans.edit', $pembayaran));
        $response->assertStatus(200)->assertViewIs('pembayaran.edit');
    }

    public function test_petugas_can_update_pembayaran()
    {
        $pembayaran = Pembayaran::factory()->create([
            'biaya_admin' => 500,
        ]);

        $data = [
            'tanggal_pembayaran' => now()->toDateString(),
            'biaya_admin' => 1500,
        ];

        $response = $this->actingAs($this->petugas)
            ->from(route('petugas.pembayarans.edit', $pembayaran))
            ->put(route('petugas.pembayarans.update', $pembayaran), $data);

        $response->assertRedirect(route('petugas.pembayarans.index'));
        $this->assertDatabaseHas('pembayaran', [
            'id' => $pembayaran->id,
            'biaya_admin' => 1500,
        ]);
    }

    public function test_petugas_can_delete_pembayaran()
    {
        $pembayaran = Pembayaran::factory()->create();
        $tagihan = $pembayaran->tagihan;

        $response = $this->actingAs($this->petugas)->delete(route('petugas.pembayarans.destroy', $pembayaran));
        $response->assertRedirect(route('petugas.pembayarans.index'));

        $this->assertDatabaseMissing('pembayaran', ['id' => $pembayaran->id]);
        $this->assertDatabaseHas('tagihan', [
            'id' => $tagihan->id,
            'status_tagihan' => 'Belum Dibayar',
        ]);
    }
}
