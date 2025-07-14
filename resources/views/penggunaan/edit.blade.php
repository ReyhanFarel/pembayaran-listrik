@extends('layouts.app')

@section('title', 'Edit Penggunaan Listrik')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Penggunaan Listrik</h1>

    <form action="{{ Auth::guard('web')->user()->level_id == 1 ? route('admin.penggunaans.update', $penggunaan->id) : route('petugas.penggunaans.update', $penggunaan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="pelanggan_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Pelanggan:</label>
            <select id="pelanggan_id" name="pelanggan_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('pelanggan_id') border-red-500 @enderror" required>
                <option value="">-- Pilih Pelanggan --</option>
                @foreach($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id', $penggunaan->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
                        {{ $pelanggan->nama_pelanggan }} (No. KWH: {{ $pelanggan->nomor_kwh }})
                    </option>
                @endforeach
            </select>
            @error('pelanggan_id')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="bulan" class="block text-gray-700 text-sm font-bold mb-2">Bulan:</label>
                <select id="bulan" name="bulan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('bulan') border-red-500 @enderror" required>
                    <option value="">-- Pilih Bulan --</option>
                    @php
                        $bulanNames = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                    @endphp
                    @foreach($bulanNames as $bulanName)
                        <option value="{{ $bulanName }}" {{ old('bulan', $penggunaan->bulan) == $bulanName ? 'selected' : '' }}>{{ $bulanName }}</option>
                    @endforeach
                </select>
                @error('bulan')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="tahun" class="block text-gray-700 text-sm font-bold mb-2">Tahun:</label>
                <input type="number" id="tahun" name="tahun" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tahun') border-red-500 @enderror" value="{{ old('tahun', $penggunaan->tahun) }}" required min="2000" max="{{ date('Y') + 1 }}">
                @error('tahun')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="mb-4">
            <label for="meter_awal" class="block text-gray-700 text-sm font-bold mb-2">Meter Awal:</label>
            <input type="number" id="meter_awal" name="meter_awal" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('meter_awal') border-red-500 @enderror" value="{{ old('meter_awal', $penggunaan->meter_awal) }}" required min="0">
            @error('meter_awal')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="meter_akhir" class="block text-gray-700 text-sm font-bold mb-2">Meter Akhir:</label>
            <input type="number" id="meter_akhir" name="meter_akhir" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('meter_akhir') border-red-500 @enderror" value="{{ old('meter_akhir', $penggunaan->meter_akhir) }}" required min="0">
            @error('meter_akhir')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Penggunaan
            </button>
            @if(Auth::guard('web')->user()->level_id == 1)
                <a href="{{ route('admin.penggunaans.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">Batal</a>
            @elseif(Auth::guard('web')->user()->level_id == 2)
                <a href="{{ route('petugas.penggunaans.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">Batal</a>
            @endif
        </div>
    </form>
</div>
@endsection