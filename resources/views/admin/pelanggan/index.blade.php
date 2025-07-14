@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('page_title', 'Daftar Pelanggan')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Daftar Pelanggan</h2>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left">ID</th>
                    <th class="py-2 px-4 border-b text-left">Nama Pelanggan</th>
                    <th class="py-2 px-4 border-b text-left">Username</th>
                    <th class="py-2 px-4 border-b text-left">Alamat</th>
                    <th class="py-2 px-4 border-b text-left">Daya</th>
                    <th class="py-2 px-4 border-b text-left">Tarif</th>
                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggan as $p)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $p->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $p->nama_pelanggan }}</td>
                    <td class="py-2 px-4 border-b">{{ $p->username }}</td>
                    <td class="py-2 px-4 border-b">{{ $p->alamat }}</td>
                    <td class="py-2 px-4 border-b">{{ $p->daya }} VA</td>
                    <td class="py-2 px-4 border-b">Rp {{ number_format($p->tarif->tarif_perkwh ?? 0, 0, ',', '.') }}/KWH</td>
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ route('admin.pelanggan.show', $p->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">Detail</a>
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
@endsection