@extends('layouts.app')

@section('title', 'Edit Pembayaran')

@section('content')
    <style>
        /* Custom Neo-Brutalism Shadows - ensure these are defined if not coming from layouts.app */
        .neo-brutal-shadow-black {
            box-shadow: 8px 8px 0px 0px rgba(0, 0, 0, 1);
            /* Black shadow */
        }

        .neo-brutal-input-shadow {
            box-shadow: 4px 4px 0px 0px rgba(0, 0, 0, 1);
            /* Black shadow for inputs */
        }

        .neo-brutal-button-shadow {
            box-shadow: 6px 6px 0px 0px rgba(0, 0, 0, 1);
            /* Black shadow for buttons */
        }
    </style>
    <div class="bg-white p-8 rounded-none border-4 border-neutral-900 neo-brutal-shadow-black w-full max-w-lg mx-auto">
        <h1 class="text-4xl font-extrabold text-center text-neutral-900 mb-8 uppercase">Edit Pembayaran</h1>

        @if (session('error'))
            <div class="bg-red-600 text-white px-4 py-3 rounded-none border-2 border-neutral-900 neo-brutal-shadow-black relative mb-6"
                role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-600 text-white px-4 py-3 rounded-none border-2 border-neutral-900 neo-brutal-shadow-black relative mb-6"
                role="alert">
                <strong class="font-extrabold block mb-2">OOPS!</strong>
                <span class="block sm:inline">Ada beberapa masalah dengan input Anda:</span>
                <ul class="mt-3 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ Auth::guard('web')->user()->level_id == 1 ? route('admin.pembayarans.update', $pembayaran->id) : route('petugas.pembayarans.update', $pembayaran->id) }}"
            method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-neutral-900 text-base font-bold mb-3 uppercase">Detail Tagihan:</label>
                <div class="bg-neutral-100 p-6 rounded-none border-2 border-neutral-900 neo-brutal-shadow-black">
                    <p class="text-neutral-900 mb-2"><strong>Pelanggan:</strong> <span
                            class="font-semibold">{{ $pembayaran->pelanggan->nama_pelanggan ?? 'N/A' }}</span></p>
                    <p class="text-neutral-900 mb-2"><strong>No. KWH:</strong> <span
                            class="font-semibold">{{ $pembayaran->pelanggan->nomor_kwh ?? 'N/A' }}</span></p>
                    <p class="text-neutral-900 mb-2"><strong>No. Tagihan:</strong> <span
                            class="font-semibold">{{ $pembayaran->tagihan->id ?? 'N/A' }}</span></p>
                    <p class="text-neutral-900 mb-2"><strong>Periode:</strong> <span
                            class="font-semibold">{{ ($pembayaran->tagihan->bulan ?? 'N/A') . ' ' . ($pembayaran->tagihan->tahun ?? '') }}</span>
                    </p>
                    <p class="mt-4 text-xl font-extrabold text-sky-700"><strong>Total Tagihan Awal:</strong> Rp
                        {{ number_format($pembayaran->tagihan->total_tagihan ?? 0, 2, ',', '.') }}</p>
                </div>
            </div>

            <div class="mb-6">
                <label for="tanggal_pembayaran" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Tanggal
                    Pembayaran:</label>
                <input type="date" id="tanggal_pembayaran" name="tanggal_pembayaran"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('tanggal_pembayaran') border-red-500 @enderror"
                    value="{{ old('tanggal_pembayaran', $pembayaran->tanggal_pembayaran->format('Y-m-d')) }}" required>
                @error('tanggal_pembayaran')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label for="biaya_admin" class="block text-neutral-900 text-base font-bold mb-3 uppercase">Biaya Admin
                    (Opsional):</label>
                <input type="number" step="0.01" id="biaya_admin" name="biaya_admin"
                    class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow w-full py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white @error('biaya_admin') border-red-500 @enderror"
                    value="{{ old('biaya_admin', $pembayaran->biaya_admin) }}" min="0"
                    oninput="updateTotalBayarDisplay()">
                @error('biaya_admin')
                    <p class="text-red-600 text-sm italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 bg-neutral-100 p-6 rounded-none border-2 border-neutral-900 neo-brutal-shadow-black">
                <p class="text-neutral-900 text-base font-bold mb-3 uppercase">Total yang Harus Dibayar (Termasuk Admin):
                </p>
                <p id="display_total_bayar" class="text-3xl font-extrabold text-green-600">Rp 0,00</p>
            </div>

            <div class="flex items-center justify-between flex-wrap gap-4">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase flex-grow sm:flex-grow-0">
                    Update Pembayaran
                </button>
                @if (Auth::guard('web')->user()->level_id == 1)
                    <a href="{{ route('admin.pembayarans.index') }}"
                        class="inline-block align-baseline font-extrabold text-lg text-neutral-600 hover:text-neutral-900 underline uppercase transition duration-200 ease-in-out">Batal</a>
                @elseif(Auth::guard('web')->user()->level_id == 2)
                    <a href="{{ route('petugas.pembayarans.index') }}"
                        class="inline-block align-baseline font-extrabold text-lg text-neutral-600 hover:text-neutral-900 underline uppercase transition duration-200 ease-in-out">Batal</a>
                @endif
            </div>
        </form>
    </div>

    <script>
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(amount);
        }

        function updateTotalBayarDisplay() {
            // Pastikan nilai total_tagihan diambil dari data PHP dan bukan dari elemen HTML yang bisa berubah
            const totalTagihan = parseFloat({{ $pembayaran->tagihan->total_tagihan ?? 0 }});
            const biayaAdmin = parseFloat(document.getElementById('biaya_admin').value || 0);

            const totalBayar = totalTagihan + biayaAdmin;
            document.getElementById('display_total_bayar').textContent = formatRupiah(totalBayar);
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateTotalBayarDisplay();
        });
    </script>
@endsection
