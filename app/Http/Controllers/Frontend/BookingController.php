<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Room;
use Inertia\Inertia;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    // public function create($roomId)
    // {
    //     $room = Room::findOrFail($roomId);
        
    //     $roomData = [
    //         'id' => $room->id,
    //         'room_number' => $room->room_number,
    //         'room_type' => $room->room_type,
    //         'price' => $room->price,
    //         'capacity' => $room->capacity,
    //         'bed_type' => $room->bed_type,
    //         'size' => $room->size,
    //         'description' => $room->description,
    //         'images' => $room->images ? json_decode($room->images) : [],
    //     ];

    //     // Get user data if logged in
    //     $user = Auth::user();
    //     $userData = null;
        
    //     if ($user) {
    //         $userData = [
    //             'first_name' => $user->first_name ?? '',
    //             'last_name' => $user->last_name ?? '',
    //             'email' => $user->email,
    //             'phone' => $user->phone ?? '',
    //         ];
    //     }

    //     return Inertia::render('Frontend/Booking', [
    //         'room' => $roomData,
    //         'user' => $userData,
    //         'currencies' => $this->getCurrencies(),
    //     ]);
    // }

    public function create($roomId)
{
    $room = Room::findOrFail($roomId);
    
    $roomData = [
        'id' => $room->id,
        'room_number' => $room->room_number ?? '',
        'room_type' => $room->room_type ?? '',
        'price' => (float) ($room->price ?? 0),
        'capacity' => (int) ($room->capacity ?? 1),
        'bed_type' => $room->bed_type ?? '',
        'size' => (float) ($room->size ?? 0),
        'description' => $room->description ?? '',
        'images' => [],
    ];

    // Safely decode images
    if ($room->images) {
        $decodedImages = json_decode($room->images, true);
        if (is_array($decodedImages)) {
            $roomData['images'] = array_map(function($image) {
                return asset($image);
            }, $decodedImages);
        }
    }

    // Get user data if logged in
    $user = Auth::user();
    $userData = null;
    
    if ($user) {
        $userData = [
            'first_name' => $user->first_name ?? '',
            'last_name' => $user->last_name ?? '',
            'email' => $user->email ?? '',
            'phone' => $user->phone ?? '',
        ];
    }

    return Inertia::render('Frontend/Booking', [
        'room' => $roomData,
        'user' => $userData,
        'currencies' => $this->getCurrencies(),
    ]);
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_guests' => 'required|integer|min:1',
            'number_of_rooms' => 'required|integer|min:1',
            
            // Guest information (required if not logged in)
            'guest_first_name' => 'required_if:user_id,null',
            'guest_last_name' => 'required_if:user_id,null',
            'guest_email' => 'required_if:user_id,null|email',
            'guest_phone' => 'nullable|string',
            
            // Payment
            'payment_method' => 'required|in:credit_card,debit_card,paypal,bank_transfer',
            'currency' => 'required|in:USD,EUR,GBP,INR',
            
            'special_requests' => 'nullable|string',
        ]);

        // Calculate booking details
        $room = Room::findOrFail($validated['room_id']);
        $checkIn = new \DateTime($validated['check_in_date']);
        $checkOut = new \DateTime($validated['check_out_date']);
        $numberOfNights = $checkIn->diff($checkOut)->days;

        // Convert price if different currency
        $convertedPrice = $this->convertCurrency($room->price, 'USD', $validated['currency']);
        $subTotal = $convertedPrice * $numberOfNights * $validated['number_of_rooms'];
        $taxAmount = $subTotal * 0.1; // 10% tax
        $totalAmount = $subTotal + $taxAmount;

        // Create booking
        $booking = Booking::create([
            'room_id' => $validated['room_id'],
            'user_id' => Auth::id(),
            
            // Guest information
            'guest_first_name' => $validated['guest_first_name'] ?? null,
            'guest_last_name' => $validated['guest_last_name'] ?? null,
            'guest_email' => $validated['guest_email'] ?? null,
            'guest_phone' => $validated['guest_phone'] ?? null,
            
            // Booking details
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'number_of_nights' => $numberOfNights,
            'number_of_guests' => $validated['number_of_guests'],
            'number_of_rooms' => $validated['number_of_rooms'],
            
            // Pricing
            'room_price_per_night' => $convertedPrice,
            'sub_total' => $subTotal,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'currency' => $validated['currency'],
            
            // Additional info
            'special_requests' => $validated['special_requests'] ?? null,
            'payment_method' => $validated['payment_method'],
            
            // Default status
            'status' => 'pending',
            'payment_status' => 'pending',
            'booking_source' => 'website',
        ]);

        // Redirect to payment simulation
        return redirect()->route('booking.payment', $booking->id);
    }

    
    
//     public function store(Request $request)
// {
//     $validated = $request->validate([
//         'room_id' => 'required|exists:rooms,id',
//         'check_in_date' => 'required|date|after:today',
//         'check_out_date' => 'required|date|after:check_in_date',
//         'number_of_guests' => 'required|integer|min:1',
//         'number_of_rooms' => 'required|integer|min:1',
        
//         // Guest information (required if not logged in)
//         'guest_first_name' => 'required_if:user_id,null',
//         'guest_last_name' => 'required_if:user_id,null',
//         'guest_email' => 'required_if:user_id,null|email',
//         'guest_phone' => 'nullable|string',
        
//         // Payment
//         'payment_method' => 'required|in:credit_card,debit_card,paypal,bank_transfer',
//         'currency' => 'required|in:USD,EUR,GBP,INR',
        
//         'special_requests' => 'nullable|string',
//     ]);

//     try {
//         // Calculate booking details
//         $room = Room::findOrFail($validated['room_id']);
//         $checkIn = new \DateTime($validated['check_in_date']);
//         $checkOut = new \DateTime($validated['check_out_date']);
//         $numberOfNights = $checkIn->diff($checkOut)->days;

//         // Convert price if different currency
//         $convertedPrice = $this->convertCurrency($room->price, 'USD', $validated['currency']);
//         $subTotal = $convertedPrice * $numberOfNights * $validated['number_of_rooms'];
//         $taxAmount = $subTotal * 0.1; // 10% tax
//         $totalAmount = $subTotal + $taxAmount;

//         // Create booking
//         $booking = Booking::create([
//             'room_id' => $validated['room_id'],
//             'user_id' => Auth::id(),
            
//             // Guest information
//             'guest_first_name' => $validated['guest_first_name'] ?? null,
//             'guest_last_name' => $validated['guest_last_name'] ?? null,
//             'guest_email' => $validated['guest_email'] ?? null,
//             'guest_phone' => $validated['guest_phone'] ?? null,
            
//             // Booking details
//             'check_in_date' => $validated['check_in_date'],
//             'check_out_date' => $validated['check_out_date'],
//             'number_of_nights' => $numberOfNights,
//             'number_of_guests' => $validated['number_of_guests'],
//             'number_of_rooms' => $validated['number_of_rooms'],
            
//             // Pricing
//             'room_price_per_night' => $convertedPrice,
//             'sub_total' => $subTotal,
//             'tax_amount' => $taxAmount,
//             'total_amount' => $totalAmount,
//             'currency' => $validated['currency'],
            
//             // Additional info
//             'special_requests' => $validated['special_requests'] ?? null,
//             'payment_method' => $validated['payment_method'],
            
//             // Default status
//             'status' => 'confirmed', // Changed from pending to confirmed
//             'payment_status' => 'paid', // Changed from pending to paid
//             'booking_source' => 'website',
//             'payment_date' => now(),
//             'transaction_id' => 'BOOK' . time() . rand(1000, 9999),
//         ]);

//         // Send confirmation email
//         $this->sendConfirmationEmail($booking);

//         // Return success response for Inertia
//         return redirect()->route('booking.confirmation', $booking->id)->with([
//             'success' => 'Booking confirmed successfully! A confirmation email has been sent.'
//         ]);

//     } catch (\Exception $e) {
//         // Log the error
//         \Log::error('Booking creation failed: ' . $e->getMessage());
        
//         return back()->withErrors([
//             'error' => 'Failed to create booking. Please try again.'
//         ]);
//     }
// }

private function sendConfirmationEmail($booking)
{
    try {
        // You'll need to create this Mailable
        \Mail::to($booking->guest_email)->send(new \App\Mail\BookingConfirmation($booking));
        
    } catch (\Exception $e) {
        \Log::error('Failed to send confirmation email: ' . $e->getMessage());
    }
}
    public function payment($bookingId)
    {
        $booking = Booking::with('room')->findOrFail($bookingId);
        
        return Inertia::render('Frontend/Payment', [
            'booking' => $booking,
        ]);
    }

    public function processPayment(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        
        // Simulate payment processing
        $paymentSuccess = true; // Always success for simulation
        
        if ($paymentSuccess) {
            $booking->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
                'payment_date' => now(),
                'transaction_id' => 'SIM' . time() . rand(1000, 9999),
            ]);
            
            return redirect()->route('booking.confirmation', $booking->id);
        }
        
        return back()->withErrors(['payment' => 'Payment failed. Please try again.']);
    }

    // public function confirmation($bookingId)
    // {
    //     $booking = Booking::with('room')->findOrFail($bookingId);
        
    //     return Inertia::render('Frontend/Confirmation', [
    //         'booking' => $booking,
    //     ]);
    // }

    public function confirmation($bookingId)
{
    $booking = Booking::with('room')->findOrFail($bookingId);
    
    return Inertia::render('Frontend/Confirmation', [
        'booking' => $booking,
        'success' => session('success'), // Pass success message from session
    ]);
}

private function getCurrencies()
{
    return [
        'USD' => ['name' => 'US Dollar', 'symbol' => '$', 'rate' => 1.0],
        'EUR' => ['name' => 'Euro', 'symbol' => '€', 'rate' => 0.85],
        'GBP' => ['name' => 'British Pound', 'symbol' => '£', 'rate' => 0.75],
        'INR' => ['name' => 'Indian Rupee', 'symbol' => '₹', 'rate' => 75.0],
    ];
}

    private function convertCurrency($amount, $fromCurrency, $toCurrency)
    {
        $currencies = $this->getCurrencies();
        
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }
        
        // Convert to USD first, then to target currency
        $amountInUSD = $amount / $currencies[$fromCurrency]['rate'];
        return $amountInUSD * $currencies[$toCurrency]['rate'];
    }

    public function download($bookingId)
{
    $booking = Booking::with('room')->findOrFail($bookingId);
    
    // Generate PDF using a package like barryvdh/laravel-dompdf
    $pdf = PDF::loadView('pdf.booking-confirmation', [
        'booking' => $booking
    ]);
    
    return $pdf->download('booking-confirmation-'.$booking->transaction_id.'.pdf');
}
}