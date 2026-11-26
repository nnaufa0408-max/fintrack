@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white p-8 shadow-xl shadow-blue-900/5 sm:p-10">

    <div class="mb-8 text-center">
        <div class="mx-auto mb-4 grid h-14 w-14 place-items-center rounded-2xl bg-[#14264f] text-2xl font-black text-sky-300">
            F
        </div>

        <h1 class="text-2xl font-extrabold text-[#14264f]">
            Buat akun FinTrack
        </h1>

        <p class="mt-2 text-sm text-slate-500">
            Mulai catat pemasukan dan pengeluaranmu.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="mb-2 font-bold">Pendaftaran belum berhasil:</p>
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="mb-1.5 block text-sm font-semibold">Nama lengkap</label>
            <input
                name="name"
                value="{{ old('name') }}"
                required
                class="form-input"
                placeholder="Nama kamu"
            >
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-semibold">Email</label>
            <input
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                class="form-input"
                placeholder="nama@email.com"
            >
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-semibold">Password</label>
            <input
                name="password"
                type="password"
                required
                class="form-input"
                placeholder="Minimal 8 karakter"
            >
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-semibold">Konfirmasi password</label>
            <input
                name="password_confirmation"
                type="password"
                required
                class="form-input"
                placeholder="Ulangi password"
            >
        </div>

        <button
            type="submit"
            class="w-full rounded-xl bg-[#14264f] px-4 py-3 font-semibold text-white shadow-lg transition hover:bg-blue-900"
        >
            Buat akun
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-bold text-sky-700 hover:underline">
            Login
        </a>
    </p>

</div>
@endsection
