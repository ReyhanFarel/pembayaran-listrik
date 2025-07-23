@extends('layouts.app')

@section('title', 'Riwayat Pembayaran Saya')

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
    <div class="bg-white p-8 rounded-none border-4 border-neutral-900 neo-brutal-shadow-black">
        <h1 class="text-4xl font-extrabold text-neutral-900 mb-8 uppercase">Riwayat Pembayaran Saya</h1>

        <form method="GET" class="mb-6 flex flex-wrap gap-4 items-center">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari bulan/tahun/total bayar"
                class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white flex-grow sm:flex-grow-0">
            <select name="sort"
                class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white">
                <option value="tanggal_pembayaran" {{ request('sort') == 'tanggal_pembayaran' ? 'selected' : '' }}>Tanggal
                    Pembayaran</option>
                <option value="total_bayar" {{ request('sort') == 'total_bayar' ? 'selected' : '' }}>Total Bayar</option>
            </select>
            <select name="direction"
                class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white">
                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Terlama</option>
            </select>
            <button type="submit"
                class="bg-sky-500 hover:bg-sky-600 text-neutral-900 font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase flex-grow sm:flex-grow-0">
                Cari/Sort
            </button>
        </form>

        <div class="overflow-x-auto border-4 border-neutral-900 neo-brutal-shadow-black">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            ID Pembayaran</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            No. Tagihan</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Periode Tagihan</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Total Tagihan</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Biaya Admin</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Total Dibayar</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Tanggal Pembayaran</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Dicatat Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatPembayaran as $pembayaran)
                        <tr class="border-b-2 border-neutral-200 hover:bg-sky-50 transition duration-150 ease-in-out">
                            <td class="py-3 px-4 text-neutral-900">{{ $pembayaran->id }}</td>
                            <td class="py-3 px-4 text-neutral-900">{{ $pembayaran->tagihan->id ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-neutral-900">
                                {{ ($pembayaran->tagihan->bulan ?? 'N/A') . ' ' . ($pembayaran->tagihan->tahun ?? '') }}
                            </td>
                            <td class="py-3 px-4 text-neutral-900">Rp
                                {{ number_format($pembayaran->tagihan->total_tagihan ?? 0, 2, ',', '.') }}</td>
                            <td class="py-3 px-4 text-neutral-900">Rp
                                {{ number_format($pembayaran->biaya_admin, 2, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-neutral-900">Rp
                                {{ number_format($pembayaran->total_bayar, 2, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-neutral-900">{{ $pembayaran->tanggal_pembayaran->format('d M Y') }}
                            </td>
                            <td class="py-3 px-4 text-neutral-900">
                                {{ $pembayaran->user->nama_user ?? 'Dibayar Oleh Pelanggan' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-6 px-4 text-center text-neutral-500 text-lg italic">Belum ada
                                riwayat pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-8">
            {{ $riwayatPembayaran->links() }}
        </div>
    </div>
@endsection
