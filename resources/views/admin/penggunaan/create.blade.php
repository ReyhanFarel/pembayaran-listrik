@extends('layouts.app')

@section('title', 'Tambah Penggunaan Listrik')
@section('page_title', 'Tambah Penggunaan Listrik Baru')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('penggunaan.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="id_pelanggan" class="block text-gray-700 text-sm font-bold mb-2">Pelanggan:</label>
                <select name="id_pelanggan" id="id_pelanggan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('id_pelanggan') border-red-500 @enderror" required>
                    <option value="">Pilih Pelanggan</option>
                    @foreach($pelanggan as $p)
                        <option value="{{ $p->id }}" {{ old('id_pelanggan') == $p->id ? 'selected' : '' }}>{{ $p->nama_pelanggan }} (Daya: {{ $p->daya }} VA)</option>
                    @endforeach
                </select>
                @error('id_pelanggan')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="bulan" class="block text-gray-700 text-sm font-bold mb-2">Bulan:</label>
                <input type="text" name="bulan" id="bulan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('bulan') border-red-500 @enderror" value="{{ old('bulan') }}" placeholder="Contoh: Januari" required>
                @error('bulan')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tahun" class="block text-gray-700 text-sm font-bold mb-2">Tahun:</label>
                <input type="number" name="tahun" id="tahun" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tahun') border-red-500 @enderror" value="{{ old('tahun', date('Y')) }}" required>
                @error('tahun')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="meter_awal" class="block text-gray-700 text-sm font-bold mb-2">Meter Awal (KWH):</label>
                <input type="number" name="meter_awal" id="meter_awal" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('meter_awal') border-red-500 @enderror" value="{{ old('meter_awal') }}" required>
                @error('meter_awal')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="meter_akhir" class="block text-gray-700 text-sm font-bold mb-2">Meter Akhir (KWH):</label>
                <input type="number" name="meter_akhir" id="meter_akhir" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('meter_akhir') border-red-500 @enderror" value="{{ old('meter_akhir') }}" required>
                @error('meter_akhir')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan Penggunaan
                </button>
                <a href="{{ route('penggunaan.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection