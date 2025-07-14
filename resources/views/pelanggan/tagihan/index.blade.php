@extends('layouts.app')

@section('title', 'Tagihan Saya')

@section('content')
<h1 class="text-2xl font-bold mb-4">Daftar Tagihan Saya</h1>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Periode
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Jumlah Meter (kWh)
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Estimasi Total Bayar
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Status Tagihan
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tagihans as $tagihan)
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $tagihan->bulan }} {{ $tagihan->tahun }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $tagihan->jumlah_meter }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        Rp {{ number_format($tagihan->calculated_total_bayar, 2, ',', '.') }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <span class="relative inline-block px-3 py-1 font-semibold leading-tight {{ $tagihan->isSudahDibayar() ? 'text-green-900' : 'text-red-900' }}">
                            <span aria-hidden class="absolute inset-0 opacity-50 rounded-full {{ $tagihan->isSudahDibayar() ? 'bg-green-200' : 'bg-red-200' }}"></span>
                            <span class="relative">{{ $tagihan->status_tagihan }}</span>
                        </span>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        @if (!$tagihan->isSudahDibayar())
                            <a href="{{ route('pelanggan.tagihan.bayar', $tagihan->id) }}" class="text-indigo-600 hover:text-indigo-900">Bayar</a>
                        @else
                            <span class="text-gray-500">Sudah Dibayar</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-5 text-center bg-white text-sm">Tidak ada tagihan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $tagihans->links() }}
</div>
@endsection