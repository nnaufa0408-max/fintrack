<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $type = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingType(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $transaction = Transaction::where('user_id', Auth::id())
            ->findOrFail($id);

        $transaction->delete();

        Cache::forget('dashboard-summary-' . Auth::id());

        session()->flash('success', 'Transaksi berhasil dipindahkan ke riwayat.');
    }

    public function render()
    {
        $transactions = Transaction::with('category')
            ->where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->type, function ($query) {
                $query->where('type', $this->type);
            })
            ->latest('transaction_date')
            ->paginate(10);

        return view('livewire.transaction-table', compact('transactions'));
    }
}
