@extends('layouts.app')

@section('title', 'Tambah Tarif Listrik')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Tambah Tarif Baru</h1>

    <form action="{{ route('admin.tarifs.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="daya" class="block text-gray-700 text-sm font-bold mb-2">Daya (VA):</label>
            <input type="number" id="daya" name="daya" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('daya') border-red-500 @enderror" value="{{ old('daya') }}" required>
            @error('daya')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="tarif_perkwh" class="block text-gray-700 text-sm font-bold mb-2">Tarif per kWh (Rp):</label>
            <input type="number" step="0.01" id="tarif_perkwh" name="tarif_perkwh" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tarif_perkwh') border-red-500 @enderror" value="{{ old('tarif_perkwh') }}" required>
            @error('tarif_perkwh')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan Tarif
            </button>
            <a href="{{ route('admin.tarifs.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection