<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Policies Untuk model yang digunakan dalam aplikasi.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Untuk mendaftarkan kebijakan otorisasi dan gate.
     * Anda dapat mendefinisikan gate di sini untuk mengontrol akses ke berbagai bagian aplikasi.
     * Misalnya, Anda dapat membuat gate untuk memeriksa apakah pengguna adalah Admin atau Pelanggan.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate untuk Admin
        Gate::define('isAdmin', function ($user) {
            return $user instanceof \App\Models\User && $user->isAdmin();
        });

        // Gate untuk Pelanggan
        Gate::define('isPelanggan', function ($user) {
            return $user instanceof \App\Models\Pelanggan && $user->isPelanggan();
        });
    }
}