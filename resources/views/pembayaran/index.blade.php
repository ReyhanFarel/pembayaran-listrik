@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Pembayaran</h1>

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
            <a href="{{ route('admin.pembayarans.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Catat Pembayaran Baru
            </a>
        @elseif(Auth::guard('web')->user()->level_id == 2)
            <a href="{{ route('petugas.pembayarans.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Catat Pembayaran Baru
            </a>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                   
                    <th class="py-2 px-4 border-b text-left text-gray-600">Pelanggan</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">No. Tagihan</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Periode Tagihan</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Total Tagihan</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Biaya Admin</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Total Bayar</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Tgl. Bayar</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Dicatat Oleh</th>
                    <th class="py-2 px-4 border-b text-center text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayarans as $pembayaran)
                <tr class="hover:bg-gray-50">
                
                    <td class="py-2 px-4 border-b">{{ $pembayaran->pelanggan->nama_pelanggan ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ $pembayaran->tagihan->id ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ ($pembayaran->tagihan->bulan ?? 'N/A') . ' ' . ($pembayaran->tagihan->tahun ?? '') }}</td>
                    <td class="py-2 px-4 border-b">Rp {{ number_format($pembayaran->tagihan->total_tagihan ?? 0, 2, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">Rp {{ number_format($pembayaran->biaya_admin, 2, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">Rp {{ number_format($pembayaran->total_bayar, 2, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">{{ $pembayaran->tanggal_pembayaran->format('d M Y') }}</td>
                    <td class="py-2 px-4 border-b">{{ $pembayaran->user->nama_user ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        @if(Auth::guard('web')->user()->level_id == 1)
                            <a href="{{ route('admin.pembayarans.edit', $pembayaran->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white text-sm py-1 px-3 rounded-md mr-2">Edit</a>
                            <form action="{{ route('admin.pembayarans.destroy', $pembayaran->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini? Status tagihan akan dikembalikan menjadi Belum Lunas.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-sm py-1 px-3 rounded-md">Hapus</button>
                            </form>
                        @elseif(Auth::guard('web')->user()->level_id == 2)
                            <a href="{{ route('petugas.pembayarans.edit', $pembayaran->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white text-sm py-1 px-3 rounded-md mr-2">Edit</a>
                            <form action="{{ route('petugas.pembayarans.destroy', $pembayaran->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini? Status tagihan akan dikembalikan menjadi Belum Lunas.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-sm py-1 px-3 rounded-md">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="py-4 px-4 text-center text-gray-500">Belum ada data pembayaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $pembayarans->links() }}
    </div>
</div>
@endsection