@extends('layouts.app')

@section('title', 'Buat Tagihan Baru')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md w-full max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Buat Tagihan dari Penggunaan</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
            <ul class="mt-3 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p class="mb-4 text-gray-700">Pilih data penggunaan listrik yang ingin Anda buat tagihannya. Hanya data penggunaan yang belum memiliki tagihan yang akan ditampilkan.</p>

    <form action="{{ Auth::guard('web')->user()->level_id == 1 ? route('admin.tagihans.generate') : route('petugas.tagihans.generate') }}" method="POST">
        @csrf
        <div class="overflow-x-auto mb-6">
            @forelse($penggunaansBelumDitagih as $penggunaan)
                <div class="flex items-center bg-gray-50 p-3 rounded-lg shadow-sm mb-3">
                    <input type="checkbox" name="penggunaan_ids[]" value="{{ $penggunaan->id }}" id="penggunaan-{{ $penggunaan->id }}" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                    <label for="penggunaan-{{ $penggunaan->id }}" class="ml-3 text-gray-800 flex-1">
                        <span class="font-semibold">{{ $penggunaan->pelanggan->nama_pelanggan ?? 'N/A' }}</span>
                        (No. KWH: {{ $penggunaan->pelanggan->nomor_kwh ?? 'N/A' }}) -
                        Penggunaan Bulan {{ $penggunaan->bulan }} {{ $penggunaan->tahun }} ({{ $penggunaan->meter_awal }} - {{ $penggunaan->meter_akhir }})
                    </label>
                </div>
            @empty
                <p class="text-center text-gray-500 py-4">Tidak ada data penggunaan yang belum ditagih.</p>
            @endforelse
        </div>

        <div class="flex justify-between items-center">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    @if($penggunaansBelumDitagih->isEmpty()) disabled @endif>
                Generate Tagihan
            </button>
            @if(Auth::guard('web')->user()->level_id == 1)
                <a href="{{ route('admin.tagihans.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">Batal</a>
            @elseif(Auth::guard('web')->user()->level_id == 2)
                <a href="{{ route('petugas.tagihans.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">Batal</a>
            @endif
        </div>
    </form>
</div>
@endsection