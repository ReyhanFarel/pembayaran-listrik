@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
    <style>
        /* Custom Neo-Brutalism Shadows - ensure these are defined if not coming from layouts.app */
        .neo-brutal-shadow-black {
            box-shadow: 8px 8px 0px 0px rgba(0, 0, 0, 1);
            /* Black shadow */
        }

        .neo-brutal-button-shadow {
            box-shadow: 6px 6px 0px 0px rgba(0, 0, 0, 1);
            /* Black shadow for buttons */
        }

        .neo-brutal-input-shadow {
            box-shadow: 4px 4px 0px 0px rgba(0, 0, 0, 1);
            /* Black shadow for inputs */
        }
    </style>
    <div class="bg-white p-8 rounded-none border-4 border-neutral-900 neo-brutal-shadow-black">
        <h1 class="text-4xl font-extrabold text-neutral-900 mb-8 uppercase">Selamat Datang, {{ $pelanggan->nama_pelanggan }}!
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            {{-- Card Tagihan Terakhir --}}
            <div
                class="bg-blue-600 text-white p-6 rounded-none border-4 border-neutral-900 neo-brutal-button-shadow flex flex-col items-start justify-between h-52 relative overflow-hidden">
                <div class="text-xl font-bold uppercase mb-2">Tagihan Terakhir</div>
                @if ($lastUnpaidTagihan)
                    <div class="text-4xl font-black mb-1">Rp
                        {{ number_format($lastUnpaidTagihan->total_tagihan, 2, ',', '.') }}</div>
                    <div class="text-base font-semibold mb-1">Bulan {{ $lastUnpaidTagihan->bulan }}
                        {{ $lastUnpaidTagihan->tahun }}</div>
                    <div class="text-base font-bold mt-auto">Status: <span
                            class="px-3 py-1 bg-white text-blue-600 rounded-none border-2 border-neutral-900">{{ $lastUnpaidTagihan->status_tagihan }}</span>
                    </div>
                @else
                    <div class="text-4xl font-black">Tidak Ada</div>
                    <div class="text-lg font-bold mt-auto">Tagihan Belum Lunas</div>
                @endif
                <svg class="w-16 h-16 opacity-75 text-white absolute bottom-4 right-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>

            {{-- Card Penggunaan Terakhir --}}
            <div
                class="bg-green-600 text-white p-6 rounded-none border-4 border-neutral-900 neo-brutal-button-shadow flex flex-col items-start justify-between h-52 relative overflow-hidden">
                <div class="text-xl font-bold uppercase mb-2">Penggunaan Terakhir</div>
                @if ($lastPenggunaan)
                    <div class="text-4xl font-black mb-1">{{ number_format($lastPenggunaan->jumlah_meter, 0, ',', '.') }}
                        KWH</div>
                    <div class="text-base font-semibold mb-1">Bulan {{ $lastPenggunaan->bulan }}
                        {{ $lastPenggunaan->tahun }}</div>
                    <div class="text-sm">Meter Awal: <span
                            class="font-bold">{{ number_format($lastPenggunaan->meter_awal, 0, ',', '.') }}</span></div>
                    <div class="text-sm">Meter Akhir: <span
                            class="font-bold">{{ number_format($lastPenggunaan->meter_akhir, 0, ',', '.') }}</span></div>
                @else
                    <div class="text-4xl font-black">Belum Ada</div>
                    <div class="text-lg font-bold mt-auto">Data Penggunaan</div>
                @endif
                <svg class="w-16 h-16 opacity-75 text-white absolute bottom-4 right-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                    </path>
                </svg>
            </div>

            {{-- Card Info Daya/KWH --}}
            <div
                class="bg-purple-600 text-white p-6 rounded-none border-4 border-neutral-900 neo-brutal-button-shadow flex flex-col items-start justify-between h-52 relative overflow-hidden">
                <div class="text-xl font-bold uppercase mb-2">Info Sambungan</div>
                <div class="text-4xl font-black mb-1">No. KWH: {{ $pelanggan->nomor_kwh }}</div>
                <div class="text-xl font-bold mt-auto">Daya Terpasang: {{ optional($pelanggan->tarifs)->daya ?? 'N/A' }} VA
                </div>
                <svg class="w-16 h-16 opacity-75 text-white absolute bottom-4 right-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
        </div>

        <div class="mt-8 p-4 rounded-none border-4 border-neutral-900 neo-brutal-shadow-black bg-sky-300">
            <div class="bg-sky-300 rounded-none p-6">
                <h2 class="text-3xl font-extrabold text-neutral-900 mb-6 flex items-center uppercase">
                    <svg class="w-8 h-8 text-neutral-900 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m4 0h-1v4h-1m-4 0h-1v-4h-1"></path>
                    </svg>
                    Akses Cepat
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="{{ route('pelanggan.riwayat_penggunaan') }}"
                        class="flex items-center bg-fuchsia-500 hover:bg-fuchsia-700 text-white border-2 border-neutral-900 neo-brutal-button-shadow rounded-none p-5 transition duration-200 ease-in-out transform hover:-translate-y-1">
                        <svg class="w-9 h-9 text-white opacity-75 mr-4 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 17a4 4 0 01-4-4V7a4 4 0 018 0v6a4 4 0 01-4 4zm0 0v2m0 0h2m-2 0H9"></path>
                        </svg>
                        <span class="font-bold text-lg uppercase">Riwayat Penggunaan Listrik Saya</span>
                    </a>
                    <a href="{{ route('pelanggan.tagihan_saya') }}"
                        class="flex items-center bg-lime-500 hover:bg-lime-700 text-white border-2 border-neutral-900 neo-brutal-button-shadow rounded-none p-5 transition duration-200 ease-in-out transform hover:-translate-y-1">
                        <svg class="w-9 h-9 text-white opacity-75 mr-4 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2a4 4 0 014-4h1a4 4 0 014 4v2m-7 0h7"></path>
                        </svg>
                        <span class="font-bold text-lg uppercase">Semua Tagihan Saya</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
