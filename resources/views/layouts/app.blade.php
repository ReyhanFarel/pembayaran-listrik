<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pembayaran Listrik - @yield('title', 'Dashboard')</title>
    {{-- @vite('resources/css/app.css') --}} <!-- Removed as it causes SyntaxError in non-Laravel environments -->
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* Custom Neo-Brutalism Shadows */
        .neo-brutal-shadow-black {
            box-shadow: 8px 8px 0px 0px rgba(0, 0, 0, 1);
            /* Black shadow */
        }

        .neo-brutal-shadow-sky {
            box-shadow: 8px 8px 0px 0px rgba(14, 165, 233, 1);
            /* Sky-500 shadow */
        }

        .neo-brutal-shadow-white {
            box-shadow: 8px 8px 0px 0px rgba(255, 255, 255, 1);
            /* White shadow */
        }

        .neo-brutal-button-shadow {
            box-shadow: 6px 6px 0px 0px rgba(0, 0, 0, 1);
            /* Black shadow for buttons */
        }

        .neo-brutal-logout-shadow {
            box-shadow: 6px 6px 0px 0px rgb(5, 5, 5);
            /* Sky shadow for logout button */
        }

        /* Sidebar transition styles */
        .sidebar {
            width: 250px;
            transition: width 0.3s ease-in-out;
            overflow-x: hidden;
            flex-shrink: 0;
            /* Prevent sidebar from shrinking */
        }

        .sidebar.collapsed {
            width: 64px;
        }

        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s ease-in-out;
            flex-grow: 1;
            /* Allow main content to grow */
        }

        .main-content.expanded {
            margin-left: 64px;
        }

        .sidebar.collapsed .sidebar-text {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }

        .sidebar .sidebar-text {
            opacity: 1;
            transition: opacity 0.2s;
        }

        /* Adjustments for collapsed sidebar menu items */
        .sidebar.collapsed nav ul li a {
            justify-content: center;
            /* Center the icon horizontally */
            padding-left: 0;
            /* Remove left padding to allow centering */
            padding-right: 0;
            /* Remove right padding to allow centering */
        }

        .sidebar.collapsed nav ul li a svg {
            margin-right: 0;
            /* Remove margin from SVG when collapsed */
        }

        /* Specific adjustment for logout button icon when sidebar is collapsed */
        .sidebar.collapsed form button svg {
            margin-right: 0;
            /* Ensure no margin pushes the icon off-center */
        }

        /* Ensure Inter font is used */
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Remove default focus outline for a cleaner look, Tailwind handles focus styles */
        *:focus {
            outline: none;
        }
    </style>
</head>

<body class="bg-sky-100 flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside id="sidebar"
        class="sidebar bg-sky-300 text-neutral-900 p-4 flex flex-col justify-between fixed h-full border-r-4 border-neutral-900 neo-brutal-shadow-black z-20 overflow-hidden">
        <div>
            <h1 class="text-3xl font-black mb-8 text-center sidebar-text uppercase">App Listrik</h1>
            <nav>
                <ul>
                    {{-- Menu untuk Admin --}}
                    @if (Auth::guard('web')->check() && Auth::guard('web')->user()->level_id == 1)
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Home -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9.75L12 4l9 5.75M4.5 10.75V19a2 2 0 002 2h11a2 2 0 002-2v-8.25"></path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">Dashboard
                                    Admin</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Users -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20v-2a4 4 0 00-3-3.87M9 20v-2a4 4 0 013-3.87M7 10a4 4 0 100-8 4 4 0 000 8zm10 0a4 4 0 100-8 4 4 0 000 8z">
                                    </path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">
                                    User</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pelanggans.index') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons User -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A8.001 8.001 0 0112 16a8.001 8.001 0 016.879 1.804M12 12a5 5 0 100-10 5 5 0 000 10zm0 0v1">
                                    </path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">
                                    Pelanggan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tarifs.index') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Currency Dollar -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.104 0-2 .896-2 2s.896 2 2 2m0 0c1.104 0 2-.896 2-2s-.896-2-2-2zm0 0V4m0 12v4">
                                    </path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">
                                    Tarif</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.penggunaans.index') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Chart Bar -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m4-10v10m4-6v6"></path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">
                                    Penggunaan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tagihans.index') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Document Text -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-4a2 2 0 012-2h2a2 2 0 012 2v4M16 17V7a2 2 0 00-2-2H8a2 2 0 00-2 2v10">
                                    </path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">
                                    Tagihan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pembayarans.index') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Credit Card -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <rect x="2" y="7" width="20" height="10" rx="2" stroke-width="2"
                                        stroke="currentColor" fill="none"></rect>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 11h20">
                                    </path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">
                                    Pembayaran</span>
                            </a>
                        </li>
                    @endif

                    {{-- Menu untuk Petugas --}}
                    @if (Auth::guard('web')->check() && Auth::guard('web')->user()->level_id == 2)
                        <li>
                            <a href="{{ route('petugas.dashboard') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Home -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9.75L12 4l9 5.75M4.5 10.75V19a2 2 0 002 2h11a2 2 0 002-2v-8.25"></path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">Dashboard
                                    Petugas</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('petugas.pelanggans.index') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons User -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A8.001 8.001 0 0112 16a8.001 8.001 0 016.879 1.804M12 12a5 5 0 100-10 5 5 0 000 10zm0 0v1">
                                    </path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">Lihat
                                    Pelanggan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('petugas.tarifs.index') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Currency Dollar -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.104 0-2 .896-2 2s.896 2 2 2m0 0c1.104 0 2-.896 2-2s-.896-2-2-2zm0 0V4m0 12v4">
                                    </path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">
                                    Tarif</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('petugas.penggunaans.index') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Chart Bar -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m4-10v10m4-6v6"></path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">
                                    Penggunaan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('petugas.tagihans.index') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Document Text -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-4a2 2 0 012-2h2a2 2 0 012 2v4M16 17V7a2 2 0 00-2-2H8a2 2 0 00-2 2v10">
                                    </path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">
                                    Tagihan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('petugas.pembayarans.index') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Credit Card -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <rect x="2" y="7" width="20" height="10" rx="2" stroke-width="2"
                                        stroke="currentColor" fill="none"></rect>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2 11h20"></path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">
                                    Pembayaran</span>
                            </a>
                        </li>
                    @endif

                    {{-- Menu untuk Pelanggan --}}
                    @if (Auth::guard('pelanggan')->check())
                        <li>
                            <a href="{{ route('pelanggan.dashboard') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Home -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9.75L12 4l9 5.75M4.5 10.75V19a2 2 0 002 2h11a2 2 0 002-2v-8.25"></path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">Dashboard
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pelanggan.riwayat_penggunaan') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Chart Bar -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m4-10v10m4-6v6"></path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">
                                    Penggunaan Saya</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pelanggan.tagihan_saya') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Document Text -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-4a2 2 0 012-2h2a2 2 0 012 2v4M16 17V7a2 2 0 00-2-2H8a2 2 0 00-2 2v10">
                                    </path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">Tagihan
                                    Saya</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pelanggan.profil_saya') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons User Circle -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <circle cx="12" cy="8" r="4" stroke="currentColor"
                                        stroke-width="2" fill="none"></circle>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 20a6 6 0 0112 0"></path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold ">Profil
                                    Saya</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pelanggan.riwayat_pembayaran') }}"
                                class="flex items-center px-4 py-3 rounded-md hover:bg-sky-400 hover:text-white mb-3 border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                                <!-- Heroicons Receipt Refund -->
                                <svg class="w-6 h-6 mr-3 flex-shrink-0 -mt-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="sidebar-text whitespace-nowrap overflow-hidden font-bold">
                                    Pembayaran Saya
                                </span>
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
                    class="w-full flex  px-4 py-3 rounded-md bg-red-600 hover:bg-red-700 text-white font-extrabold border-2 border-red-600 hover:border-red-700 neo-brutal-logout-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span class="sidebar-text whitespace-nowrap overflow-hidden">LOGOUT</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content Area --}}
    <div id="main-content" class="main-content flex-1 flex flex-col min-h-screen relative z-10">
        <header class="bg-sky-300 neo-brutal-shadow-black p-4 flex justify-between items-center z-10">
            <div class="flex items-center">
                <button id="sidebar-toggle"
                    class="text-black focus:text-black mr-4 p-2 border-2 border-black neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h2 class="text-3xl font-extrabold text-black ml-4 uppercase">@yield('title', 'Dashboard')</h2>
            </div>
            <div class="text-gray-800 text-lg font-bold">
                @if (Auth::guard('web')->check())
                    Halo, {{ Auth::guard('web')->user()->nama_user }}
                @elseif(Auth::guard('pelanggan')->check())
                    Halo, {{ Auth::guard('pelanggan')->user()->nama_pelanggan }}
                @endif
            </div>
        </header>

        <main class="flex-1 p-8 overflow-y-auto bg-sky-100">
            @yield('content')
        </main>

        <footer class="bg-sky-300 text-black p-4 text-center border-t-8 border-black neo-brutal-shadow-black">
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

        // Ensure initial state is correct on load
        window.addEventListener('load', () => {
            if (window.innerWidth < 768) { // Example breakpoint for mobile
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        });

        // Optional: Adjust on resize
        window.addEventListener('resize', () => {
            if (window.innerWidth < 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            } else {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
            }
        });
    </script>
</body>

</html>
