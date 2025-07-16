@extends('layouts.app')

@section('title', 'Tagihan Saya')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Tagihan Saya</h1>
        <form method="GET" class="mb-4 flex gap-2 flex-wrap">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Bulan/Tahun"
                class="px-2 py-1 border rounded">
            <select name="sort" class="px-2 py-1 border rounded">
                <option value="tahun" {{ request('sort') == 'tahun' ? 'selected' : '' }}>Tahun</option>
            </select>
            <select name="direction" class="px-2 py-1 border rounded">
                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Terlama</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Cari/Sort</button>
        </form>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left text-gray-600">No. Tagihan</th>
                        <th class="py-2 px-4 border-b text-left text-gray-600">Periode</th>
                        <th class="py-2 px-4 border-b text-left text-gray-600">Jumlah Meter</th>
                        <th class="py-2 px-4 border-b text-left text-gray-600">Total Tagihan</th>
                        <th class="py-2 px-4 border-b text-left text-gray-600">Status</th>
                        <th class="py-2 px-4 border-b text-center text-gray-600">Detail Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihans as $tagihan)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b">{{ $tagihan->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $tagihan->bulan }} {{ $tagihan->tahun }}</td>
                            <td class="py-2 px-4 border-b">{{ number_format($tagihan->jumlah_meter, 0, ',', '.') }}</td>
                            <td class="py-2 px-4 border-b">Rp {{ number_format($tagihan->total_tagihan, 2, ',', '.') }}</td>
                            <td class="py-2 px-4 border-b">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $tagihan->status_tagihan == 'Sudah Dibayar' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $tagihan->status_tagihan }}
                                </span>
                            </td>
                            <td class="py-2 px-4 border-b text-center">
                                @if ($tagihan->status_tagihan == 'Sudah Dibayar' && $tagihan->pembayaran)
                                    <!-- ...tombol detail pembayaran... -->
                                    <button
                                        onclick="showPaymentDetail(
                                '{{ $tagihan->pembayaran->tanggal_pembayaran->format('d M Y') }}',
                                'Rp {{ number_format($tagihan->total_tagihan, 2, ',', '.') }}',
                                'Rp {{ number_format($tagihan->pembayaran->biaya_admin, 2, ',', '.') }}',
                                'Rp {{ number_format($tagihan->pembayaran->total_bayar, 2, ',', '.') }}',
                                '{{ $tagihan->pembayaran->user->nama_user ?? 'Dibayar Oleh Pelanggan ' }}'
                            )"
                                        class="bg-blue-500 hover:bg-blue-700 text-white text-sm py-1 px-3 rounded-md">
                                        Lihat Pembayaran
                                    </button>
                                @else
                                    <!-- Tombol bayar Midtrans -->
                                    <form action="{{ route('pelanggan.bayar_tagihan', $tagihan->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-500 hover:bg-green-700 text-white text-sm py-1 px-3 rounded-md">
                                            Bayar Sekarang
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 px-4 text-center text-gray-500">Belum ada tagihan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $tagihans->links() }}
        </div>
    </div>

    {{-- Modal for Payment Details --}}
    <div id="paymentDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Pembayaran</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 text-left"><strong>Tanggal Bayar:</strong> <span
                            id="modalTanggalBayar"></span></p>
                    <p class="text-sm text-gray-500 text-left"><strong>Total Tagihan:</strong> <span
                            id="modalTotalTagihan"></span></p>
                    <p class="text-sm text-gray-500 text-left"><strong>Biaya Admin:</strong> <span
                            id="modalBiayaAdmin"></span></p>
                    <p class="text-sm text-gray-500 text-left mt-2 font-bold"><strong>Total Dibayar:</strong> <span
                            id="modalTotalDibayar" class="text-blue-700 text-lg"></span></p>
                    <p class="text-sm text-gray-500 text-left mt-2">Dicatat Oleh: <span id="modalDicatatOleh"></span></p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="closeModal"
                        class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
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
