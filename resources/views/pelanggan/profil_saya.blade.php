@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <style>
        /* Custom Neo-Brutalism Shadows - ensure these are defined if not coming from layouts.app */
        .neo-brutal-shadow-black {
            box-shadow: 8px 8px 0px 0px rgba(0, 0, 0, 1);
            /* Black shadow */
        }

        .neo-brutal-input-shadow {
            box-shadow: 4px 4px 0px 0px rgba(0, 0, 0, 1);
            /* Black shadow for inputs */
        }

        .neo-brutal-button-shadow {
            box-shadow: 6px 6px 0px 0px rgba(0, 0, 0, 1);
            /* Black shadow for buttons */
        }
    </style>
    <div class="bg-white p-8 rounded-none border-4 border-neutral-900 neo-brutal-shadow-black w-full max-w-lg mx-auto">
        <h1 class="text-4xl font-extrabold text-neutral-900 mb-8 text-center uppercase">Profil Saya</h1>

        @if (session('success'))
            <div class="bg-green-600 text-white px-4 py-3 rounded-none border-2 border-neutral-900 neo-brutal-shadow-black relative mb-6"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-600 text-white px-4 py-3 rounded-none border-2 border-neutral-900 neo-brutal-shadow-black relative mb-6"
                role="alert">
                <strong class="font-extrabold block mb-2">OOPS!</strong>
                <span class="block sm:inline">Ada beberapa masalah dengan input Anda:</span>
                <ul class="mt-3 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pelanggan.update_profil') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="nama_pelanggan" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Nama
                    Lengkap:</label>
                <input type="text" id="nama_pelanggan" name="nama_pelanggan"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('nama_pelanggan') border-red-500 @enderror"
                    value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" required>
                @error('nama_pelanggan')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="username" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Username:</label>
                <input type="text" id="username" name="username"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('username') border-red-500 @enderror"
                    value="{{ old('username', $pelanggan->username) }}" required>
                @error('username')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="alamat" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Alamat:</label>
                <textarea id="alamat" name="alamat" rows="3"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:outline-none focus:shadow-outline bg-white @error('alamat') border-red-500 @enderror"
                    required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Info yang tidak bisa diubah pelanggan --}}
            <div class="mb-6 p-6 bg-neutral-100 rounded-none border-2 border-neutral-900 neo-brutal-shadow-black">
                <h3 class="text-xl font-extrabold text-neutral-900 mb-4 uppercase">Informasi Lain (Tidak Dapat Diubah):</h3>
                <p class="text-neutral-900 text-base mb-2"><strong>Nomor KWH:</strong> <span
                        class="font-semibold">{{ $pelanggan->nomor_kwh }}</span></p>
                <p class="text-neutral-900 text-base"><strong>Daya Terpasang:</strong> <span
                        class="font-semibold">{{ optional($pelanggan->tarifs)->daya ?? 'N/A' }} VA</span></p>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Password Baru (isi
                    jika ingin mengubah):</label>
                <input type="password" id="password" name="password"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label for="password_confirmation"
                    class="block text-neutral-900 text-base font-bold mb-3 uppercase">Konfirmasi Password Baru:</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:outline-none focus:shadow-outline bg-white">
            </div>

            <div class="flex items-center justify-between flex-wrap gap-4">
                <button type="submit"
                    class="bg-sky-500 hover:bg-sky-600 text-neutral-900 font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase flex-grow sm:flex-grow-0">
                    Update Profil
                </button>
                <a href="{{ route('pelanggan.dashboard') }}"
                    class="inline-block align-baseline font-extrabold text-lg text-neutral-600 hover:text-neutral-900 underline uppercase transition duration-200 ease-in-out">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
