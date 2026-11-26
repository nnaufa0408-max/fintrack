<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TransactionController extends Controller
{
    private function clearDashboardCache(): void
    {
        Cache::forget('dashboard-summary-' . Auth::id());
    }

    public function index()
    {
        $transactions = Transaction::with('category')
            ->where('user_id', Auth::id())
            ->latest('transaction_date')
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        Transaction::create($data + [
            'user_id' => Auth::id(),
        ]);

        $this->clearDashboardCache();

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function show(Transaction $transaction)
    {
        $this->authorizeOwner($transaction);

        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $this->authorizeOwner($transaction);

        $categories = Category::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorizeOwner($transaction);

        $transaction->update($this->validated($request));

        $this->clearDashboardCache();

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorizeOwner($transaction);

        $transaction->delete();

        $this->clearDashboardCache();

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi dipindahkan ke riwayat terhapus.');
    }

    public function history()
    {
        $transactions = Transaction::onlyTrashed()
            ->with('category')
            ->where('user_id', Auth::id())
            ->latest('deleted_at')
            ->paginate(10);

        return view('transactions.history', compact('transactions'));
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'type' => ['required', 'in:income,expense'],
            'amount' => ['required', 'numeric', 'min:1', 'max:999999999999'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'transaction_date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);
    }

    private function authorizeOwner(Transaction $transaction): void
    {
        abort_unless(
            (int) $transaction->user_id === (int) Auth::id(),
            403
        );
    }
}
