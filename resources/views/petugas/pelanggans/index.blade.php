@extends('layouts.app')

@section('title', 'Daftar Pelanggan Petugas')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Pelanggan (Petugas)</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left text-gray-600">ID</th>
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
                    <td class="py-2 px-4 border-b">{{ $pelanggan->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $pelanggan->nama_pelanggan }}</td>
                    <td class="py-2 px-4 border-b">{{ $pelanggan->username }}</td>
                    <td class="py-2 px-4 border-b">{{ $pelanggan->alamat }}</td>
                    <td class="py-2 px-4 border-b">{{ $pelanggan->nomor_kwh }}</td> {{-- <-- Tampilkan nomor_kwh --}}
                    <td class="py-2 px-4 border-b">
                        @if($pelanggan->tarif)
                            {{ number_format($pelanggan->tarif->daya, 0, ',', '.') }} VA (Rp {{ number_format($pelanggan->tarif->tarif_perkwh, 2, ',', '.') }}/kWh)
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        <span class="text-gray-500 text-sm">Tidak ada aksi</span>
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