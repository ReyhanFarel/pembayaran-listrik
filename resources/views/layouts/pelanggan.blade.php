<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pelanggan Dashboard')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <header class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Aplikasi Pembayaran Listrik</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="{{ route('pelanggan.dashboard') }}" class="hover:text-blue-200">Dashboard</a></li>
                    <li><a href="{{ route('pelanggan.my_bills') }}" class="hover:text-blue-200">Tagihan Saya</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">Logout</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="flex-1 p-8 container mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">@yield('page_title', 'Halaman Pelanggan')</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <main>
            @yield('content')
        </main>
    </div>

    <footer class="bg-gray-800 text-white p-4 text-center mt-auto">
        &copy; {{ date('Y') }} Pembayaran Listrik. All rights reserved.
    </footer>
</body>
</html>