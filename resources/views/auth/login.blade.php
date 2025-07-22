<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Aplikasi Pembayaran Listrik</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-sky-100 flex items-center justify-center min-h-screen">
    <div
        class="group bg-white border-2 border-black rounded-xl shadow-[8px_8px_0_0_#0ea5e9] max-w-sm w-full p-8 relative transition-all duration-200
        hover:shadow-[12px_12px_0_0_#0ea5e9] hover:border-sky-400">
        <span class="absolute top-4 left-4 w-6 h-6 bg-sky-300 border-2 border-black rounded-lg"></span>
        <span class="absolute bottom-4 right-4 w-4 h-4 bg-yellow-300 border-2 border-black rounded"></span>
        <h2 class="text-2xl font-bold text-center mb-6 text-black tracking-wide" style="text-shadow: 2px 2px #0ea5e9;">
            Login Aplikasi
        </h2>

        @if ($errors->has('username') && !$errors->has('username.required'))
            <div class="bg-red-100 border-2 border-black text-red-700 px-4 py-2 rounded mb-4 font-semibold shadow-[2px_2px_0_0_black]"
                role="alert">
                <span>{{ $errors->first('username') }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="username" class="block text-sm font-semibold text-black mb-1">Username</label>
                <input type="text" id="username" name="username"
                    class="bg-sky-50 border-2 border-black rounded-lg w-full py-2 px-3 text-black font-semibold shadow-[2px_2px_0_0_#0ea5e9] focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all duration-150
                        hover:border-sky-400 hover:shadow-[4px_4px_0_0_#0ea5e9] @error('username') border-red-500 @enderror"
                    value="{{ old('username') }}" required autofocus>
                @error('username')
                    <p class="text-red-700 text-xs mt-2 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-sm font-semibold text-black mb-1">Password</label>
                <input type="password" id="password" name="password"
                    class="bg-sky-50 border-2 border-black rounded-lg w-full py-2 px-3 text-black font-semibold shadow-[2px_2px_0_0_#0ea5e9] focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all duration-150
                        hover:border-sky-400 hover:shadow-[4px_4px_0_0_#0ea5e9] @error('password') border-red-500 @enderror"
                    required>
                @error('password')
                    <p class="text-red-700 text-xs mt-2 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="bg-sky-400 border-2 border-black text-black font-bold py-2 rounded-xl w-full shadow-[2px_2px_0_0_black] hover:bg-sky-500 hover:shadow-[6px_6px_0_0_black] transition-all duration-150">
                Login
            </button>
            <p class="text-center text-sm font-semibold text-black mt-2">
                Belum punya akun?
                <a href="{{ route('register') }}"
                    class="text-yellow-400 underline hover:text-yellow-600 font-bold transition">Daftar di sini</a>.
            </p>
        </form>
        <p
            class="text-center text-xs text-black mt-6 font-semibold bg-sky-200 px-2 py-1 border-2 border-black rounded shadow-[2px_2px_0_0_black]">
            Masukkan username dan password Anda. Sistem akan mendeteksi peran Anda.
        </p>
    </div>
</body>

</html>
