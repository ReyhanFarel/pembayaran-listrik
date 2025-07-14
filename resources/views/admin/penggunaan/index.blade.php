@extends('layouts.app')

@section('title', 'Manajemen Penggunaan Listrik')
@section('page_title', 'Daftar Penggunaan Listrik')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Daftar Penggunaan</h2>
            <a href="{{ route('penggunaan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambah Penggunaan</a>
        </div>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left">ID</th>
                    <th class="py-2 px-4 border-b text-left">Pelanggan</th>
                    <th class="py-2 px-4 border-b text-left">Periode</th>
                    <th class="py-2 px-4 border-b text-left">Meter Awal</th>
                    <th class="py-2 px-4 border-b text-left">Meter Akhir</th>
                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penggunaan as $data)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $data->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $data->pelanggan->nama_pelanggan ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ $data->bulan }} {{ $data->tahun }}</td>
                    <td class="py-2 px-4 border-b">{{ $data->meter_awal }} KWH</td>
                    <td class="py-2 px-4 border-b">{{ $data->meter_akhir }} KWH</td>
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ route('penggunaan.edit', $data->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">Edit</a>
                        <form action="{{ route('penggunaan.destroy', $data->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus penggunaan ini? (Ini juga akan menghapus tagihan terkait)');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-4 px-4 text-center text-gray-500">Belum ada data penggunaan listrik.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection