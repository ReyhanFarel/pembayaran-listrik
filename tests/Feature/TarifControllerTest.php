<?php

namespace Tests\Feature;

use App\Models\Level;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TarifControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $petugas;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup level admin dan petugas
        $adminLevel = Level::factory()->create(['id' => 1, 'nama_level' => 'admin']);
        $petugasLevel = Level::factory()->create(['id' => 2, 'nama_level' => 'petugas']);

        $this->admin = User::factory()->create(['level_id' => $adminLevel->id]);
        $this->petugas = User::factory()->create(['level_id' => $petugasLevel->id]);
    }

    // INDEX

    public function test_admin_can_access_index()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.tarifs.index'));
        $response->assertStatus(200)->assertViewIs('admin.tarifs.index');
    }

    public function test_petugas_can_access_index()
    {
        $response = $this->actingAs($this->petugas)->get(route('petugas.tarifs.index'));
        $response->assertStatus(200)->assertViewIs('petugas.tarifs.index');
    }

    public function test_guest_cannot_access_index()
    {
        $response = $this->get(route('admin.tarifs.index'));
        $response->assertRedirect(route('login'));
    }

    // CREATE

    public function test_admin_can_access_create()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.tarifs.create'));
        $response->assertStatus(200)->assertViewIs('admin.tarifs.create');
    }

    public function test_petugas_cannot_access_create()
    {
        $response = $this->actingAs($this->petugas)->get(route('petugas.tarifs.create'));
        $response->assertStatus(403);
    }

    // STORE

    public function test_admin_can_store_tarif()
    {
        $data = [
            'daya' => 1300,
            'tarif_perkwh' => 1500,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.tarifs.store'), $data);

        $response->assertRedirect(route('admin.tarifs.index'));
        $this->assertDatabaseHas('tarifs', $data);
    }

    public function test_petugas_cannot_store_tarif()
    {
        $data = [
            'daya' => 1300,
            'tarif_perkwh' => 1500,
        ];

        $response = $this->actingAs($this->petugas)->post(route('petugas.tarifs.store'), $data);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('tarifs', $data);
    }

    // EDIT

    public function test_admin_can_access_edit()
    {
        $tarif = Tarif::create(['daya' => 1300, 'tarif_perkwh' => 1400]);

        $response = $this->actingAs($this->admin)->get(route('admin.tarifs.edit', $tarif));

        $response->assertStatus(200)->assertViewIs('admin.tarifs.edit');
    }

    public function test_petugas_cannot_access_edit()
    {
        $tarif = Tarif::create(['daya' => 1300, 'tarif_perkwh' => 1400]);

        $response = $this->actingAs($this->petugas)->get(route('petugas.tarifs.edit', $tarif));

        $response->assertStatus(403);
    }

    // UPDATE

    public function test_admin_can_update_tarif()
    {
        $tarif = Tarif::create(['daya' => 1300, 'tarif_perkwh' => 1400]);

        $updateData = [
            'daya' => 2200,
            'tarif_perkwh' => 1600,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.tarifs.update', $tarif), $updateData);

        $response->assertRedirect(route('admin.tarifs.index'));
        $this->assertDatabaseHas('tarifs', $updateData);
    }

    public function test_petugas_cannot_update_tarif()
    {
        $tarif = Tarif::create(['daya' => 1300, 'tarif_perkwh' => 1400]);

        $response = $this->actingAs($this->petugas)->put(route('petugas.tarifs.update', $tarif), [
            'daya' => 2200,
            'tarif_perkwh' => 1600,
        ]);

        $response->assertStatus(403);
    }

    // DESTROY

    public function test_admin_can_delete_tarif()
    {
        $tarif = Tarif::create(['daya' => 1300, 'tarif_perkwh' => 1400]);

        $response = $this->actingAs($this->admin)->delete(route('admin.tarifs.destroy', $tarif));

        $response->assertRedirect(route('admin.tarifs.index'));
        $this->assertDatabaseMissing('tarifs', ['id' => $tarif->id]);
    }

    public function test_petugas_cannot_delete_tarif()
    {
        $tarif = Tarif::create(['daya' => 1300, 'tarif_perkwh' => 1400]);

        $response = $this->actingAs($this->petugas)->delete(route('petugas.tarifs.destroy', $tarif));

        $response->assertStatus(403);
        $this->assertDatabaseHas('tarifs', ['id' => $tarif->id]);
    }
}
