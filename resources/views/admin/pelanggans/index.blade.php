@extends('layouts.app')

@section('title', 'Manajemen Pelanggan Admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Pelanggan (Admin)</h1>

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
        <a href="{{ route('admin.pelanggans.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Pelanggan Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                   
                    <th class="py-2 px-4 border-b text-left text-gray-600">Nama Pelanggan</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Username</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Alamat</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">No. KWH</th> {{-- <-- Ganti Daya menjadi No. KWH --}}
                    <th class="py-2 px-4 border-b text-left text-gray-600">Daya/Tarif</th> {{-- <-- Menampilkan Daya dari Tarif --}}
                    <th class="py-2 px-4 border-b text-center text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggans as $pelanggan)
                <tr class="hover:bg-gray-50">
                  
                    <td class="py-2 px-4 border-b">{{ $pelanggan->nama_pelanggan }}</td>
                    <td class="py-2 px-4 border-b">{{ $pelanggan->username }}</td>
                    <td class="py-2 px-4 border-b">{{ $pelanggan->alamat }}</td>
                    <td class="py-2 px-4 border-b">{{ $pelanggan->nomor_kwh }}</td> {{-- <-- Tampilkan nomor_kwh --}}
                    <td class="py-2 px-4 border-b">
                        @if($pelanggan->tarifs)
                            {{ number_format($pelanggan->tarifs->daya, 0, ',', '.') }} VA (Rp {{ number_format($pelanggan->tarifs->tarif_perkwh, 2, ',', '.') }}/kWh)
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ route('admin.pelanggans.edit', $pelanggan->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white text-sm py-1 px-3 rounded-md mr-2">Edit</a>
                        <form action="{{ route('admin.pelanggans.destroy', $pelanggan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-sm py-1 px-3 rounded-md">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-4 px-4 text-center text-gray-500">Belum ada data pelanggan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection