@extends('layouts.app')

@section('title', 'Manajemen Tarif Listrik Admin')

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
        <h1 class="text-4xl font-extrabold text-neutral-900 mb-8 uppercase">Daftar Tarif Listrik (Admin)</h1>

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

        {{-- Tombol Tambah Tarif (Hanya untuk Admin) --}}
        @if (Auth::guard('web')->user()->level_id == 1)
            <div class="mb-6 text-right">
                <a href="{{ route('admin.tarifs.create') }}"
                    class="inline-block bg-sky-500 hover:bg-sky-600 text-neutral-900 font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase">
                    Tambah Tarif Baru
                </a>
            </div>
        @endif

        <div class="overflow-x-auto border-4 border-neutral-900 neo-brutal-shadow-black">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            ID</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Daya (VA)</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Tarif per kWh (Rp)</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Terakhir Diperbarui</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-center text-black font-extrabold uppercase">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tarifs as $tarif)
                        <tr class="border-b-2 border-neutral-200 hover:bg-sky-50 transition duration-150 ease-in-out">
                            <td class="py-3 px-4 text-neutral-900">{{ $tarif->id }}</td>
                            <td class="py-3 px-4 text-neutral-900">{{ number_format($tarif->daya, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-neutral-900">Rp {{ number_format($tarif->tarif_perkwh, 2, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-neutral-900">{{ $tarif->updated_at->format('d M Y H:i') }}</td>
                            <td class="py-3 px-4 text-center">
                                @if (Auth::guard('web')->user()->level_id == 1)
                                    <a href="{{ route('admin.tarifs.edit', $tarif->id) }}"
                                        class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-bold py-2 px-4 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow mr-3 transition duration-200 ease-in-out transform hover:-translate-y-1">Edit</a>
                                    <form action="{{ route('admin.tarifs.destroy', $tarif->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus tarif ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">Hapus</button>
                                    </form>
                                @else
                                    <span class="text-neutral-500 text-sm italic">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 px-4 text-center text-neutral-500 text-lg italic">Belum ada data
                                tarif.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
