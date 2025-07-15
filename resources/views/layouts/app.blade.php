<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pembayaran Listrik - @yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css')
    <style>
        /* Optional: Some basic styling for sidebar fixed position */
        .sidebar {
            width: 250px;
            /* Tambahkan efek transisi untuk animasi sidebar */
            transition: width 0.3s ease-in-out;
        }

        .sidebar.collapsed {
            width: 64px;
            /* Tailwind's w-16 */
        }

        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s ease-in-out;
        }

        .main-content.expanded {
            margin-left: 64px;
        }
    </style>
</head>

<body class="bg-gray-100 flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside id="sidebar"
        class="sidebar bg-gray-800 text-white p-4 flex flex-col justify-between fixed h-full shadow-lg z-20">
        <div>
            <h1 class="text-2xl font-bold mb-6 text-center">App Listrik</h1>
            <nav>
                <ul>
                    {{-- Menu untuk Admin --}}
                    @if (Auth::guard('web')->check() && Auth::guard('web')->user()->level_id == 1)
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m0 0l7 7m-1.5-7.5V14m0 0v-4.5m0 0V8m0 0V6.5m0 0H8">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Dashboard Admin</span>
                            </a>
                        </li>
                        <li>
                            <a href={{ route('admin.users.index') }}
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292V15m0 0v2m0 0v2m0 0h2m-2 0H8"></path>
                                </svg>
                                <span class="whitespace-nowrap">Manajemen User</span>
                            </a>
                        </li>
                        <li>
                            <a href={{ route('admin.pelanggans.index') }}
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20v-9H7v9M4 14h16V7H4v7"></path>
                                </svg>
                                <span class="whitespace-nowrap">Manajemen Pelanggan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tarifs.index') }}"
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4h-.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2zM6 10h12">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Manajemen Tarif</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.penggunaans.index') }}"
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Manajemen Penggunaan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tagihans.index') }}"
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Manajemen Tagihan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pembayarans.index') }}"
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2m-6-6L21 3m0 0l-5.5 5.5M21 3H15m6 0v6">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Manajemen Pembayaran</span>
                            </a>
                        </li>
                    @endif

                    {{-- Menu untuk Petugas --}}
                    @if (Auth::guard('web')->check() && Auth::guard('web')->user()->level_id == 2)
                        <li>
                            <a href="{{ route('petugas.dashboard') }}"
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m0 0l7 7m-1.5-7.5V14m0 0v-4.5m0 0V8m0 0V6.5m0 0H8">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Dashboard Petugas</span>
                            </a>
                        </li>
                        <li>
                            <a href={{ route('petugas.pelanggans.index') }}
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20v-9H7v9M4 14h16V7H4v7"></path>
                                </svg>
                                <span class="whitespace-nowrap">Lihat Pelanggan</span> {{-- Petugas hanya Read-Only --}}
                            </a>
                        </li>
                        <li>
                            <a href={{ route('petugas.tarifs.index') }}
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4h-.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2zM6 10h12">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Manajemen Tarif</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('petugas.penggunaans.index') }}"
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Manajemen Penggunaan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('petugas.tagihans.index') }}"
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Manajemen Tagihan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('petugas.pembayarans.index') }}"
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2m-6-6L21 3m0 0l-5.5 5.5M21 3H15m6 0v6">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Manajemen Pembayaran</span>
                            </a>
                        </li>
                    @endif

                    {{-- Menu untuk Pelanggan --}}
                    @if (Auth::guard('pelanggan')->check())
                        <li>
                            <a href="{{ route('pelanggan.dashboard') }}"
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m0 0l7 7m-1.5-7.5V14m0 0v-4.5m0 0V8m0 0V6.5m0 0H8">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Dashboard Pelanggan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pelanggan.riwayat_penggunaan') }}"
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Riwayat Penggunaan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pelanggan.tagihan_saya') }}"
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h10a2 2 0 002-2V8m-5 8l-5-5m0 0l5-5m-5 5h17">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Tagihan Saya</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pelanggan.profil_saya') }}"
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="whitespace-nowrap">Profil Saya</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pelanggan.riwayat_pembayaran') }}"
                                class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span class="whitespace-nowrap">Riwayat Pembayaran Saya</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>

        {{-- Logout button at the bottom of sidebar --}}
        <div class="mb-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content Area --}}
    <div id="main-content" class="main-content flex-1 flex flex-col min-h-screen relative z-10">
        {{-- Navbar Header (Optional: Can be integrated if you want a fixed top bar) --}}
        <header class="bg-white shadow p-4 flex justify-between items-center z-10">
            <div class="flex items-center">
                <button id="sidebar-toggle" class="text-gray-600 focus:outline-none focus:text-gray-900 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h2 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
            </div>
            <div class="text-gray-700">
                @if (Auth::guard('web')->check())
                    Halo, {{ Auth::guard('web')->user()->nama_user }}
                @elseif(Auth::guard('pelanggan')->check())
                    Halo, {{ Auth::guard('pelanggan')->user()->nama_pelanggan }}
                @endif
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="bg-gray-800 text-white p-4 text-center">
            &copy; {{ date('Y') }} Aplikasi Pembayaran Listrik. All rights reserved.
        </footer>
    </div>

    <script>
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    </script>
</body>

</html>
