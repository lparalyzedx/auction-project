<?php

namespace App\Http\Controllers\General;

use App\Events\BidPlaced;
use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BidController extends Controller
{
    public function store(Request $request, Auction $auction)
    {
        if (! $auction->isActive()) {
            return response()->json(['message' => 'Bu müzayede aktif değil.'], 422);
        }

        if ($auction->user_id === auth()->id()) {
            return response()->json(['message' => 'Kendi ilanınıza teklif veremezsiniz.'], 422);
        }

        $minAmount = (float) $auction->current_price + (float) $auction->min_bid_increment;

        try {
            $request->validate([
                'amount' => "required|numeric|min:{$minAmount}",
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->errors()['amount'][0] ?? 'Geçersiz teklif.',
            ], 422);
        }

        $bid = Bid::create([
            'auction_id' => $auction->id,
            'user_id'    => auth()->id(),
            'amount'     => $request->amount,
            'ip_address' => $request->ip(),
        ]);

        $auction->update(['current_price' => $request->amount]);

        // Diğer herkese anlık bildir (teklif verenin kendisi hariç)
        broadcast(new BidPlaced($bid))->toOthers();

        // Teklif verenin kendi ekranı için yanıt
        return response()->json([
            'bid_id'        => $bid->id,
            'bidder_id'     => (int) auth()->id(),
            'bidder_name'   => auth()->user()->name,
            'amount'        => (float) $bid->amount,
            'display_price' => number_format($bid->amount, 0, ',', '.') . ' ₺',
            'total_bids'    => $auction->fresh()->bids()->count(),
        ]);
    }

    public function show(Auction $auction)
    {
        $auction->increment('view_count');
        $auction->load(['images', 'cover', 'bids.user', 'category', 'user']);

        return view('auctionsnew', compact('auction'));
    }
}
