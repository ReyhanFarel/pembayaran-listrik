@extends('layouts.app')
@section('title', 'Pembayaran Tagihan')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-2">Bayar Tagihan No. {{ $tagihan->id }}</h2>
        <p>Bulan: {{ $tagihan->bulan }} / {{ $tagihan->tahun }}</p>
        <p>Total Tagihan: <b>Rp {{ number_format($tagihan->total_tagihan, 2, ',', '.') }}</b></p>
        <button id="pay-button" class="bg-green-500 px-4 py-2 text-white rounded mt-4">Bayar Dengan Midtrans</button>
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
                    alert("Transaksi pending!");
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                }
            });
        };
    </script>
@endsection
