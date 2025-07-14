@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Selamat Datang, Petugas {{ Auth::guard('web')->user()->nama_user }}!</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Card Total Pelanggan --}}
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-2xl font-bold">{{ number_format($totalPelanggan, 0, ',', '.') }}</div>
                <div class="text-lg">Total Pelanggan</div>
            </div>
            <svg class="w-12 h-12 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20v-9H7v9M4 14h16V7H4v7"></path></svg>
        </div>
        {{-- Card Tagihan Belum Lunas --}}
        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-2xl font-bold">{{ number_format($totalTagihanBelumLunas, 0, ',', '.') }}</div>
                <div class="text-lg">Tagihan Belum Lunas</div>
            </div>
            <svg class="w-12 h-12 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        {{-- Card Total Penggunaan Bulan Ini --}}
        <div class="bg-purple-500 text-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-2xl font-bold">{{ number_format($totalPenggunaanBulanIni, 0, ',', '.') }} KWH</div>
                <div class="text-lg">Penggunaan Bulan Ini</div>
            </div>
            <svg class="w-12 h-12 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">5 Pencatatan Penggunaan Terkini</h2>
        @forelse($latestPenggunaans as $penggunaan)
            <div class="flex items-center justify-between py-2 border-b last:border-b-0">
                <div class="text-gray-700">
                    Penggunaan untuk <strong class="font-medium">{{ $penggunaan->pelanggan->nama_pelanggan ?? 'N/A' }}</strong>
                    bulan {{ $penggunaan->bulan }} {{ $penggunaan->tahun }}.
                </div>
                <div class="text-right">
                    <span class="text-blue-600 font-semibold">{{ number_format($penggunaan->jumlah_meter, 0, ',', '.') }} KWH</span>
                    <br>
                    <span class="text-gray-500 text-sm">{{ $penggunaan->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada pencatatan penggunaan terkini.</p>
        @endforelse
    </div>
</div>
@endsection