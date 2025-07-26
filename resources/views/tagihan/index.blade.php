@extends('layouts.app')

@section('title', 'Daftar Tagihan Listrik')

@section('content')
    <style>
        /* Modern, user-friendly styles */
        .card-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .table-modern {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .btn-modern {
            border-radius: 25px;
            padding: 12px 24px;
            font-weight: 600;
            text-transform: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .status-badge {
            border-radius: 20px;
            padding: 6px 16px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-paid {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
        }

        .status-unpaid {
            background: linear-gradient(135deg, #FF6B6B, #EE5A52);
            color: white;
        }

        .alert-modern {
            border-radius: 15px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 20px;
        }

        .search-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .table-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .icon-container {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .bill-icon {
            background: linear-gradient(135deg, #FFD700, #FFA500);
        }

        .amount-highlight {
            font-size: 16px;
            font-weight: 700;
            color: #2563eb;
        }

        .customer-info {
            display: flex;
            align-items: center;
        }

        .hover-row:hover {
            background: rgba(102, 126, 234, 0.05);
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="card-modern text-white p-8 mb-8">
                <div class="flex items-center mb-4">
                    <div class="icon-container bill-icon">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                            <path fill-rule="evenodd"
                                d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">Daftar Tagihan Listrik</h1>
                        <p class="text-blue-100 mt-2">Kelola dan pantau tagihan listrik Anda dengan mudah</p>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="alert-modern bg-green-100 border-l-4 border-green-500 text-green-700">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-modern bg-red-100 border-l-4 border-red-500 text-red-700">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Action Bar -->
            <div class="search-container mb-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" placeholder="Cari berdasarkan nama pelanggan atau nomor KWH..."
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-full focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white shadow-sm">
                        </div>
                    </div>
                    <div class="flex gap-3">
                        @if (Auth::guard('web')->user()->level_id == 1)
                            <a href="{{ route('admin.tagihans.create_from_penggunaan') }}"
                                class="btn-modern bg-gradient-to-r from-blue-500 to-purple-600 text-white hover:from-blue-600 hover:to-purple-700">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Buat Tagihan Baru
                            </a>
                        @elseif(Auth::guard('web')->user()->level_id == 2)
                            <a href="{{ route('petugas.tagihans.create_from_penggunaan') }}"
                                class="btn-modern bg-gradient-to-r from-blue-500 to-purple-600 text-white hover:from-blue-600 hover:to-purple-700">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Buat Tagihan Baru
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white table-modern">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="table-header">
                            <tr>
                                <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">ID</th>
                                <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Pelanggan
                                </th>
                                <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">No. KWH</th>
                                <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Periode</th>
                                <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Pemakaian
                                </th>
                                <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Total Tagihan
                                </th>
                                <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Status</th>
                                <th class="py-4 px-6 text-center text-sm font-semibold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($tagihans as $tagihan)
                                <tr class="hover-row">
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900">
                                        #{{ str_pad($tagihan->id, 4, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="customer-info">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-white font-bold text-sm">
                                                    {{ strtoupper(substr($tagihan->pelanggan->nama_pelanggan ?? 'N', 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $tagihan->pelanggan->nama_pelanggan ?? 'N/A' }}
                                                </div>
                                                <div class="text-xs text-gray-500">Pelanggan</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="text-sm font-mono bg-gray-100 px-3 py-1 rounded-full">
                                            {{ $tagihan->pelanggan->nomor_kwh ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-900">
                                        <div class="font-medium">{{ $tagihan->bulan }} {{ $tagihan->tahun }}</div>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-yellow-500 mr-2" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                            {{ number_format($tagihan->jumlah_meter, 0, ',', '.') }} kWh
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="amount-highlight">
                                            Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span
                                            class="status-badge {{ $tagihan->status_tagihan == 'Sudah Dibayar' ? 'status-paid' : 'status-unpaid' }}">
                                            {{ $tagihan->status_tagihan == 'Sudah Dibayar' ? 'Lunas' : 'Belum Lunas' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex justify-center space-x-2">
                                            @if (Auth::guard('web')->user()->level_id == 1)
                                                <a href="{{ route('admin.tagihans.edit', $tagihan->id) }}"
                                                    class="btn-modern bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs px-3 py-2">
                                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.tagihans.destroy', $tagihan->id) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus tagihan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn-modern bg-gradient-to-r from-red-500 to-red-600 text-white text-xs px-3 py-2">
                                                        <svg class="w-4 h-4 inline mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            @elseif(Auth::guard('web')->user()->level_id == 2)
                                                <a href="{{ route('petugas.tagihans.edit', $tagihan->id) }}"
                                                    class="btn-modern bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs px-3 py-2">
                                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('petugas.tagihans.destroy', $tagihan->id) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus tagihan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn-modern bg-gradient-to-r from-red-500 to-red-600 text-white text-xs px-3 py-2">
                                                        <svg class="w-4 h-4 inline mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-12 px-6 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada tagihan</h3>
                                            <p class="text-gray-500">Tagihan akan muncul di sini setelah dibuat dari data
                                                penggunaan listrik.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if ($tagihans->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="bg-white rounded-full shadow-lg p-2">
                        {{ $tagihans->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
