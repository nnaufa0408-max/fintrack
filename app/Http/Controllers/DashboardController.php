<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $summary = Cache::remember(
            "dashboard-summary-{$userId}",
            now()->addMinutes(5),
            function () use ($userId) {
                $base = Transaction::where('user_id', $userId);

                return [
                    'income' => (clone $base)->where('type', 'income')->sum('amount'),
                    'expense' => (clone $base)->where('type', 'expense')->sum('amount'),
                    'count' => (clone $base)->count(),
                ];
            }
        );

        $summary['balance'] = $summary['income'] - $summary['expense'];

        $months = collect(range(5, 0))->map(
            fn ($i) => now()->startOfMonth()->subMonths($i)
        );

        $chart = $months->map(function ($date) use ($userId) {
            $query = Transaction::where('user_id', $userId)
                ->whereYear('transaction_date', $date->year)
                ->whereMonth('transaction_date', $date->month);

            return [
                'label' => $date->translatedFormat('M'),
                'income' => (float) (clone $query)->where('type', 'income')->sum('amount'),
                'expense' => (float) (clone $query)->where('type', 'expense')->sum('amount'),
            ];
        });

        $recent = Transaction::with('category')
            ->where('user_id', $userId)
            ->latest('transaction_date')
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact('summary', 'chart', 'recent'));
    }
}