@extends('layouts.app')

@section('title', 'Daftar Tarif Listrik Petugas')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Tarif Listrik (Petugas)</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left text-gray-600">ID</th>
                        <th class="py-2 px-4 border-b text-left text-gray-600">Daya (VA)</th>
                        <th class="py-2 px-4 border-b text-left text-gray-600">Tarif per kWh (Rp)</th>
                        <th class="py-2 px-4 border-b text-left text-gray-600">Terakhir Diperbarui</th>
                        <th class="py-2 px-4 border-b text-center text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tarifs as $tarif)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b">{{ $tarif->id }}</td>
                            <td class="py-2 px-4 border-b">{{ number_format($tarif->daya, 0, ',', '.') }}</td>
                            <td class="py-2 px-4 border-b">Rp {{ number_format($tarif->tarif_perkwh, 2, ',', '.') }}</td>
                            <td class="py-2 px-4 border-b">{{ $tarif->updated_at->format('d M Y H:i') }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <span class="text-gray-500 text-sm">Tidak ada aksi</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 px-4 text-center text-gray-500">Belum ada data tarif.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
