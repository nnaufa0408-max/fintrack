@extends('layouts.app')

@section('title', 'Transaksi')
@section('page-title', 'Transaksi')

@section('content')

<div class="mb-6 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
    <div>
        <h2 class="text-xl font-bold text-[#14264f]">
            Semua Transaksi
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Kelola seluruh pemasukan dan pengeluaranmu.
        </p>
    </div>

    <a href="{{ route('transaksi.create') }}"
       class="rounded-xl bg-blue-700 px-5 py-3 text-center text-sm font-semibold text-white hover:bg-blue-800">
        + Tambah Transaksi
    </a>
</div>

<div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">

    <div class="overflow-x-auto">
        <table class="w-full min-w-[760px] text-left text-sm">

            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
                <tr>
                    <th class="px-6 py-4">Nama Transaksi</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Jenis</th>
                    <th class="px-6 py-4 text-right">Nominal</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">

                @forelse ($transactions as $item)

                <tr class="hover:bg-slate-50">

                    <td class="px-6 py-4 font-semibold text-slate-700">
                        {{ $item->title }}
                    </td>

                    <td class="px-6 py-4 text-slate-500">
                        {{ $item->category?->name ?? 'Tanpa kategori' }}
                    </td>

                    <td class="px-6 py-4 text-slate-500">
                        {{ $item->transaction_date->format('d/m/Y') }}
                    </td>

                    <td class="px-6 py-4">
                        @if ($item->type === 'income')
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                Pemasukan
                            </span>
                        @else
                            <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700">
                                Pengeluaran
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-right font-bold text-slate-700">
                        Rp {{ number_format($item->amount, 0, ',', '.') }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-3">

                            <a href="{{ route('transaksi.show', $item) }}"
                               class="font-semibold text-sky-700 hover:underline">
                                Detail
                            </a>

                            <a href="{{ route('transaksi.edit', $item) }}"
                               class="font-semibold text-indigo-600 hover:underline">
                                Edit
                            </a>

                            <form action="{{ route('transaksi.destroy', $item) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="font-semibold text-rose-600 hover:underline">
                                    Hapus
                                </button>

                            </form>

                        </div>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        Belum ada transaksi.
                    </td>
                </tr>

                @endforelse

            </tbody>
        </table>
    </div>

    <div class="border-t border-slate-100 px-6 py-4">
        {{ $transactions->links() }}
    </div>

</div>

@endsection
