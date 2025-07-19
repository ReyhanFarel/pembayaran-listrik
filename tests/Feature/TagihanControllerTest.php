<?php

namespace Tests\Feature;

use App\Models\Level;
use App\Models\Pelanggan;
use App\Models\Penggunaan;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagihanControllerTest extends TestCase
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
        $response = $this->actingAs($this->admin)->get(route('admin.tagihans.index'));
        $response->assertStatus(200)->assertViewIs('tagihan.index');
    }

    public function test_petugas_can_access_index()
    {
        $response = $this->actingAs($this->petugas)->get(route('petugas.tagihans.index'));
        $response->assertStatus(200)->assertViewIs('tagihan.index');
    }

    public function test_guest_cannot_access_index()
    {
        $response = $this->get(route('admin.tagihans.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_create_from_penggunaan()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.tagihans.create_from_penggunaan'));
        $response->assertStatus(200)->assertViewIs('tagihan.create_from_penggunaan');
    }

    public function test_petugas_can_access_create_from_penggunaan()
    {
        $response = $this->actingAs($this->petugas)->get(route('petugas.tagihans.create_from_penggunaan'));
        $response->assertStatus(200)->assertViewIs('tagihan.create_from_penggunaan');
    }

    public function test_admin_can_generate_tagihan()
    {
        $penggunaan = Penggunaan::factory()->create();
        $response = $this->actingAs($this->admin)->post(route('admin.tagihans.generate'), [
            'penggunaan_ids' => [$penggunaan->id]
        ]);

        $response->assertRedirect(route('admin.tagihans.index'));
        $this->assertDatabaseHas('tagihan', [
            'penggunaan_id' => $penggunaan->id
        ]);
    }

    public function test_petugas_can_generate_tagihan()
    {
        $penggunaan = Penggunaan::factory()->create();
        $response = $this->actingAs($this->petugas)->post(route('petugas.tagihans.generate'), [
            'penggunaan_ids' => [$penggunaan->id]
        ]);

        $response->assertRedirect(route('petugas.tagihans.index'));
        $this->assertDatabaseHas('tagihan', [
            'penggunaan_id' => $penggunaan->id
        ]);
    }

    public function test_admin_can_edit_tagihan()
    {
        $tagihan = Tagihan::factory()->create();
        $response = $this->actingAs($this->admin)->get(route('admin.tagihans.edit', $tagihan));
        $response->assertStatus(200)->assertViewIs('tagihan.edit');
    }

    public function test_petugas_can_edit_tagihan()
    {
        $tagihan = Tagihan::factory()->create();
        $response = $this->actingAs($this->petugas)->get(route('petugas.tagihans.edit', $tagihan));
        $response->assertStatus(200)->assertViewIs('tagihan.edit');
    }

    public function test_admin_can_update_tagihan()
    {
        $tagihan = Tagihan::factory()->create(['status_tagihan' => 'Belum Dibayar']);

        $response = $this->actingAs($this->admin)->put(route('admin.tagihans.update', $tagihan), [
            'status_tagihan' => 'Sudah Dibayar'
        ]);

        $response->assertRedirect(route('admin.tagihans.index'));
        $this->assertDatabaseHas('tagihan', ['id' => $tagihan->id, 'status_tagihan' => 'Sudah Dibayar']);
    }

    public function test_petugas_can_update_tagihan()
    {
        $tagihan = Tagihan::factory()->create(['status_tagihan' => 'Belum Dibayar']);

        $response = $this->actingAs($this->petugas)->put(route('petugas.tagihans.update', $tagihan), [
            'status_tagihan' => 'Sudah Dibayar'
        ]);

        $response->assertRedirect(route('petugas.tagihans.index'));
        $this->assertDatabaseHas('tagihan', ['id' => $tagihan->id, 'status_tagihan' => 'Sudah Dibayar']);
    }

    public function test_admin_can_delete_tagihan()
    {
        $tagihan = Tagihan::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.tagihans.destroy', $tagihan));
        $response->assertRedirect(route('admin.tagihans.index'));
        $this->assertDatabaseMissing('tagihan', ['id' => $tagihan->id]);
    }

    public function test_petugas_can_delete_tagihan()
    {
        $tagihan = Tagihan::factory()->create();

        $response = $this->actingAs($this->petugas)->delete(route('petugas.tagihans.destroy', $tagihan));
        $response->assertRedirect(route('petugas.tagihans.index'));
        $this->assertDatabaseMissing('tagihan', ['id' => $tagihan->id]);
    }
}
