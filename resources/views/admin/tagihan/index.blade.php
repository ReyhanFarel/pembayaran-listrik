@extends('layouts.app')

@section('title', 'Daftar Tagihan Pelanggan')
@section('page_title', 'Semua Tagihan')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Daftar Semua Tagihan</h2>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left">ID Tagihan</th>
                    <th class="py-2 px-4 border-b text-left">Pelanggan</th>
                    <th class="py-2 px-4 border-b text-left">Periode</th>
                    <th class="py-2 px-4 border-b text-left">Penggunaan (KWH)</th>
                    <th class="py-2 px-4 border-b text-left">Total Bayar (Estimasi)</th>
                    <th class="py-2 px-4 border-b text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tagihan as $bill)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $bill->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $bill->pelanggan->nama_pelanggan ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ $bill->bulan }} {{ $bill->tahun }}</td>
                    <td class="py-2 px-4 border-b">{{ $bill->jumlah_meter }} KWH</td>
                    <td class="py-2 px-4 border-b">
                        @php
                            $tarif_perkwh = $bill->pelanggan->tarif->tarif_perkwh ?? 0;
                            $total_tagihan = $bill->jumlah_meter * $tarif_perkwh;
                            $biaya_admin = 2500; // Asumsi biaya admin
                            $total_bayar_estimasi = $total_tagihan + $biaya_admin;
                        @endphp
                        Rp {{ number_format($total_bayar_estimasi, 0, ',', '.') }}
                    </td>
                    <td class="py-2 px-4 border-b">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $bill->status_tagihan == 'Lunas' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                            {{ $bill->status_tagihan }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-4 px-4 text-center text-gray-500">Belum ada data tagihan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection