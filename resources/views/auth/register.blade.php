<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pelanggan Baru</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-sky-100 flex items-center justify-center min-h-screen">
    <div
        class="group bg-white border-2 border-black rounded-xl shadow-[8px_8px_0_0_#0ea5e9] max-w-2xl w-full p-8 relative transition-all duration-200 hover:shadow-[12px_12px_0_0_#0ea5e9] hover:border-sky-400">
        <span class="absolute top-4 left-4 w-6 h-6 bg-sky-300 border-2 border-black rounded-lg"></span>
        <span class="absolute bottom-4 right-4 w-4 h-4 bg-yellow-300 border-2 border-black rounded"></span>
        <h2 class="text-2xl font-bold text-center mb-6 text-black tracking-wide" style="text-shadow: 2px 2px #0ea5e9;">
            Registrasi Pelanggan Baru
        </h2>

        @if ($errors->any())
            <div class="bg-red-100 border-2 border-black text-red-700 px-4 py-2 rounded mb-4 font-semibold shadow-[2px_2px_0_0_black]"
                role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                <ul class="mt-3 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            <div class="space-y-5">
                <div>
                    <label for="nama_pelanggan" class="block text-sm font-semibold text-black mb-1">Nama Lengkap</label>
                    <input type="text" id="nama_pelanggan" name="nama_pelanggan"
                        class="bg-sky-50 border-2 border-black rounded-lg w-full py-2 px-3 text-black font-semibold shadow-[2px_2px_0_0_#0ea5e9] focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all duration-150 hover:border-sky-400 hover:shadow-[4px_4px_0_0_#0ea5e9] @error('nama_pelanggan') border-red-500 @enderror"
                        value="{{ old('nama_pelanggan') }}" required autofocus>
                    @error('nama_pelanggan')
                        <p class="text-red-700 text-xs mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="username" class="block text-sm font-semibold text-black mb-1">Username</label>
                    <input type="text" id="username" name="username"
                        class="bg-sky-50 border-2 border-black rounded-lg w-full py-2 px-3 text-black font-semibold shadow-[2px_2px_0_0_#0ea5e9] focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all duration-150 hover:border-sky-400 hover:shadow-[4px_4px_0_0_#0ea5e9] @error('username') border-red-500 @enderror"
                        value="{{ old('username') }}" required>
                    @error('username')
                        <p class="text-red-700 text-xs mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-black mb-1">Password</label>
                    <input type="password" id="password" name="password"
                        class="bg-sky-50 border-2 border-black rounded-lg w-full py-2 px-3 text-black font-semibold shadow-[2px_2px_0_0_#0ea5e9] focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all duration-150 hover:border-sky-400 hover:shadow-[4px_4px_0_0_#0ea5e9] @error('password') border-red-500 @enderror"
                        required>
                    @error('password')
                        <p class="text-red-700 text-xs mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-black mb-1">Konfirmasi
                        Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="bg-sky-50 border-2 border-black rounded-lg w-full py-2 px-3 text-black font-semibold shadow-[2px_2px_0_0_#0ea5e9] focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all duration-150 hover:border-sky-400 hover:shadow-[4px_4px_0_0_#0ea5e9]"
                        required>
                </div>
            </div>
            <div class="space-y-5">
                <div>
                    <label for="alamat" class="block text-sm font-semibold text-black mb-1">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3"
                        class="bg-sky-50 border-2 border-black rounded-lg w-full py-2 px-3 text-black font-semibold shadow-[2px_2px_0_0_#0ea5e9] focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all duration-150 hover:border-sky-400 hover:shadow-[4px_4px_0_0_#0ea5e9] @error('alamat') border-red-500 @enderror"
                        required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-red-700 text-xs mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="nomor_kwh" class="block text-sm font-semibold text-black mb-1">Nomor KWH</label>
                    <input type="text" id="nomor_kwh" name="nomor_kwh"
                        class="bg-sky-50 border-2 border-black rounded-lg w-full py-2 px-3 text-black font-semibold shadow-[2px_2px_0_0_#0ea5e9] focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all duration-150 hover:border-sky-400 hover:shadow-[4px_4px_0_0_#0ea5e9] @error('nomor_kwh') border-red-500 @enderror"
                        value="{{ old('nomor_kwh') }}" required>
                    @error('nomor_kwh')
                        <p class="text-red-700 text-xs mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="tarif_id" class="block text-sm font-semibold text-black mb-1">Pilih Tarif</label>
                    <select id="tarif_id" name="tarif_id"
                        class="bg-sky-50 border-2 border-black rounded-lg w-full py-2 px-3 text-black font-semibold shadow-[2px_2px_0_0_#0ea5e9] focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all duration-150 hover:border-sky-400 hover:shadow-[4px_4px_0_0_#0ea5e9] @error('tarif_id') border-red-500 @enderror"
                        required>
                        <option value="">-- Pilih Tarif --</option>
                        @foreach ($tarifs as $tarif)
                            <option value="{{ $tarif->id }}" {{ old('tarif_id') == $tarif->id ? 'selected' : '' }}>
                                {{ number_format($tarif->daya, 0, ',', '.') }} VA - Rp
                                {{ number_format($tarif->tarif_perkwh, 2, ',', '.') }}/kWh
                            </option>
                        @endforeach
                    </select>
                    @error('tarif_id')
                        <p class="text-red-700 text-xs mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="md:col-span-2">
                <button type="submit"
                    class="bg-sky-400 border-2 border-black text-black font-bold py-2 rounded-xl w-full shadow-[2px_2px_0_0_black] hover:bg-sky-500 hover:shadow-[6px_6px_0_0_black] transition-all duration-150">
                    Daftar
                </button>
                <p class="text-center text-sm font-semibold text-black mt-2">
                    Sudah punya akun?
                    <a href="{{ route('login') }}"
                        class="text-yellow-400 underline hover:text-yellow-600 font-bold transition">Login di sini</a>.
                </p>
            </div>
        </form>
    </div>
</body>

</html>
