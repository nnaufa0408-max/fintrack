<div>
    <div class="mb-4 flex flex-col gap-3 sm:flex-row">
        <input
            wire:model.live.debounce.300ms="search"
            class="form-input sm:max-w-sm"
            placeholder="Cari nama transaksi..."
        >

        <select wire:model.live="type" class="form-input sm:max-w-48">
            <option value="">Semua jenis</option>
            <option value="income">Pemasukan</option>
            <option value="expense">Pengeluaran</option>
        </select>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 p-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full min-w-[760px] text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
                <tr>
                    <th class="px-6 py-4">Nama transaksi</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Jenis</th>
                    <th class="px-6 py-4 text-right">Nominal</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($transactions as $item)
                    <tr wire:key="transaction-{{ $item->id }}" class="hover:bg-slate-50/70">
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
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $item->type === 'income' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                {{ $item->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right font-bold">
                            Rp {{ number_format($item->amount, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-3">
                                <a
                                    href="{{ route('transaksi.show', $item) }}"
                                    class="font-semibold text-sky-700 hover:underline">
                                    Detail
                                </a>

                                <a
                                    href="{{ route('transaksi.edit', $item) }}"
                                    class="font-semibold text-indigo-600 hover:underline">
                                    Edit
                                </a>

                                <button
                                    type="button"
                                    wire:click="delete({{ $item->id }})"
                                    wire:loading.attr="disabled"
                                    wire:confirm="Yakin ingin menghapus transaksi ini?"
                                    class="font-semibold text-rose-600 hover:underline disabled:opacity-50">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            Tidak ada transaksi yang cocok.
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
