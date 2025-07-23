@extends('layouts.app')

@section('title', 'Tagihan Saya')

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

        /* Modal specific styles */
        #paymentDetailModal .modal-content {
            box-shadow: 8px 8px 0px 0px rgba(0, 0, 0, 1);
            /* Black shadow for modal */
        }
    </style>
    <div class="bg-white p-8 rounded-none border-4 border-neutral-900 neo-brutal-shadow-black">
        <h1 class="text-4xl font-extrabold text-neutral-900 mb-8 uppercase">Daftar Tagihan Saya</h1>

        <form method="GET" class="mb-6 flex gap-4 flex-wrap items-center">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Bulan/Tahun"
                class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white flex-grow sm:flex-grow-0">
            <select name="sort"
                class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white">
                <option value="tahun" {{ request('sort') == 'tahun' ? 'selected' : '' }}>Tahun</option>
            </select>
            <select name="direction"
                class="appearance-none border-2 border-neutral-900 neo-brutal-input-shadow py-3 px-4 text-neutral-900 leading-tight focus:border-sky-500 bg-white">
                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Terlama</option>
            </select>
            <button type="submit"
                class="bg-sky-500 hover:bg-sky-600 text-neutral-900 font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase flex-grow sm:flex-grow-0">
                Cari/Sort
            </button>
        </form>

        <div class="overflow-x-auto border-4 border-neutral-900 neo-brutal-shadow-black">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            No. Tagihan</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Periode</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Jumlah Meter</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Total Tagihan</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Status</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-center text-black font-extrabold uppercase">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihans as $tagihan)
                        <tr class="border-b-2 border-neutral-200 hover:bg-sky-50 transition duration-150 ease-in-out">
                            <td class="py-3 px-4 text-neutral-900">{{ $tagihan->id }}</td>
                            <td class="py-3 px-4 text-neutral-900">{{ $tagihan->bulan }} {{ $tagihan->tahun }}</td>
                            <td class="py-3 px-4 text-neutral-900">{{ number_format($tagihan->jumlah_meter, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-neutral-900">Rp
                                {{ number_format($tagihan->total_tagihan, 2, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                <span
                                    class="px-3 py-1 inline-flex text-sm leading-5 font-bold rounded-none border-2
                                {{ $tagihan->status_tagihan == 'Sudah Dibayar' ? 'bg-green-600 text-white border-green-700' : 'bg-red-600 text-white border-red-700' }}">
                                    {{ $tagihan->status_tagihan }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if ($tagihan->status_tagihan == 'Sudah Dibayar' && $tagihan->pembayaran)
                                    <button
                                        onclick="showPaymentDetail(
                                        '{{ $tagihan->pembayaran->tanggal_pembayaran->format('d M Y') }}',
                                        'Rp {{ number_format($tagihan->total_tagihan, 2, ',', '.') }}',
                                        'Rp {{ number_format($tagihan->pembayaran->biaya_admin, 2, ',', '.') }}',
                                        'Rp {{ number_format($tagihan->pembayaran->total_bayar, 2, ',', '.') }}',
                                        '{{ $tagihan->pembayaran->user->nama_user ?? 'Dibayar Oleh Pelanggan ' }}'
                                    )"
                                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                        Lihat Pembayaran
                                    </button>
                                @else
                                    <form action="{{ route('pelanggan.bayar_tagihan', $tagihan->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white text-sm font-bold py-2 px-4 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                            Bayar Sekarang
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 px-4 text-center text-neutral-500 text-lg italic">Belum ada
                                tagihan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-8">
            {{ $tagihans->links() }}
        </div>
    </div>

    {{-- Modal for Payment Details --}}
    <div id="paymentDetailModal"
        class="fixed inset-0 bg-neutral-900 bg-opacity-70 overflow-y-auto h-full w-full hidden flex items-center justify-center p-4 z-50">
        <div class="relative bg-white p-8 border-4 border-neutral-900 rounded-none modal-content w-full max-w-sm mx-auto">
            <div class="mt-3 text-center">
                <h3 class="text-2xl font-extrabold leading-6 text-neutral-900 uppercase mb-4">Detail Pembayaran</h3>
                <div class="mt-2 px-0 py-3 text-left">
                    <p class="text-base text-neutral-900 mb-2"><strong>Tanggal Bayar:</strong> <span id="modalTanggalBayar"
                            class="font-semibold"></span></p>
                    <p class="text-base text-neutral-900 mb-2"><strong>Total Tagihan:</strong> <span id="modalTotalTagihan"
                            class="font-semibold"></span></p>
                    <p class="text-base text-neutral-900 mb-2"><strong>Biaya Admin:</strong> <span id="modalBiayaAdmin"
                            class="font-semibold"></span></p>
                    <p class="text-base text-neutral-900 mt-4 font-extrabold"><strong>Total Dibayar:</strong> <span
                            id="modalTotalDibayar" class="text-sky-700 text-xl"></span></p>
                    <p class="text-base text-neutral-900 mt-4">Dicatat Oleh: <span id="modalDicatatOleh"
                            class="font-semibold"></span></p>
                </div>
                <div class="items-center px-0 py-3 mt-6">
                    <button id="closeModal"
                        class="bg-sky-500 hover:bg-sky-600 text-neutral-900 font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow w-full transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
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

        const paymentDetailModal = document.getElementById('paymentDetailModal');
        const closeModalButton = document.getElementById('closeModal');

        function showPaymentDetail(tanggalBayar, totalTagihan, biayaAdmin, totalDibayar, dicatatOleh) {
            document.getElementById('modalTanggalBayar').textContent = tanggalBayar;
            document.getElementById('modalTotalTagihan').textContent = totalTagihan;
            document.getElementById('modalBiayaAdmin').textContent = biayaAdmin;
            document.getElementById('modalTotalDibayar').textContent = totalDibayar;
            document.getElementById('modalDicatatOleh').textContent = dicatatOleh;
            paymentDetailModal.classList.remove('hidden');
        }

        closeModalButton.onclick = function() {
            paymentDetailModal.classList.add('hidden');
        }

        window.onclick = function(event) {
            if (event.target == paymentDetailModal) {
                paymentDetailModal.classList.add('hidden');
            }
        }
    </script>
@endsection
