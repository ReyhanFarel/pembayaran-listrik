@extends('layouts.app')

@section('title', 'Riwayat Penggunaan Listrik')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Riwayat Penggunaan Listrik Saya</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Bulan/Tahun</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Meter Awal</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Meter Akhir</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Jumlah Meter</th>
                    <th class="py-2 px-4 border-b text-left text-gray-600">Dicatat Pada</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatPenggunaan as $penggunaan)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $penggunaan->bulan }} {{ $penggunaan->tahun }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($penggunaan->meter_awal, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($penggunaan->meter_akhir, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($penggunaan->jumlah_meter, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">{{ $penggunaan->updated_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 px-4 text-center text-gray-500">Belum ada riwayat penggunaan listrik.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $riwayatPenggunaan->links() }}
    </div>
</div>
@endsection