<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Package;
use App\Services\SSLCommerzService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get all confirmed bookings that haven't been paid yet
        $pendingBookings = Booking::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->whereDoesntHave('paymentItems')
            ->get();

        // Calculate totals by category
        $flightTotal = $pendingBookings->where('type', 'flight')->sum('amount');
        $hotelTotal = $pendingBookings->where('type', 'hotel')->sum('amount');
        $tourTotal = $pendingBookings->where('type', 'tour')->sum('amount');
        $grandTotal = $flightTotal + $hotelTotal + $tourTotal;

        // Get all available items for reference
        $flights = Flight::all();
        $hotels = Hotel::all();
        $packages = Package::all();

        return view('dashboard.sections.payments', compact(
            'pendingBookings', 
            'flightTotal', 
            'hotelTotal', 
            'tourTotal', 
            'grandTotal',
            'flights',
            'hotels', 
            'packages'
        ));
    }

    public function checkout()
    {
        $user = auth()->user();
        
        // Get all confirmed bookings that haven't been paid yet
        $pendingBookings = Booking::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->whereDoesntHave('paymentItems')
            ->get();

        // Calculate totals by category
        $flightTotal = $pendingBookings->where('type', 'flight')->sum('amount');
        $hotelTotal = $pendingBookings->where('type', 'hotel')->sum('amount');
        $tourTotal = $pendingBookings->where('type', 'tour')->sum('amount');
        $grandTotal = $flightTotal + $hotelTotal + $tourTotal;

        // Get all available items for reference
        $flights = Flight::all();
        $hotels = Hotel::all();
        $packages = Package::all();

        return view('dashboard.sections.payments', compact(
            'pendingBookings', 
            'flightTotal', 
            'hotelTotal', 
            'tourTotal', 
            'grandTotal',
            'flights',
            'hotels', 
            'packages'
        ));
    }

    public function initiate(Request $request)
    {
        $user = auth()->user();
        $pendingBookings = Booking::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->whereDoesntHave('paymentItems')
            ->get();

        if ($pendingBookings->count() == 0) {
            return redirect()->route('payment')->with('error', 'No pending payments found.');
        }

        $totalAmount = $pendingBookings->sum('amount') + ($pendingBookings->sum('amount') * 0.02); // 2% processing fee

        $payment = Payment::create([
            'user_id' => $user->id,
            'transaction_id' => 'TXN' . time() . Str::random(6),
            'amount' => $totalAmount,
            'currency' => 'BDT',
            'status' => 'pending',
            'payment_method' => 'bKash',
            'mobile_number' => $request->mobile_number,
            'customer_info' => [
                'name' => $request->cardholder_name,
                'email' => $user->email,
                'phone' => $request->mobile_number,
                'address' => $request->address,
                'city' => 'Dhaka',
                'state' => 'Dhaka',
                'postcode' => '1000',
                'country' => 'Bangladesh',
                'bkash_pin' => $request->bkash_pin,
            ],
        ]);

        // Create payment items
        foreach ($pendingBookings as $booking) {
            PaymentItem::create([
                'payment_id' => $payment->id,
                'booking_id' => $booking->id,
                'item_type' => $booking->type,
                'item_name' => $booking->details['airline'] ?? $booking->details['hotel'] ?? $booking->details['tour'] ?? 'Booking',
                'item_price' => $booking->amount,
                'quantity' => 1,
                'subtotal' => $booking->amount,
            ]);
        }

        // Initialize SSLCommerz payment
        $sslcommerz = new SSLCommerzService();
        $result = $sslcommerz->initiatePayment($payment, $payment->customer_info);

        if ($result['success']) {
            return redirect($result['redirect_url']);
        } else {
            return redirect()->route('payment')->with('error', 'Payment initiation failed. Please try again.');
        }
    }

    public function success(Request $request)
    {
        $tranId = $request->get('tran_id');
        $amount = $request->get('amount');
        $currency = $request->get('currency');

        if ($tranId && $amount) {
            $payment = Payment::where('transaction_id', $tranId)->first();
            
            if ($payment) {
                $payment->update([
                    'status' => 'success',
                    'payment_method' => $request->get('card_type', 'Card'),
                    'sslcommerz_response' => $request->all(),
                    'paid_at' => now(),
                ]);

                // Update booking statuses through payment items
                foreach ($payment->items as $item) {
                    if ($item->booking) {
                        $item->booking->update(['status' => 'paid']);
                    }
                }

                return redirect()->route('home')->withFragment('payments')
                    ->with('success', 'Payment successful! Your bookings have been confirmed.');
            }
        }

        return redirect()->route('payment')->with('error', 'Payment verification failed.');
    }

    public function fail(Request $request)
    {
        $tranId = $request->get('tran_id');
        
        if ($tranId) {
            $payment = Payment::where('transaction_id', $tranId)->first();
            
            if ($payment) {
                $payment->update([
                    'status' => 'failed',
                    'failure_reason' => $request->get('error', 'Payment failed'),
                    'sslcommerz_response' => $request->all(),
                ]);
            }
        }

        return redirect()->route('payment')->with('error', 'Payment failed. Please try again.');
    }

    public function cancel(Request $request)
    {
        $tranId = $request->get('tran_id');
        
        if ($tranId) {
            $payment = Payment::where('transaction_id', $tranId)->first();
            
            if ($payment) {
                $payment->update([
                    'status' => 'cancelled',
                    'failure_reason' => 'Payment cancelled by user',
                    'sslcommerz_response' => $request->all(),
                ]);
            }
        }

        return redirect()->route('payment')->with('error', 'Payment cancelled.');
    }

    public function history()
    {
        $user = auth()->user();
        if ($user->is_admin) {
            $payments = Payment::with(['user', 'items.booking'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $payments = Payment::where('user_id', $user->id)
                ->with('items.booking')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('dashboard.sections.payment_history', compact('payments'));
    }
}