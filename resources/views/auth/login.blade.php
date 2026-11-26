@extends('layouts.guest')
@section('title','Login')
@section('content')
<div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white p-8 shadow-xl shadow-blue-900/5 sm:p-10">
    <div class="mb-8 text-center"><div class="mx-auto mb-4 grid h-14 w-14 place-items-center rounded-2xl bg-[#14264f] text-2xl font-black text-sky-300">F</div><h1 class="text-2xl font-extrabold text-[#14264f]">Selamat datang kembali</h1><p class="mt-2 text-sm text-slate-500">Masuk untuk mengelola keuanganmu.</p></div>
    @if(session('success'))<p class="mb-4 rounded-lg bg-emerald-50 p-3 text-sm text-emerald-700">{{ session('success') }}</p>@endif
    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">@csrf
        <div><label class="mb-1.5 block text-sm font-semibold">Email</label><input name="email" type="email" value="{{ old('email') }}" required autofocus class="form-input" placeholder="nama@email.com"></div>
        <div><label class="mb-1.5 block text-sm font-semibold">Password</label><input name="password" type="password" required class="form-input" placeholder="Masukkan password"></div>
        <label class="flex items-center gap-2 text-sm text-slate-500"><input type="checkbox" name="remember" class="rounded border-slate-300 text-sky-600"> Ingat saya</label>
        <button class="w-full rounded-xl bg-[#14264f] px-4 py-3 font-semibold text-white shadow-lg shadow-blue-950/10 transition hover:bg-blue-900">Login</button>
    </form>
    <p class="mt-6 text-center text-sm text-slate-500">Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-sky-700 hover:underline">Daftar sekarang</a></p>
    <p class="mt-5 rounded-xl bg-sky-50 p-3 text-xs leading-5 text-sky-800">Akun demo: <b>demo@fintrack.test</b><br>Password: <b>password123</b></p>
</div>
@endsection
