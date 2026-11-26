<div class="grid gap-5 sm:grid-cols-2">

    <div class="sm:col-span-2">
        <label class="form-label">Nama transaksi</label>
        <input
            name="title"
            value="{{ old('title', $transaction->title ?? '') }}"
            class="form-input"
            placeholder="Contoh: Makan siang"
            required
        >
    </div>

    <div>
        <label class="form-label">Jenis transaksi</label>
        <select name="type" class="form-input" required>
            <option value="income" @selected(old('type', $transaction->type ?? 'expense') === 'income')>
                Pemasukan
            </option>
            <option value="expense" @selected(old('type', $transaction->type ?? 'expense') === 'expense')>
                Pengeluaran
            </option>
        </select>
    </div>

    <div>
        <label class="form-label">Nominal (Rp)</label>
        <input
            name="amount"
            type="number"
            min="1"
            step="1"
            value="{{ old('amount', $transaction->amount ?? '') }}"
            class="form-input"
            placeholder="50000"
            required
        >
    </div>

    <div>
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-input">
            <option value="">Tanpa kategori</option>

            @foreach($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(old('category_id', $transaction->category_id ?? '') == $category->id)
                >
                    {{ $category->name }} · {{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="form-label">Tanggal</label>
        <input
            name="transaction_date"
            type="date"
            value="{{ old('transaction_date', isset($transaction) ? $transaction->transaction_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
            class="form-input"
            required
        >
    </div>

    <div class="sm:col-span-2">
        <label class="form-label">Catatan (opsional)</label>
        <textarea
            name="description"
            rows="3"
            class="form-input"
            placeholder="Tambahkan keterangan transaksi..."
        >{{ old('description', $transaction->description ?? '') }}</textarea>
    </div>

</div>

<div class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

    <a
        href="{{ route('transaksi.index') }}"
        class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600"
    >
        Batal
    </a>

    <flux:button type="submit" variant="primary">
        Simpan Transaksi
    </flux:button>

</div>
