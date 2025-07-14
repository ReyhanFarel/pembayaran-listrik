@extends('layouts.app')

@section('title', 'Manajemen Tarif Listrik Admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Tarif Listrik (Admin)</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Tombol Tambah Tarif (Hanya untuk Admin) --}}
    @if(Auth::guard('web')->user()->level_id == 1)
    <div class="mb-4 text-right">
        <a href="{{ route('admin.tarifs.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Tarif Baru
        </a>
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left text-gray-600">ID</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Daya (VA)</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Tarif per kWh (Rp)</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Terakhir Diperbarui</th>
                    <th class="py-2 px-4 border-b text-center text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tarifs as $tarif)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $tarif->id }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($tarif->daya, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">Rp {{ number_format($tarif->tarif_perkwh, 2, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">{{ $tarif->updated_at->format('d M Y H:i') }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        @if(Auth::guard('web')->user()->level_id == 1)
                        <a href="{{ route('admin.tarifs.edit', $tarif->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white text-sm py-1 px-3 rounded-md mr-2">Edit</a>
                        <form action="{{ route('admin.tarifs.destroy', $tarif->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tarif ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-sm py-1 px-3 rounded-md">Hapus</button>
                        </form>
                        @else
                            <span class="text-gray-500 text-sm">Tidak ada aksi</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 px-4 text-center text-gray-500">Belum ada data tarif.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection