<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecentTransactions extends Component
{
    public function render()
    {
        $recent = Transaction::with('category')
            ->where('user_id', Auth::id())
            ->latest('transaction_date')
            ->latest()
            ->take(6)
            ->get();

        return view('livewire.recent-transactions', [
            'recent' => $recent,
        ]);
    }
}
