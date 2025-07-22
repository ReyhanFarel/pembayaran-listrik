@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
    <div class="bg-white p-8 rounded-none border-4 border-neutral-900 neo-brutal-shadow-black">
        <h1 class="text-4xl font-extrabold text-neutral-900 mb-4 uppercase">Daftar User</h1>

        @if (session('success'))
            <div class="bg-green-600 text-white px-4 py-3 rounded-none border-2 border-neutral-900 neo-brutal-shadow-black relative mb-6"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-600 text-white px-4 py-3 rounded-none border-2 border-neutral-900 neo-brutal-shadow-black relative mb-6"
                role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="mb-6 text-right">
            <a href="{{ route('admin.users.create') }}"
                class="inline-block bg-sky-500 hover:bg-sky-600 text-neutral-900 font-extrabold py-3 px-6 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1 uppercase">
                Tambah User Baru
            </a>
        </div>

        <div class="overflow-x-auto border-4 border-neutral-900 neo-brutal-shadow-black">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            ID</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Nama User</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Username</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-left text-black font-extrabold uppercase">
                            Level</th>
                        <th
                            class="py-4 px-4 border-b-4 border-neutral-900 bg-sky-300 text-center text-black font-extrabold uppercase">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b-2 border-neutral-200 hover:bg-sky-50 transition duration-150 ease-in-out">
                            <td class="py-3 px-4 text-neutral-900">{{ $user->id }}</td>
                            <td class="py-3 px-4 text-neutral-900">{{ $user->nama_user }}</td>
                            <td class="py-3 px-4 text-neutral-900">{{ $user->username }}</td>
                            <td class="py-3 px-4 text-neutral-900">{{ $user->level->nama_level ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-bold py-2 px-4 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow mr-3 transition duration-200 ease-in-out transform hover:-translate-y-1">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded-none border-2 border-neutral-900 neo-brutal-button-shadow transition duration-200 ease-in-out transform hover:-translate-y-1">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 px-4 text-center text-neutral-500 text-lg italic">Belum ada data
                                user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-8">
            {{-- Pagination links --}}
            {{ $users->links() }}
        </div>
    </div>
@endsection
