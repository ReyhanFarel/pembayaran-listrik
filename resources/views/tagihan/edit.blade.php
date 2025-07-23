@extends('layouts.app')

@section('title', 'Edit Status Tagihan')

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
        <h1 class="text-4xl font-extrabold text-neutral-900 mb-8 text-center uppercase">Edit Status Tagihan</h1>

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
            action="{{ Auth::guard('web')->user()->level_id == 1 ? route('admin.tagihans.update', $tagihan->id) : route('petugas.tagihans.update', $tagihan->id) }}"
            method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label class="block text-neutral-900 text-base font-bold mb-3 uppercase">Detail Tagihan:</label>
                <div class="bg-neutral-100 p-6 rounded-none border-2 border-neutral-900 neo-brutal-shadow-black">
                    <p class="text-neutral-900 mb-2"><strong>Pelanggan:</strong> <span
                            class="font-semibold">{{ $tagihan->pelanggan->nama_pelanggan ?? 'N/A' }}</span></p>
                    <p class="text-neutral-900 mb-2"><strong>No. KWH:</strong> <span
                            class="font-semibold">{{ $tagihan->pelanggan->nomor_kwh ?? 'N/A' }}</span></p>
                    <p class="text-neutral-900 mb-2"><strong>Periode:</strong> <span
                            class="font-semibold">{{ $tagihan->bulan }} {{ $tagihan->tahun }}</span></p>
                    <p class="text-neutral-900 mb-2"><strong>Jumlah Meter:</strong> <span
                            class="font-semibold">{{ number_format($tagihan->jumlah_meter, 0, ',', '.') }} KWH</span></p>
                    <p class="text-neutral-900 mb-2"><strong>Daya/Tarif:</strong>
                        @if ($tagihan->tarif_data)
                            <span class="font-semibold">{{ number_format($tagihan->tarif_data->daya, 0, ',', '.') }} VA (Rp
                                {{ number_format($tagihan->tarif_data->tarif_perkwh, 2, ',', '.') }}/kWh)</span>
                        @else
                            N/A
                        @endif
                    </p>
                    <p class="mt-4 text-2xl font-extrabold text-sky-700"><strong>Total Tagihan:</strong> Rp
                        {{ number_format($tagihan->total_tagihan, 2, ',', '.') }}</p>
                </div>
            </div>

            <div class="mb-8">
                <label for="status_tagihan" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Status
                    Tagihan:</label>
                <select id="status_tagihan" name="status_tagihan"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('status_tagihan') border-red-500 @enderror"
                    required>
                    <option value="Belum Dibayar"
                        {{ old('status_tagihan', $tagihan->status_tagihan) == 'Belum Dibayar' ? 'selected' : '' }}>Belum
                        Dibayar</option>
                    <option value="Sudah Dibayar"
                        {{ old('status_tagihan', $tagihan->status_tagihan) == 'Sudah Dibayar' ? 'selected' : '' }}>Sudah
                        Dibayar</option>
                </select>
                @error('status_tagihan')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between flex-wrap gap-4">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase flex-grow sm:flex-grow-0">
                    Update Status
                </button>
                @if (Auth::guard('web')->user()->level_id == 1)
                    <a href="{{ route('admin.tagihans.index') }}"
                        class="inline-block align-baseline font-extrabold text-lg text-neutral-600 hover:text-neutral-900 underline uppercase transition duration-200 ease-in-out">Batal</a>
                @elseif(Auth::guard('web')->user()->level_id == 2)
                    <a href="{{ route('petugas.tagihans.index') }}"
                        class="inline-block align-baseline font-extrabold text-lg text-neutral-600 hover:text-neutral-900 underline uppercase transition duration-200 ease-in-out">Batal</a>
                @endif
            </div>
        </form>
    </div>
@endsection
