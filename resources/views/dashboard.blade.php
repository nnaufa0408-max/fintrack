@extends('layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')

<div class="mb-7 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div>
        <p class="text-sm text-slate-500">Ringkasan kondisi keuanganmu</p>
        <h2 class="mt-1 text-2xl font-extrabold text-[#14264f]">Keuangan lebih terkontrol ✨</h2>
    </div>

    <a href="{{ route('transaksi.create') }}"
       class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#14264f] px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-950/10 hover:bg-blue-900">
        ＋ Tambah Transaksi
    </a>
</div>

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

    <div class="rounded-2xl bg-[#14264f] p-6 text-white shadow-lg shadow-blue-950/10 sm:col-span-2 xl:col-span-1">
        <p class="text-sm text-blue-200">Total Saldo</p>
        <p class="mt-3 text-3xl font-extrabold tracking-tight">
            Rp {{ number_format($summary['balance'],0,',','.') }}
        </p>
        <p class="mt-4 text-xs text-blue-200">Pemasukan dikurangi pengeluaran</p>
    </div>

    <div class="rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-500">Total Pemasukan</p>
            <span class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-50 text-xl text-emerald-600">↗</span>
        </div>
        <p class="mt-4 text-2xl font-bold text-slate-800">
            Rp {{ number_format($summary['income'],0,',','.') }}
        </p>
        <p class="mt-2 text-xs text-emerald-600">Uang yang diterima</p>
    </div>

    <div class="rounded-2xl border border-rose-100 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-500">Total Pengeluaran</p>
            <span class="grid h-10 w-10 place-items-center rounded-xl bg-rose-50 text-xl text-rose-600">↘</span>
        </div>
        <p class="mt-4 text-2xl font-bold text-slate-800">
            Rp {{ number_format($summary['expense'],0,',','.') }}
        </p>
        <p class="mt-2 text-xs text-rose-600">Uang yang dikeluarkan</p>
    </div>

</div>

<div class="mt-6 grid gap-6 xl:grid-cols-5">

    <section class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm xl:col-span-3">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-[#14264f]">Arus Keuangan</h3>
                <p class="mt-1 text-xs text-slate-400">Pemasukan dan pengeluaran 6 bulan terakhir</p>
            </div>
            <span class="rounded-lg bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-700">6 bulan</span>
        </div>

        <div class="flex h-56 items-end justify-around gap-3 border-b border-slate-100 px-2 pb-2">
            @php($max = max(1, $chart->max(fn($v)=>max($v['income'],$v['expense']))))

            @foreach($chart as $item)
                <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                    <div class="flex h-[85%] w-full items-end justify-center gap-1.5">
                        <div title="Pemasukan" class="w-5 max-w-[35%] rounded-t-md bg-sky-500"
                             style="height: {{ max(3, $item['income']/$max*100) }}%">
                        </div>
                        <div title="Pengeluaran" class="w-5 max-w-[35%] rounded-t-md bg-indigo-200"
                             style="height: {{ max(3, $item['expense']/$max*100) }}%">
                        </div>
                    </div>
                    <span class="text-xs text-slate-400">{{ $item['label'] }}</span>
                </div>
            @endforeach
        </div>

        <div class="mt-4 flex justify-center gap-5 text-xs text-slate-500">
            <span class="flex items-center gap-2"><i class="h-2.5 w-2.5 rounded-sm bg-sky-500"></i>Pemasukan</span>
            <span class="flex items-center gap-2"><i class="h-2.5 w-2.5 rounded-sm bg-indigo-200"></i>Pengeluaran</span>
        </div>
    </section>

    <section class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm xl:col-span-2">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-[#14264f]">Info Aktivitas</h3>
                <p class="mt-1 text-xs text-slate-400">Aktivitas pencatatanmu</p>
            </div>
            <span class="text-2xl">✦</span>
        </div>

        <div class="mt-7 rounded-xl bg-sky-50 p-5">
            <p class="text-sm text-sky-800">Total transaksi tercatat</p>
            <p class="mt-2 text-3xl font-extrabold text-[#14264f]">{{ $summary['count'] }}</p>
            <p class="mt-1 text-xs text-slate-500">Transaksi aktif di akunmu</p>
        </div>

        <a href="{{ route('kategori.index') }}"
           class="mt-4 flex items-center justify-between rounded-xl border border-slate-100 p-4 text-sm font-semibold text-slate-600 hover:bg-slate-50">
            Kelola kategori <span>→</span>
        </a>
    </section>

</div>

{{-- TRANSAKSI TERBARU MENGGUNAKAN LIVEWIRE --}}
<section class="mt-6 overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">

    <div class="flex items-center justify-between px-6 py-5">
        <div>
            <h3 class="font-bold text-[#14264f]">Transaksi Terbaru</h3>
            <p class="mt-1 text-xs text-slate-400">Catatan keuangan paling baru</p>
        </div>

        <a href="{{ route('transaksi.index') }}"
           class="text-sm font-semibold text-sky-700 hover:underline">
            Lihat semua →
        </a>
    </div>

    @livewire('recent-transactions')

</section>

@endsection
