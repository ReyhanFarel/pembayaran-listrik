@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Profil Saya</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
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

    <form action="{{ route('pelanggan.update_profil') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama_pelanggan" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap:</label>
            <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_pelanggan') border-red-500 @enderror" value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" required>
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
            <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">Alamat:</label>
            <textarea id="alamat" name="alamat" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('alamat') border-red-500 @enderror" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
            @error('alamat')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Info yang tidak bisa diubah pelanggan --}}
        <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Informasi Lain (Tidak Dapat Diubah):</h3>
            <p class="text-gray-600 mb-1"><strong>Nomor KWH:</strong> {{ $pelanggan->nomor_kwh }}</p>
            <p class="text-gray-600"><strong>Daya Terpasang:</strong> {{ optional($pelanggan->tarifs)->daya ?? 'N/A' }} VA</p>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password Baru (isi jika ingin mengubah):</label>
            <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password Baru:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Profil
            </button>
            <a href="{{ route('pelanggan.dashboard') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection