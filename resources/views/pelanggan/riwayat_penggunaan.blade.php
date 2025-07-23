@extends('layouts.app')

@section('title', 'Riwayat Penggunaan Listrik')

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
    </style>
    <div class="bg-white p-8 rounded-none border-4 border-neutral-900 neo-brutal-shadow-black">
        <h1 class="text-4xl font-extrabold text-neutral-900 mb-8 uppercase">Riwayat Penggunaan Listrik Saya</h1>

        <div class="overflow-x-auto border-4 border-neutral-900 neo-brutal-shadow-black">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Bulan/Tahun</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Meter Awal</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Meter Akhir</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Jumlah Meter</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Dicatat Pada</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatPenggunaan as $penggunaan)
                        <tr class="border-b-2 border-neutral-200 hover:bg-sky-50 transition duration-150 ease-in-out">
                            <td class="py-3 px-4 text-neutral-900">{{ $penggunaan->bulan }} {{ $penggunaan->tahun }}</td>
                            <td class="py-3 px-4 text-neutral-900">{{ number_format($penggunaan->meter_awal, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-neutral-900">
                                {{ number_format($penggunaan->meter_akhir, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-neutral-900">
                                {{ number_format($penggunaan->jumlah_meter, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-neutral-900">{{ $penggunaan->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 px-4 text-center text-neutral-500 text-lg italic">Belum ada
                                riwayat penggunaan listrik.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-8">
            {{ $riwayatPenggunaan->links() }}
        </div>
    </div>
@endsection
