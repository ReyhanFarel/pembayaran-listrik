@extends('layouts.app')

@section('title', 'Tambah Penggunaan Listrik')

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
        <h1 class="text-4xl font-extrabold text-neutral-900 mb-8 text-center uppercase">Tambah Penggunaan Listrik Baru</h1>

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

        <form
            action="{{ Auth::guard('web')->user()->level_id == 1 ? route('admin.penggunaans.store') : route('petugas.penggunaans.store') }}"
            method="POST">
            @csrf
            <div class="mb-6">
                <label for="pelanggan_id" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Pilih
                    Pelanggan:</label>
                <select id="pelanggan_id" name="pelanggan_id"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('pelanggan_id') border-red-500 @enderror"
                    required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach ($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                            {{ $pelanggan->nama_pelanggan }} (No. KWH: {{ $pelanggan->nomor_kwh }})
                        </option>
                    @endforeach
                </select>
                @error('pelanggan_id')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="bulan" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Bulan:</label>
                    <select id="bulan" name="bulan"
                        class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('bulan') border-red-500 @enderror"
                        required>
                        <option value="">-- Pilih Bulan --</option>
                        @php
                            $bulanNames = [
                                'Januari',
                                'Februari',
                                'Maret',
                                'April',
                                'Mei',
                                'Juni',
                                'Juli',
                                'Agustus',
                                'September',
                                'Oktober',
                                'November',
                                'Desember',
                            ];
                        @endphp
                        @foreach ($bulanNames as $bulanName)
                            <option value="{{ $bulanName }}" {{ old('bulan') == $bulanName ? 'selected' : '' }}>
                                {{ $bulanName }}</option>
                        @endforeach
                    </select>
                    @error('bulan')
                        <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="tahun" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Tahun:</label>
                    <input type="number" id="tahun" name="tahun"
                        class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('tahun') border-red-500 @enderror"
                        value="{{ old('tahun', date('Y')) }}" required min="2000" max="{{ date('Y') + 1 }}">
                    @error('tahun')
                        <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mb-6">
                <label for="meter_awal" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Meter
                    Awal:</label>
                <input type="number" id="meter_awal" name="meter_awal"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('meter_awal') border-red-500 @enderror"
                    value="{{ old('meter_awal') }}" required min="0">
                @error('meter_awal')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-8">
                <label for="meter_akhir" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Meter
                    Akhir:</label>
                <input type="number" id="meter_akhir" name="meter_akhir"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('meter_akhir') border-red-500 @enderror"
                    value="{{ old('meter_akhir') }}" required min="0">
                @error('meter_akhir')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between flex-wrap gap-4">
                <button type="submit"
                    class="bg-sky-500 hover:bg-sky-600 text-neutral-900 font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase flex-grow sm:flex-grow-0">
                    Simpan Penggunaan
                </button>
                @if (Auth::guard('web')->user()->level_id == 1)
                    <a href="{{ route('admin.penggunaans.index') }}"
                        class="inline-block align-baseline font-extrabold text-lg text-neutral-600 hover:text-neutral-900 underline uppercase transition duration-200 ease-in-out">Batal</a>
                @elseif(Auth::guard('web')->user()->level_id == 2)
                    <a href="{{ route('petugas.penggunaans.index') }}"
                        class="inline-block align-baseline font-extrabold text-lg text-neutral-600 hover:text-neutral-900 underline uppercase transition duration-200 ease-in-out">Batal</a>
                @endif
            </div>
        </form>
    </div>
@endsection
