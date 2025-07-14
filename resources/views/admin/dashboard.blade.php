@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Selamat Datang, Admin {{ Auth::guard('web')->user()->nama_user }}!</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Card Statistik Contoh --}}
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-2xl font-bold">125</div>
                <div class="text-lg">Total Pelanggan</div>
            </div>
            <svg class="w-12 h-12 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20v-9H7v9M4 14h16V7H4v7"></path></svg>
        </div>
        <div class="bg-green-500 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-2xl font-bold">Rp 5.000.000</div>
                <div class="text-lg">Pendapatan Bulan Ini</div>
            </div>
            <svg class="w-12 h-12 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9v6m-4-4v4m-4-4v4m-4-4v4"></path></svg>
        </div>
        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-2xl font-bold">15</div>
                <div class="text-lg">Tagihan Belum Lunas</div>
            </div>
            <svg class="w-12 h-12 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Aktivitas Terkini</h2>
        <p>Detail aktivitas terbaru seperti penambahan pelanggan baru, pembayaran terakhir, dll. akan ditampilkan di sini.</p>
        {{-- Tabel atau daftar aktivitas --}}
    </div>
</div>
@endsection