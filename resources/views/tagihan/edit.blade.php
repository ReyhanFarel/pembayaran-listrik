@extends('layouts.app')

@section('title', 'Edit Status Tagihan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Status Tagihan</h1>

    <form action="{{ Auth::guard('web')->user()->level_id == 1 ? route('admin.tagihans.update', $tagihan->id) : route('petugas.tagihans.update', $tagihan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Detail Tagihan:</label>
            <div class="bg-gray-100 p-4 rounded-md border border-gray-200">
                <p><strong>Pelanggan:</strong> {{ $tagihan->pelanggan->nama_pelanggan ?? 'N/A' }}</p>
                <p><strong>No. KWH:</strong> {{ $tagihan->pelanggan->nomor_kwh ?? 'N/A' }}</p>
                <p><strong>Periode:</strong> {{ $tagihan->bulan }} {{ $tagihan->tahun }}</p>
                <p><strong>Jumlah Meter:</strong> {{ number_format($tagihan->jumlah_meter, 0, ',', '.') }} KWH</p>
                <p><strong>Daya/Tarif:</strong>
                    @if($tagihan->tarif_data)
                        {{ number_format($tagihan->tarif_data->daya, 0, ',', '.') }} VA (Rp {{ number_format($tagihan->tarif_data->tarif_perkwh, 2, ',', '.') }}/kWh)
                    @else
                        N/A
                    @endif
                </p>
                <p class="mt-2 text-xl font-semibold"><strong>Total Tagihan:</strong> Rp {{ number_format($tagihan->total_tagihan, 2, ',', '.') }}</p>
            </div>
        </div>

        <div class="mb-6">
            <label for="status_tagihan" class="block text-gray-700 text-sm font-bold mb-2">Status Tagihan:</label>
            <select id="status_tagihan" name="status_tagihan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status_tagihan') border-red-500 @enderror" required>
                <option value="Belum Lunas" {{ old('status_tagihan', $tagihan->status_tagihan) == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                <option value="Lunas" {{ old('status_tagihan', $tagihan->status_tagihan) == 'Lunas' ? 'selected' : '' }}>Lunas</option>
            </select>
            @error('status_tagihan')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Status
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