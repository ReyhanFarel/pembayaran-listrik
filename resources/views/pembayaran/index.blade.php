@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')

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
        <h1 class="text-3xl font-extrabold text-neutral-900 mb-8 uppercase">Daftar Pembayaran</h1>

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

        <div class="mb-6 text-right">
            @if (Auth::guard('web')->user()->level_id == 1)
                <a href="{{ route('admin.pembayarans.create') }}"
                    class="inline-block bg-sky-500 hover:bg-sky-600 text-neutral-900 font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase">
                    Catat Pembayaran Baru
                </a>
            @elseif(Auth::guard('web')->user()->level_id == 2)
                <a href="{{ route('petugas.pembayarans.create') }}"
                    class="inline-block bg-sky-500 hover:bg-sky-600 text-neutral-900 font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase">
                    Catat Pembayaran Baru
                </a>
            @endif
        </div>

        <div class="overflow-x-auto border-4 border-neutral-900 neo-brutal-shadow-black">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Pelanggan</th>
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
                            Total Bayar</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Tgl. Bayar</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Dicatat Oleh</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-center text-black font-extrabold uppercase">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayarans as $pembayaran)
                        <tr class="border-b-2 border-neutral-200 hover:bg-sky-50 transition duration-150 ease-in-out">
                            <td class="py-3 px-4 text-neutral-900">{{ $pembayaran->pelanggan->nama_pelanggan ?? 'N/A' }}
                            </td>
                            <td class="py-3 px-4 text-neutral-900">{{ $pembayaran->tagihan->id ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-neutral-900">
                                {{ ($pembayaran->tagihan->bulan ?? 'N/A') . ' ' . ($pembayaran->tagihan->tahun ?? '') }}
                            </td>
                            <td class="py-3 px-4 text-neutral-900">Rp
                                {{ number_format($pembayaran->tagihan->total_tagihan ?? 0, 2, ',', '.') }}</td>
                            <td class="py-3 px-4 text-neutral-900">Rp
                                {{ number_format($pembayaran->biaya_admin, 2, ',', '.') }}</td>
                            <td class="py-3 px-4 text-neutral-900">Rp
                                {{ number_format($pembayaran->total_bayar, 2, ',', '.') }}</td>
                            <td class="py-3 px-4 text-neutral-900">{{ $pembayaran->tanggal_pembayaran->format('d M Y') }}
                            </td>
                            <td class="py-3 px-4 text-neutral-900">
                                {{ $pembayaran->user->nama_user ?? 'Dibayar Oleh Pelanggan' }}</td>
                            <td class="py-3 px-4 text-center flex justify-center items-center gap-1">
                                {{-- Aksi Detail --}}
                                {{-- Aksi Edit dan Hapus --}}
                                @if (Auth::guard('web')->user()->level_id == 1)
                                    <a href="{{ route('admin.pembayarans.edit', $pembayaran->id) }}"
                                        class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-bold py-2 px-4 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow mr-3 transition duration-200 ease-in-out transform hover:-translate-y-1">Edit</a>
                                    <form action="{{ route('admin.pembayarans.destroy', $pembayaran->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini? Status tagihan akan dikembalikan menjadi Belum Lunas.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">Hapus</button>
                                    </form>
                                @elseif(Auth::guard('web')->user()->level_id == 2)
                                    <a href="{{ route('petugas.pembayarans.edit', $pembayaran->id) }}"
                                        class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-bold py-2 px-4 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow mr-3 transition duration-200 ease-in-out transform hover:-translate-y-1">Edit</a>
                                    <form action="{{ route('petugas.pembayarans.destroy', $pembayaran->id) }}"
                                        method="POST" class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini? Status tagihan akan dikembalikan menjadi Belum Lunas.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-6 px-4 text-center text-neutral-500 text-lg italic">Belum ada data
                                pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-8">
            {{ $pembayarans->links() }}
        </div>
    </div>
@endsection
