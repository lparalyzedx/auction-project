<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
     public function index()
    {
        $user = Auth::user();

        $auctions = $user->auctions();

        $latestAuctions = $user->auctions()
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'auctions' => $user->auctions()->count(),
            'active'   => $user->auctions()->where('status', 'active')->count(),
            'bids'     => $user->bids()->count(),
            'sales'    => $user->auctions()->where('status', 'sold')->count(),
        ];

        $notifications = $user->notifications()
            ->latest()
            ->take(5)
            ->get();

        $walletBalance = $user->wallet_balance ?? 0;

        return view('seller.panel.dashboard', compact(
            'stats',
            'latestAuctions',
            'notifications',
            'walletBalance'
        ));
    }
}
