@extends('layouts.app')

@section('title', 'Edit Pembayaran')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg mx-auto">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Edit Pembayaran</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
            <ul class="mt-3 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ Auth::guard('web')->user()->level_id == 1 ? route('admin.pembayarans.update', $pembayaran->id) : route('petugas.pembayarans.update', $pembayaran->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Detail Tagihan:</label>
            <div class="bg-gray-100 p-4 rounded-md border border-gray-200">
                <p><strong>Pelanggan:</strong> {{ $pembayaran->pelanggan->nama_pelanggan ?? 'N/A' }}</p>
                <p><strong>No. KWH:</strong> {{ $pembayaran->pelanggan->nomor_kwh ?? 'N/A' }}</p>
                <p><strong>No. Tagihan:</strong> {{ $pembayaran->tagihan->id ?? 'N/A' }}</p>
                <p><strong>Periode:</strong> {{ ($pembayaran->tagihan->bulan ?? 'N/A') . ' ' . ($pembayaran->tagihan->tahun ?? '') }}</p>
                <p><strong>Total Tagihan Awal:</strong> Rp {{ number_format($pembayaran->tagihan->total_tagihan ?? 0, 2, ',', '.') }}</p>
            </div>
        </div>

        <div class="mb-4">
            <label for="tanggal_pembayaran" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pembayaran:</label>
            <input type="date" id="tanggal_pembayaran" name="tanggal_pembayaran" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tanggal_pembayaran') border-red-500 @enderror" value="{{ old('tanggal_pembayaran', $pembayaran->tanggal_pembayaran->format('Y-m-d')) }}" required>
            @error('tanggal_pembayaran')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="biaya_admin" class="block text-gray-700 text-sm font-bold mb-2">Biaya Admin (Opsional):</label>
            <input type="number" step="0.01" id="biaya_admin" name="biaya_admin" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('biaya_admin') border-red-500 @enderror" value="{{ old('biaya_admin', $pembayaran->biaya_admin) }}" min="0" oninput="updateTotalBayarDisplay()">
            @error('biaya_admin')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 bg-gray-100 p-4 rounded-md border border-gray-200">
            <p class="text-gray-700 text-sm font-bold mb-2">Total yang Harus Dibayar (Termasuk Admin):</p>
            <p id="display_total_bayar" class="text-2xl font-extrabold text-green-700">Rp 0,00</p>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Pembayaran
            </button>
            @if(Auth::guard('web')->user()->level_id == 1)
                <a href="{{ route('admin.pembayarans.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">Batal</a>
            @elseif(Auth::guard('web')->user()->level_id == 2)
                <a href="{{ route('petugas.pembayarans.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">Batal</a>
            @endif
        </div>
    </form>
</div>

<script>
    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(amount);
    }

    function updateTotalBayarDisplay() {
        const totalTagihan = parseFloat({{ $pembayaran->tagihan->total_tagihan ?? 0 }});
        const biayaAdmin = parseFloat(document.getElementById('biaya_admin').value || 0);

        const totalBayar = totalTagihan + biayaAdmin;
        document.getElementById('display_total_bayar').textContent = formatRupiah(totalBayar);
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateTotalBayarDisplay();
    });
</script>
@endsection