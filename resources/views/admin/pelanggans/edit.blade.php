@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Pelanggan</h1>

    <form action="{{ route('admin.pelanggans.update', $pelanggan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="nama_pelanggan" class="block text-gray-700 text-sm font-bold mb-2">Nama Pelanggan:</label>
            <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_pelanggan') border-red-500 @enderror" value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" required autofocus>
            @error('nama_pelanggan')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
            <input type="text" id="username" name="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('username') border-red-500 @enderror" value="{{ old('username', $pelanggan->username) }}" required>
            @error('username')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password (isi jika ingin mengubah):</label>
            <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">Alamat:</label>
            <textarea id="alamat" name="alamat" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('alamat') border-red-500 @enderror" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
            @error('alamat')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="nomor_kwh" class="block text-gray-700 text-sm font-bold mb-2">Nomor KWH:</label> {{-- <-- Ganti label --}}
            <input type="text" id="nomor_kwh" name="nomor_kwh" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nomor_kwh') border-red-500 @enderror" value="{{ old('nomor_kwh', $pelanggan->nomor_kwh) }}" required> {{-- <-- Ganti name/id dan value --}}
            @error('nomor_kwh') {{-- <-- Ganti error check --}}
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="tarif_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Tarif:</label>
            <select id="tarif_id" name="tarif_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tarif_id') border-red-500 @enderror" required>
                <option value="">-- Pilih Tarif --</option>
                @foreach($tarifs as $tarif)
                    <option value="{{ $tarif->id }}" {{ old('tarif_id', $pelanggan->tarif_id) == $tarif->id ? 'selected' : '' }}>
                        {{ number_format($tarif->daya, 0, ',', '.') }} VA - Rp {{ number_format($tarif->tarif_perkwh, 2, ',', '.') }}/kWh
                    </option>
                @endforeach
            </select>
            @error('tarif_id')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Pelanggan
            </button>
            <a href="{{ route('admin.pelanggans.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection