@extends('layouts.app')

@section('title', 'Bayar Tagihan')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Bayar Tagihan</h2>

        <div class="mb-4">
            <p><strong>Periode:</strong> {{ $tagihan->bulan }} {{ $tagihan->tahun }}</p>
            <p><strong>Pelanggan:</strong> {{ $pelanggan->nama_pelanggan }}</p>
            <p><strong>Jumlah Meter:</strong> {{ $tagihan->jumlah_meter }} kWh</p>
            <p><strong>Tarif per kWh:</strong> Rp {{ number_format($pelanggan->tarif->tarif_perkwh ?? 0, 2, ',', '.') }}</p>
            <hr class="my-4">
            <p class="text-xl font-semibold">Total Tagihan: <span class="text-blue-600">Rp {{ number_format($jumlahYangHarusDibayar, 2, ',', '.') }}</span></p>
        </div>

        <form action="{{ route('pelanggan.tagihan.proses_pembayaran', $tagihan->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="biaya_admin" class="block text-gray-700 text-sm font-bold mb-2">Biaya Admin (Opsional):</label>
                <input type="number" id="biaya_admin" name="biaya_admin" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('biaya_admin') border-red-500 @enderror" value="{{ old('biaya_admin', 0) }}">
                @error('biaya_admin')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Konfirmasi Pembayaran</button>
            </div>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">Setelah pembayaran berhasil, status tagihan akan diperbarui.</p>
    </div>
</div>
@endsection