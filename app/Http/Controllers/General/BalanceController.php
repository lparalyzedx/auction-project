<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\TopUpRequest;
use App\Services\BalanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BalanceController extends Controller
{
    public function __construct(
        private readonly BalanceService $balanceService
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $transactions = $this->balanceService->history($user, perPage: 15);

        return view('general.balance.index', compact('user', 'transactions'));
    }

    public function create(): View
    {
        $presets = [50, 100, 250, 500, 1000];

        return view('general.balance.create', compact('presets'));
    }

    public function store(TopUpRequest $request): RedirectResponse
    {
        $user = $request->user();
        $amount = (float) $request->validated('amount');
        $method = $request->validated('payment_method');

        try {
            /*
             * Gerçek projede burada ödeme sağlayıcınıza (İyzico, PayTR…) istek atarsınız.
             * Başarılı ödeme referans numarasıyla birlikte credit() çağrılır.
             *
             * $paymentResult = app(PaymentGatewayService::class)->charge(
             *     amount: $amount,
             *     card:   $request->only('card_holder','card_number','card_expiry','card_cvv'),
             * );
             * $reference = $paymentResult->referenceCode;
             */

            // --- DEMO: ödeme sağlayıcı simülasyonu ---
            $reference = 'DEMO-'.strtoupper(substr(md5(uniqid()), 0, 10));

            $transaction = $this->balanceService->credit(
                user: $user,
                amount: $amount,
                paymentMethod: $method,
                description: $this->paymentMethodLabel($method).' ile Bakiye Yükleme',
                reference: $reference,
                meta: [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ],
            );

            return redirect()
                ->route('general.balance.index')
                ->with('success', number_format($transaction->amount, 2, ',', '.').' ₺ bakiyenize başarıyla eklendi.');

        } catch (\Exception $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Ödeme işlemi sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function show(Request $request, int $id): View
    {
        $transaction = $request->user()
            ->balanceTransactions()
            ->findOrFail($id);

        return view('general.balance.show', compact('transaction'));
    }

    private function paymentMethodLabel(string $method): string
    {
        return match ($method) {
            'credit_card' => 'Kredi Kartı',
            'bank_transfer' => 'Banka Havalesi',
            'papara' => 'Papara',
            default => 'Ödeme',
        };
    }
}
