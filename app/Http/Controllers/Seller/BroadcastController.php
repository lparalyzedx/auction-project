<?php

namespace App\Http\Controllers\Seller;

use App\Events\AuctionSold;
use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BroadcastController extends Controller
{
    public function show(Auction $auction)
    {
        $viewerCount = 0;

        return view('auctions', compact('auction', 'viewerCount'));
    }

    public function sell(Request $request, Auction $auction)
    {
        $validated = $request->validate([
            'bid_id' => ['required', 'integer', 'exists:bids,id'],
        ]);

        $bid = Bid::where('id', $validated['bid_id'])
            ->where('auction_id', $auction->id)
            ->firstOrFail();

        DB::transaction(function () use ($auction, $bid) {
            $auction->update([
                'status' => 'sold',
                'winner_bid_id' => $bid->id,
                'sold_at' => now(),
            ]);
        });

        broadcast(new AuctionSold(
            auction      : $auction,
            buyerName    : $bid->user->name,
            amount       : $bid->amount,
            displayPrice : number_format($bid->amount, 0, ',', '.').' ₺',
        ));

        return response()->json([
            'success' => true,
            'winner_name' => $bid->user->name,
            'amount' => $bid->amount,
        ]);
    }

    // web.php'de 'end-broadcast' route'u bu metoda bağlı
    public function endBroadcast(Auction $auction)
    {
        if ($auction->status === 'active') {
            $auction->update(['status' => 'ended']);
        }

        return response()->json(['success' => true]);
    }
}
