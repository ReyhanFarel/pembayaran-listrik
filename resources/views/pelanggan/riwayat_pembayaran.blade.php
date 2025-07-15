@extends('layouts.app')

@section('title', 'Riwayat Pembayaran Saya')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Riwayat Pembayaran Saya</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left text-gray-600">ID Pembayaran</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">No. Tagihan</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Periode Tagihan</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Total Tagihan</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Biaya Admin</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Total Dibayar</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Tanggal Pembayaran</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Dicatat Oleh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatPembayaran as $pembayaran)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $pembayaran->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $pembayaran->tagihan->id ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ ($pembayaran->tagihan->bulan ?? 'N/A') . ' ' . ($pembayaran->tagihan->tahun ?? '') }}</td>
                    <td class="py-2 px-4 border-b">Rp {{ number_format($pembayaran->tagihan->total_tagihan ?? 0, 2, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">Rp {{ number_format($pembayaran->biaya_admin, 2, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">Rp {{ number_format($pembayaran->total_bayar, 2, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">{{ $pembayaran->tanggal_pembayaran->format('d M Y') }}</td>
                    <td class="py-2 px-4 border-b">{{ $pembayaran->user->nama_user ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-4 px-4 text-center text-gray-500">Belum ada riwayat pembayaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $riwayatPembayaran->links() }}
    </div>
</div>
@endsection