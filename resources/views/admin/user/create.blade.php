@extends('layouts.app')

@section('title', 'Tambah User Baru')

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
    <div class="bg-white p-4 rounded-none border-4 border-neutral-900 neo-brutal-shadow-black w-full max-w-lg mx-auto">
        <h1 class="text-4xl font-extrabold text-neutral-900 mb-8 text-center uppercase">Tambah User Baru</h1>

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

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="nama_user" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Nama User:</label>
                <input type="text" id="nama_user" name="nama_user"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('nama_user') border-red-500 @enderror"
                    value="{{ old('nama_user') }}" required autofocus>
                @error('nama_user')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="username" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Username:</label>
                <input type="text" id="username" name="username"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('username') border-red-500 @enderror"
                    value="{{ old('username') }}" required>
                @error('username')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="password" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Password:</label>
                <input type="password" id="password" name="password"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('password') border-red-500 @enderror"
                    required>
                @error('password')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-8">
                <label for="level_id" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Level:</label>
                <select id="level_id" name="level_id"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('level_id') border-red-500 @enderror"
                    required>
                    <option value="">-- Pilih Level --</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                            {{ $level->nama_level }}
                        </option>
                    @endforeach
                </select>
                @error('level_id')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between flex-wrap gap-4">
                <button type="submit"
                    class="bg-sky-500 hover:bg-sky-600 text-neutral-900 font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase flex-grow sm:flex-grow-0">
                    Simpan User
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="inline-block align-baseline font-extrabold text-lg text-neutral-600 hover:text-neutral-900 underline uppercase transition duration-200 ease-in-out">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
