@extends('layouts.app')

@section('title', 'Manajemen Penggunaan Listrik')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Penggunaan Listrik</h1>

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

    <div class="mb-4 text-right">
        @if(Auth::guard('web')->user()->level_id == 1)
            <a href="{{ route('admin.penggunaans.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Penggunaan Baru
            </a>
        @elseif(Auth::guard('web')->user()->level_id == 2)
            <a href="{{ route('petugas.penggunaans.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Penggunaan Baru
            </a>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left text-gray-600">ID</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Pelanggan</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">No. KWH</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Bulan/Tahun</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Meter Awal</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Meter Akhir</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Jumlah Meter</th>
                    <th class="py-2 px-4 border-b text-center text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penggunaans as $penggunaan)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $penggunaan->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $penggunaan->pelanggan->nama_pelanggan ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ $penggunaan->pelanggan->nomor_kwh ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ $penggunaan->bulan }} {{ $penggunaan->tahun }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($penggunaan->meter_awal, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($penggunaan->meter_akhir, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($penggunaan->jumlah_meter, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        @if(Auth::guard('web')->user()->level_id == 1) {{-- Admin --}}
                            <a href="{{ route('admin.penggunaans.edit', $penggunaan->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white text-sm py-1 px-3 rounded-md mr-2">Edit</a>
                            <form action="{{ route('admin.penggunaans.destroy', $penggunaan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penggunaan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-sm py-1 px-3 rounded-md">Hapus</button>
                            </form>
                        @elseif(Auth::guard('web')->user()->level_id == 2) {{-- Petugas --}}
                            <a href="{{ route('petugas.penggunaans.edit', $penggunaan->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white text-sm py-1 px-3 rounded-md mr-2">Edit</a>
                            <form action="{{ route('petugas.penggunaans.destroy', $penggunaan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penggunaan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-sm py-1 px-3 rounded-md">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-4 px-4 text-center text-gray-500">Belum ada data penggunaan listrik.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $penggunaans->links() }} {{-- Menampilkan pagination links --}}
    </div>
</div>
@endsection