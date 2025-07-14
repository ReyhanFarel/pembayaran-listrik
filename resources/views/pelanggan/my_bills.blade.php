@extends('layouts.pelanggan')

@section('title', 'Tagihan Saya')
@section('page_title', 'Daftar Tagihan Anda')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Tagihan Listrik Anda</h2>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left">ID Tagihan</th>
                    <th class="py-2 px-4 border-b text-left">Periode</th>
                    <th class="py-2 px-4 border-b text-left">Penggunaan (KWH)</th>
                    <th class="py-2 px-4 border-b text-left">Tarif/KWH</th>
                    <th class="py-2 px-4 border-b text-left">Biaya Admin</th>
                    <th class="py-2 px-4 border-b text-left">Total Bayar</th>
                    <th class="py-2 px-4 border-b text-left">Status</th>
                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tagihan as $bill)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $bill->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $bill->bulan }} {{ $bill->tahun }}</td>
                    <td class="py-2 px-4 border-b">{{ $bill->jumlah_meter }} KWH</td>
                    <td class="py-2 px-4 border-b">Rp {{ number_format($bill->pelanggan->tarif->tarif_perkwh ?? 0, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">Rp 2.500</td> {{-- Contoh biaya admin --}}
                    <td class="py-2 px-4 border-b">
                        @php
                            $tarif_perkwh = $bill->pelanggan->tarif->tarif_perkwh ?? 0;
                            $total_tagihan = $bill->jumlah_meter * $tarif_perkwh;
                            $biaya_admin = 2500; // Asumsi biaya admin
                            $total_bayar = $total_tagihan + $biaya_admin;
                        @endphp
                        Rp {{ number_format($total_bayar, 0, ',', '.') }}
                    </td>
                    <td class="py-2 px-4 border-b">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $bill->status_tagihan == 'Lunas' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                            {{ $bill->status_tagihan }}
                        </span>
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        @if($bill->status_tagihan == 'Belum Lunas')
                            <a href="{{ route('pelanggan.payment_form', $bill->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">Bayar Sekarang</a>
                        @else
                            <span class="text-gray-500 text-sm">Sudah Lunas</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-4 px-4 text-center text-gray-500">Belum ada tagihan untuk Anda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection