@extends('layouts.app')

@section('title', 'Edit Tarif Listrik')

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
        <h1 class="text-4xl font-extrabold text-neutral-900 mb-8 text-center uppercase">Edit Tarif</h1>

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

        <form action="{{ route('admin.tarifs.update', $tarif->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="daya" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Daya (VA):</label>
                <input type="number" id="daya" name="daya"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('daya') border-red-500 @enderror"
                    value="{{ old('daya', $tarif->daya) }}" required>
                @error('daya')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-8">
                <label for="tarif_perkwh" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Tarif per kWh
                    (Rp):</label>
                <input type="number" step="0.01" id="tarif_perkwh" name="tarif_perkwh"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('tarif_perkwh') border-red-500 @enderror"
                    value="{{ old('tarif_perkwh', $tarif->tarif_perkwh) }}" required>
                @error('tarif_perkwh')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between flex-wrap gap-4">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase flex-grow sm:flex-grow-0">
                    Update Tarif
                </button>
                <a href="{{ route('admin.tarifs.index') }}"
                    class="inline-block align-baseline font-extrabold text-lg text-neutral-600 hover:text-neutral-900 underline uppercase transition duration-200 ease-in-out">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
