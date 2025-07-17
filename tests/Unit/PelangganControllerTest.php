<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\PelangganController;
use App\Models\Pelanggan;
use App\Models\User;
use App\Models\Level;
use Illuminate\Http\Request;

class PelangganControllerTest extends TestCase
{
  

    public function test_it_creates_new_pelanggan()
    {
        // Ambil level administrator dari database yang sudah di-seed
        $adminLevel = Level::where('nama_level', 'administrator')->first();

        // Buat user admin
        $admin = User::factory()->create([
            'username'   => 'admin_' . uniqid(),
            'nama_user'  => 'Administrator Utama',
            'password'   => bcrypt('password'),
            'level_id'   => $adminLevel->id,
        ]);
        $this->actingAs($admin);

        $controller = new PelangganController();
        $request = Request::create('/admin/pelanggans', 'POST', [
            'nama_pelanggan' => 'Aryo123',
            'username'       => 'aryo123',
            'password'       => 'secret',
            'alamat'         => 'Jl. Sudirman',
            'nomor_kwh'      => '12345214126',
            'tarif_id'       => 1 // id tarif dari seeder
        ]);

        $controller->store($request);
 $this->assertDatabaseHas('pelanggan', [
        'username' => 'aryo123'
    ]);
    }
   
    
    public function test_it_updates_pelanggan()
    {
        // Ambil level administrator dari database yang sudah di-seed
        $adminLevel = Level::where('nama_level', 'administrator')->first();

        // Buat user admin
        $admin = User::factory()->create([
            'username'   => 'admin_' . uniqid(),
            'nama_user'  => 'Administrator Utama',
            'password'   => bcrypt('password'),
            'level_id'   => $adminLevel->id,
        ]);
        $this->actingAs($admin);

        // Pastikan tarif_id 1 sudah ada dari seeder
        $pelanggan = Pelanggan::factory()->create([
            'nama_pelanggan' => 'Old Name',
            'username'       => 'oldusername',
            'password'       => bcrypt('password'),
            'alamat'         => 'Jl. Sudirman',
            'nomor_kwh'      => '654456321',
            'tarif_id'       => 1 // id tarif dari seeder
        ]);

        $controller = new PelangganController();
        $request = Request::create('/admin/pelanggans/' . $pelanggan->id, 'PUT', [
            'nama_pelanggan' => 'New Name',
            'username'       => 'newusername',
            'alamat'         => 'Jl. Sudirman',
            'nomor_kwh'      => '654322241',
            'tarif_id'       => 1,
        ]);

        $controller->update($request, $pelanggan);

        $pelanggan->refresh();
        $this->assertEquals('New Name', $pelanggan->nama_pelanggan);
        $this->assertEquals('newusername', $pelanggan->username);
    }
}