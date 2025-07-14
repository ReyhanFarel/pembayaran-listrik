@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Selamat Datang, {{ Auth::guard('pelanggan')->user()->nama_pelanggan }}!</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-2xl font-bold">Rp {{ number_format(150000, 0, ',', '.') }}</div>
                <div class="text-lg">Tagihan Bulan Ini</div>
                <div class="text-sm">Status: Belum Lunas</div>
            </div>
            <svg class="w-12 h-12 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <div class="bg-green-500 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-2xl font-bold">120 KWH</div>
                <div class="text-lg">Penggunaan Bulan Ini</div>
            </div>
            <svg class="w-12 h-12 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </div>
        <div class="bg-purple-500 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-2xl font-bold">No. KWH: {{ Auth::guard('pelanggan')->user()->nomor_kwh }}</div> {{-- <-- Ganti daya menjadi nomor_kwh --}}
                <div class="text-lg">Daya Terpasang: {{ optional(Auth::guard('pelanggan')->user()->tarif)->daya }} VA</div> {{-- <-- Ambil daya dari relasi tarif --}}
            </div>
            <svg class="w-12 h-12 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Informasi Penting</h2>
        <p>Anda dapat memeriksa status tagihan Anda, melihat riwayat penggunaan listrik, dan detail lainnya melalui menu di samping.</p>
    </div>
</div>
@endsection