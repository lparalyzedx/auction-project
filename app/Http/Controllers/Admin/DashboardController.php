<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users'    => User::count(),
            'auctions' => Auction::count(),
            'bids'     => Bid::count(),
            'pending'  => User::where('is_verified', false)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}