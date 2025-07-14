@extends('layouts.app')

@section('title', 'Penggunaan Listrik Saya')

@section('content')
<h1 class="text-2xl font-bold mb-4">Penggunaan Listrik Saya</h1>

<div class="bg-white shadow-md rounded-lg overflow-hidden mt-4">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Periode
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Meter Awal (kWh)
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Meter Akhir (kWh)
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Total Penggunaan (kWh)
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penggunaans as $penggunaan)
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $penggunaan->bulan }} {{ $penggunaan->tahun }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $penggunaan->meter_awal }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $penggunaan->meter_akhir }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $penggunaan->meter_akhir - $penggunaan->meter_awal }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-5 py-5 text-center bg-white text-sm">Tidak ada data penggunaan listrik Anda.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $penggunaans->links() }}
</div>
@endsection