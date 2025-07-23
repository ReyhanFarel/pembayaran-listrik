@extends('layouts.app')

@section('title', 'Buat Tagihan Baru')

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

        /* Custom style for checkboxes to make them more brutalist */
        .form-checkbox {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 1.5rem;
            /* h-6 */
            height: 1.5rem;
            /* w-6 */
            border: 2px solid #000;
            /* neutral-900 */
            background-color: #fff;
            cursor: pointer;
            display: inline-block;
            vertical-align: middle;
            position: relative;
            box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, 1);
            transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-checkbox:checked {
            background-color: #0ea5e9;
            /* sky-500 */
            border-color: #000;
            /* neutral-900 */
            box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, 1);
        }

        .form-checkbox:checked::after {
            content: '\2713';
            /* Checkmark character */
            color: #000;
            /* neutral-900 */
            font-size: 1rem;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .form-checkbox:focus {
            outline: none;
            box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, 1), 0 0 0 3px rgba(14, 165, 233, 0.5);
            /* sky-500 with opacity */
        }
    </style>
    <div class="bg-white p-8 rounded-none border-4 border-neutral-900 neo-brutal-shadow-black w-full max-w-2xl mx-auto">
        <h1 class="text-4xl font-extrabold text-neutral-900 mb-8 text-center uppercase">Buat Tagihan dari Penggunaan</h1>

        @if (session('success'))
            <div class="bg-green-600 text-white px-4 py-3 rounded-none border-2 border-neutral-900 neo-brutal-shadow-black relative mb-6"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-600 text-white px-4 py-3 rounded-none border-2 border-neutral-900 neo-brutal-shadow-black relative mb-6"
                role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
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

        <p class="mb-6 text-neutral-900 text-lg">Pilih data penggunaan listrik yang ingin Anda buat tagihannya. Hanya data
            penggunaan yang belum memiliki tagihan yang akan ditampilkan.</p>

        <form
            action="{{ Auth::guard('web')->user()->level_id == 1 ? route('admin.tagihans.generate') : route('petugas.tagihans.generate') }}"
            method="POST">
            @csrf
            <div class="overflow-x-auto mb-8 border-2 border-neutral-900 neo-brutal-shadow-black p-4 bg-sky-50">
                @forelse($penggunaansBelumDitagih as $penggunaan)
                    <div
                        class="flex items-center bg-white p-4 rounded-none border-2 border-neutral-900 neo-brutal-shadow-black mb-4 last:mb-0">
                        <input type="checkbox" name="penggunaan_ids[]" value="{{ $penggunaan->id }}"
                            id="penggunaan-{{ $penggunaan->id }}" class="form-checkbox h-6 w-6 text-sky-600">
                        <label for="penggunaan-{{ $penggunaan->id }}" class="ml-4 text-neutral-900 flex-1 text-base">
                            <span
                                class="font-extrabold text-sky-700">{{ $penggunaan->pelanggan->nama_pelanggan ?? 'N/A' }}</span>
                            (No. KWH: <span class="font-semibold">{{ $penggunaan->pelanggan->nomor_kwh ?? 'N/A' }}</span>)
                            -
                            Penggunaan Bulan <span class="font-semibold">{{ $penggunaan->bulan }}
                                {{ $penggunaan->tahun }}</span> ({{ $penggunaan->meter_awal }} -
                            {{ $penggunaan->meter_akhir }})
                        </label>
                    </div>
                @empty
                    <p class="text-center text-neutral-500 py-4 text-lg italic">Tidak ada data penggunaan yang belum
                        ditagih.</p>
                @endforelse
            </div>

            <div class="flex justify-between items-center flex-wrap gap-4">
                <button type="submit"
                    class="bg-sky-500 hover:bg-sky-600 text-neutral-900 font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase flex-grow sm:flex-grow-0"
                    @if ($penggunaansBelumDitagih->isEmpty()) disabled @endif>
                    Generate Tagihan
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
