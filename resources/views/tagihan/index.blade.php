@extends('layouts.app')

@section('title', 'Manajemen Tagihan Listrik')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Tagihan Listrik</h1>

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

    <div class="mb-4 flex justify-between items-center">
        <div>
            {{-- Filter/Search (Akan ditambahkan nanti) --}}
        </div>
        <div class="text-right">
            @if(Auth::guard('web')->user()->level_id == 1)
                <a href="{{ route('admin.tagihans.create_from_penggunaan') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Buat Tagihan Dari Penggunaan
                </a>
            @elseif(Auth::guard('web')->user()->level_id == 2)
                <a href="{{ route('petugas.tagihans.create_from_penggunaan') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Buat Tagihan Dari Penggunaan
                </a>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left text-gray-600">ID</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Pelanggan</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">No. KWH</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Bulan/Tahun</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Jumlah Meter</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Total Tagihan</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Status</th>
                    <th class="py-2 px-4 border-b text-center text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tagihans as $tagihan)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $tagihan->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $tagihan->pelanggan->nama_pelanggan ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ $tagihan->pelanggan->nomor_kwh ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ $tagihan->bulan }} {{ $tagihan->tahun }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($tagihan->jumlah_meter, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">Rp {{ number_format($tagihan->total_tagihan, 2, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $tagihan->status_tagihan == 'Sudah Dibayar' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $tagihan->status_tagihan }}
                        </span>
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        @if(Auth::guard('web')->user()->level_id == 1)
                            <a href="{{ route('admin.tagihans.edit', $tagihan->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white text-sm py-1 px-3 rounded-md mr-2">Edit Status</a>
                            <form action="{{ route('admin.tagihans.destroy', $tagihan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tagihan ini? (Ini juga akan menghapus pembayaran terkait jika ada)');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-sm py-1 px-3 rounded-md">Hapus</button>
                            </form>
                        @elseif(Auth::guard('web')->user()->level_id == 2)
                            <a href="{{ route('petugas.tagihans.edit', $tagihan->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white text-sm py-1 px-3 rounded-md mr-2">Edit Status</a>
                            <form action="{{ route('petugas.tagihans.destroy', $tagihan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tagihan ini? (Ini juga akan menghapus pembayaran terkait jika ada)');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-sm py-1 px-3 rounded-md">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-4 px-4 text-center text-gray-500">Belum ada data tagihan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $tagihans->links() }}
    </div>
</div>
@endsection