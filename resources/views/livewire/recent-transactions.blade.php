<div>
    <div class="overflow-x-auto">
        <table class="w-full min-w-[620px] text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
                <tr>
                    <th class="px-6 py-3">Transaksi</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3 text-right">Jumlah</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse($recent as $item)
                    <tr>
                        <td class="px-6 py-4 font-semibold text-slate-700">
                            {{ $item->title }}
                        </td>

                        <td class="px-6 py-4 text-slate-500">
                            {{ $item->category?->name ?? 'Tanpa kategori' }}
                        </td>

                        <td class="px-6 py-4 text-slate-500">
                            {{ $item->transaction_date->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4 text-right font-bold {{ $item->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $item->type === 'income' ? '+' : '−' }}
                            Rp {{ number_format($item->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                            Belum ada transaksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
