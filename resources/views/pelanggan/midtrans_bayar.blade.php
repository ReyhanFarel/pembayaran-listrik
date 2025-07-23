@extends('layouts.app')

@section('title', 'Pembayaran Tagihan')

@section('content')
    <style>
        /* Custom Neo-Brutalism Shadows - ensure these are defined if not coming from layouts.app */
        .neo-brutal-shadow-black {
            box-shadow: 8px 8px 0px 0px rgba(0, 0, 0, 1);
            /* Black shadow */
        }

        .neo-brutal-button-shadow {
            box-shadow: 6px 6px 0px 0px rgba(0, 0, 0, 1);
            /* Black shadow for buttons */
        }
    </style>
    <div class="bg-white p-8 rounded-none border-4 border-neutral-900 neo-brutal-shadow-black w-full max-w-xl mx-auto">
        <h1 class="text-4xl font-extrabold text-neutral-900 mb-8 text-center uppercase">Bayar Tagihan No. {{ $tagihan->id }}
        </h1>

        <div class="mb-8 p-6 bg-sky-50 rounded-none border-2 border-neutral-900 neo-brutal-shadow-black">
            <p class="text-neutral-900 text-lg mb-2">Bulan: <span class="font-semibold">{{ $tagihan->bulan }}</span> / <span
                    class="font-semibold">{{ $tagihan->tahun }}</span></p>
            <p class="text-neutral-900 text-lg mb-4">Total Tagihan: <b class="font-extrabold text-sky-700 text-2xl">Rp
                    {{ number_format($tagihan->total_tagihan, 2, ',', '.') }}</b></p>
        </div>

        <div class="flex justify-center">
            <button id="pay-button"
                class="bg-green-600 hover:bg-green-700 text-white font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase">
                Bayar Dengan Midtrans
            </button>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    console.log(result); // log data transaksi
                    window.location.href = "{{ route('pelanggan.tagihan_saya') }}";
                },
                onPending: function(result) {
                    alert("Transaksi pending!"); // Ganti dengan modal kustom jika di lingkungan produksi
                },
                onError: function(result) {
                    alert("Pembayaran gagal!"); // Ganti dengan modal kustom jika di lingkungan produksi
                }
            });
        };
    </script>
@endsection
