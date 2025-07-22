@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="bg-white p-8 rounded-none border-4 border-neutral-900 neo-brutal-shadow-black">
        <h1 class="text-4xl font-extrabold text-neutral-900 mb-8 uppercase">Selamat Datang, Admin
            {{ Auth::guard('web')->user()->nama_user }}!</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {{-- Card Total Pelanggan --}}
            <div
                class="bg-blue-500 text-white p-6 rounded-none border-4 border-neutral-900 neo-brutal-button-shadow flex flex-col items-start justify-between h-40">
                <div class="flex items-center justify-between w-full mb-4">
                    <div class="text-4xl font-black">{{ number_format($totalPelanggan, 0, ',', '.') }}</div>
                    <svg class="w-14 h-14 opacity-75 text-white flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20v-9H7v9M4 14h16V7H4v7"></path>
                    </svg>
                </div>
                <div class="text-lg font-bold uppercase">Total Pelanggan</div>
            </div>
            {{-- Card Tagihan Belum Lunas --}}
            <div
                class="bg-yellow-500 text-white p-6 rounded-none border-4 border-neutral-900 neo-brutal-button-shadow flex flex-col items-start justify-between h-40">
                <div class="flex items-center justify-between w-full mb-4">
                    <div class="text-4xl font-black">{{ number_format($totalTagihanBelumLunas, 0, ',', '.') }}</div>
                    <svg class="w-14 h-14 opacity-75 text-white flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="text-lg font-bold uppercase">Tagihan Belum Lunas</div>
            </div>
            {{-- Card Total Pembayaran Bulan Ini --}}
            <div
                class="bg-green-500 text-white p-6 rounded-none border-4 border-neutral-900 neo-brutal-button-shadow flex flex-col items-start justify-between h-40">
                <div class="flex items-center justify-between w-full mb-4">
                    <div class="text-4xl font-black">Rp {{ number_format($totalPembayaranBulanIni, 0, ',', '.') }}</div>
                    <svg class="w-14 h-14 opacity-75 text-white flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9v6m-4-4v4m-4-4v4m-4-4v4"></path>
                    </svg>
                </div>
                <div class="text-lg font-bold uppercase">Pembayaran Bulan Ini</div>
            </div>
        </div>

        <div class="mt-12 bg-sky-50 p-2 rounded-none border-4 border-neutral-900 neo-brutal-shadow-black">
            <h2 class="text-3xl font-extrabold text-neutral-900 mb-6 uppercase">5 Pembayaran Terkini</h2>
            @forelse($latestPayments as $payment)
                <div
                    class="flex flex-col md:flex-row items-start md:items-center justify-between py-4 border-b-2 border-sky-400 last:border-b-0">
                    <div class="text-neutral-900 text-lg mb-2 md:mb-0">
                        Pembayaran dari <strong
                            class="font-extrabold text-sky-700">{{ $payment->pelanggan->nama_pelanggan ?? 'N/A' }}</strong>
                        untuk Tagihan bulan <strong
                            class="font-extrabold text-sky-700">{{ $payment->tagihan->bulan ?? 'N/A' }}</strong>
                        {{ $payment->tagihan->tahun ?? '' }}.
                    </div>
                    <div class="text-right md:text-left">
                        <span class="text-sky-700 font-extrabold text-xl">Rp
                            {{ number_format($payment->total_bayar, 2, ',', '.') }}</span>
                        <br>
                        <span class="text-neutral-500 text-sm italic">{{ $payment->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <p class="text-neutral-500 text-lg">Belum ada pembayaran yang tercatat.</p>
            @endforelse
        </div>
    </div>
@endsection
