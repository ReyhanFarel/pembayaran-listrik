<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Pelanggan;

class PelangganModelTest extends TestCase
{
    public function test_pelanggan_has_tarif_relation()
    {
        $pelanggan = new Pelanggan();
        $this->assertTrue(method_exists($pelanggan, 'tarifs'));
    }

    public function test_pelanggan_nama_is_string()
    {
        $pelanggan = new Pelanggan(['nama_pelanggan' => 'Aryo']);
        $this->assertIsString($pelanggan->nama_pelanggan);
    }

    // Tambahkan test lain sesuai kebutuhan
}