<?php

namespace App\Http\Controllers\Backend;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class BookingRoomController extends Controller
{
      public function index()
    {
        return view('backend.pages.booking.index');
    }


public function getList(Request $request)
{
    $user = auth()->user();
    
    // Base query
    $data = Booking::with(['room', 'user', 'createdBy'])
        ->select('bookings.*')
        ->orderBy('bookings.created_at', 'desc');
    
    if ($user->role != 1) {
        $data->where(function($query) use ($user) {
            $query->where('bookings.user_id', $user->id)
                  ->orWhere('bookings.guest_email', $user->email);
        });
    }
    
    if ($request->booking_id) {
        $data->where('bookings.id', $request->booking_id);
    }
    
    if ($request->transaction_id) {
        $data->where('bookings.transaction_id', 'like', "%" . $request->transaction_id . "%");
    }
    
    if ($request->guest_name) {
        $data->where(function($query) use ($request) {
            $query->where('bookings.guest_first_name', 'like', "%" . $request->guest_name . "%")
                  ->orWhere('bookings.guest_last_name', 'like', "%" . $request->guest_name . "%")
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('first_name', 'like', "%" . $request->guest_name . "%")
                               ->orWhere('last_name', 'like', "%" . $request->guest_name . "%");
                  });
        });
    }
    
    if ($request->guest_email) {
        $data->where(function($query) use ($request) {
            $query->where('bookings.guest_email', 'like', "%" . $request->guest_email . "%")
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('email', 'like', "%" . $request->guest_email . "%");
                  });
        });
    }
    
    if ($request->room_number) {
        $data->whereHas('room', function($query) use ($request) {
            $query->where('room_number', 'like', "%" . $request->room_number . "%");
        });
    }
    
    if ($request->status) {
        $data->where('bookings.status', $request->status);
    }
    
    if ($request->payment_status) {
        $data->where('bookings.payment_status', $request->payment_status);
    }
    
    if ($request->check_in_date) {
        $data->whereDate('bookings.check_in_date', '>=', $request->check_in_date);
    }
    
    if ($request->check_out_date) {
        $data->whereDate('bookings.check_out_date', '<=', $request->check_out_date);
    }
    
    if ($request->user_type) {
        if ($request->user_type == 'registered') {
            $data->whereNotNull('user_id');
        } elseif ($request->user_type == 'guest') {
            $data->whereNull('user_id');
        }
    }

    return DataTables::of($data)
        ->addColumn('booking_id', function ($row) {
            return '#' . str_pad($row->id, 6, '0', STR_PAD_LEFT);
        })
        
       ->addColumn('guest_name', function ($row) {
    $name = '';
    
    if ($row->user_id && $row->user && $row->user->role == 1) {
        if ($row->user_id == $row->created_by) {
            $name = $row->user->name;
            $name .= ' <span class="badge bg-info">Admin</span>';
        } else {
            $name = $row->guest_first_name . ' ' . $row->guest_last_name;
            $name .= ' <span class="badge bg-primary">Guest</span>';
            
            if ($row->createdBy) {
                $name .= '<br><small class="text-muted">Booked by: ' . $row->createdBy->name . ' (Admin)</small>';
            }
        }
    }
    else if ($row->user_id && $row->user) {
        $name = $row->user->name;
        $name .= ' <span class="badge bg-info">Registered</span>';
    }
    else {
        $name = $row->guest_first_name . ' ' . $row->guest_last_name;
        $name .= ' <span class="badge bg-primary">Guest</span>';
        
        if ($row->created_by && $row->createdBy && $row->createdBy->role == 1) {
            $name .= '<br><small class="text-muted">Booked by: ' . $row->createdBy->name . ' (Admin)</small>';
        }
    }
    
    return $name;
})
        
        ->addColumn('guest_email', function ($row) {
            return $row->user_id ? $row->user->email : $row->guest_email;
        })
        
        ->addColumn('guest_phone', function ($row) {
            return $row->user_id ? $row->user->phone : $row->guest_phone;
        })
        
        ->addColumn('room_info', function ($row) {
            if ($row->room) {
                return $row->room->room_number . ' (' . ucfirst($row->room->room_type) . ')';
            }
            return 'N/A';
        })
        
        ->editColumn('check_in_date', function ($row) {
            return \Carbon\Carbon::parse($row->check_in_date)->format('M d, Y');
        })
        
        ->editColumn('check_out_date', function ($row) {
            return \Carbon\Carbon::parse($row->check_out_date)->format('M d, Y');
        })
        
        ->editColumn('total_amount', function ($row) {
            return $row->currency . ' ' . number_format($row->total_amount, 2);
        })
        
        ->editColumn('status', function ($row) {
            $statusClasses = [
                'pending' => 'bg-warning text-white',
                'confirmed' => 'bg-info text-white',
                'checked_in' => 'bg-primary text-white',
                'checked_out' => 'bg-success text-white',
                'cancelled' => 'bg-danger text-white',
                'no_show' => 'bg-secondary text-white',
                'refunded' => 'bg-dark text-white'
            ];
            
            $class = $statusClasses[$row->status] ?? 'bg-secondary text-white';
            return '<span class="badge ' . $class . ' rounded-pill px-3 py-1">' . ucfirst($row->status) . '</span>';
        })
        
        ->editColumn('payment_status', function ($row) {
            $statusClasses = [
                'pending' => 'bg-warning text-white',
                'paid' => 'bg-success text-white',
                'failed' => 'bg-danger text-white',
                'refunded' => 'bg-dark text-white'
            ];
            
            $class = $statusClasses[$row->payment_status] ?? 'bg-secondary text-white';
            return '<span class="badge ' . $class . ' rounded-pill px-3 py-1">' . ucfirst($row->payment_status) . '</span>';
        })
        
        ->addColumn('user_type', function ($row) {
            return $row->user_id ? 'Registered User' : 'Guest';
        })
        
        ->addColumn('action', function ($row) use ($user) {
            $btn = '';
            
            $btn .= '<a href="'.route('booking.room.view', $row->id).'" class="view_btn btn btn-sm btn-info text-white" title="View Details"><i class="fa-solid fa-eye"></i></a>';
            
            $canEdit = false;
            if ($user->role == 1) {
                $canEdit = true; 
            } else if ($user->id == $row->user_id) {
                $canEdit = true; 
            } else if (!$row->user_id && $user->email == $row->guest_email) {
                $canEdit = true; 
            }
            
            if ($canEdit) {
                $btn .= '<a href="'.route('booking.room.edit', $row->id).'" class="edit_btn btn btn-sm btn-warning text-white mx-1" title="Edit"><i class="fa-solid fa-pencil"></i></a>';
            }
            
             if ($user->role == 1) {
        $btn .= '<button class="btn btn-sm btn-danger delete_btn" 
                 data-id="'.$row->id.'" 
                 data-transaction-id="'.$row->transaction_id.'" 
                 data-guest-name="'.$row->guest_first_name.' '.$row->guest_last_name.'" 
                 title="Delete">
                 <i class="fa fa-trash"></i>
                 </button>';
    }
            

            
            return '<div class="btn-group">' . $btn . '</div>';
        })
        
        ->rawColumns(['guest_name', 'status', 'payment_status', 'action'])
        ->make(true);
}

public function view($id)
{
    $booking = Booking::with(['room', 'user', 'createdBy'])
        ->findOrFail($id);
    
    // Authorization check - user can only view their own bookings unless admin
    $user = auth()->user();
    if ($user->role != 1 && $booking->user_id != $user->id && $booking->guest_email != $user->email) {
        abort(403, 'Unauthorized access to this booking.');
    }
    
    return view('backend.pages.booking.view', [
        'booking' => $booking,
        'canEdit' => $user->role == 1 || $booking->user_id == $user->id || $booking->guest_email == $user->email,
    ]);
}

public function edit($id)
{
    $booking = Booking::with(['room', 'user'])->findOrFail($id);
    
    // Authorization check
    $user = auth()->user();
    if ($user->role != 1 && $booking->user_id != $user->id && $booking->guest_email != $user->email) {
        abort(403, 'Unauthorized access to this booking.');
    }
    
    $rooms = Room::where('status', 'available')->get();
    $currencies = ['USD' => 'US Dollar', 'EUR' => 'Euro', 'GBP' => 'British Pound', 'INR' => 'Indian Rupee'];
    
    return view('backend.pages.booking.edit', [
        'booking' => $booking,
        'rooms' => $rooms,
        'currencies' => $currencies,
        'statuses' => ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled', 'no_show', 'refunded'],
        'payment_statuses' => ['pending', 'paid', 'failed', 'refunded'],
        'payment_methods' => ['credit_card', 'debit_card', 'paypal', 'bank_transfer', 'cash'],
        'booking_sources' => ['website', 'walk_in', 'phone', 'email', 'travel_agent', 'booking_platform']
    ]);
}

public function update(Request $request, $id)
{
    $booking = Booking::findOrFail($id);
    
    // Authorization check
    $user = auth()->user();
    if ($user->role != 1 && $booking->user_id != $user->id && $booking->guest_email != $user->email) {
        return response()->json(['error' => 'Unauthorized access'], 403);
    }
    
    $validated = $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'check_in_date' => 'required|date',
        'check_out_date' => 'required|date|after:check_in_date',
        'number_of_guests' => 'required|integer|min:1',
        'number_of_rooms' => 'required|integer|min:1',
        
        // Guest information
        'guest_first_name' => 'required_if:user_id,null',
        'guest_last_name' => 'required_if:user_id,null',
        'guest_email' => 'required_if:user_id,null|email',
        'guest_phone' => 'nullable|string',
        'guest_address' => 'nullable|string',
        'guest_country' => 'nullable|string',
        'guest_city' => 'nullable|string',
        'guest_zip_code' => 'nullable|string',
        
        // Payment
        'payment_method' => 'nullable|in:credit_card,debit_card,paypal,bank_transfer,cash',
        'currency' => 'required|in:USD,EUR,GBP,INR',
        
        // Status
        'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled,no_show,refunded',
        'payment_status' => 'required|in:pending,paid,failed,refunded',
        
        'special_requests' => 'nullable|string',
        'admin_notes' => 'nullable|string',
        'cancellation_reason' => 'nullable|required_if:status,cancelled|string',
    ]);
    
    try {
        // Recalculate pricing if room or dates changed
        if ($booking->room_id != $validated['room_id'] || 
            $booking->check_in_date != $validated['check_in_date'] ||
            $booking->check_out_date != $validated['check_out_date']) {
            
            $room = Room::findOrFail($validated['room_id']);
            $checkIn = new \DateTime($validated['check_in_date']);
            $checkOut = new \DateTime($validated['check_out_date']);
            $numberOfNights = $checkIn->diff($checkOut)->days;
            
            // Convert price if different currency
            $convertedPrice = $this->convertCurrency($room->price, 'USD', $validated['currency']);
            $subTotal = $convertedPrice * $numberOfNights * $validated['number_of_rooms'];
            $taxAmount = $subTotal * 0.1; // 10% tax
            $totalAmount = $subTotal + $taxAmount;
            
            $validated['number_of_nights'] = $numberOfNights;
            $validated['room_price_per_night'] = $convertedPrice;
            $validated['sub_total'] = $subTotal;
            $validated['tax_amount'] = $taxAmount;
            $validated['total_amount'] = $totalAmount;
        }
        
        // Handle status changes
        if ($validated['status'] == 'cancelled' && $booking->status != 'cancelled') {
            $validated['cancelled_at'] = now();
        }
        
        if ($validated['status'] == 'checked_in' && $booking->status != 'checked_in') {
            $validated['checked_in_at'] = now();
        }
        
        if ($validated['status'] == 'checked_out' && $booking->status != 'checked_out') {
            $validated['checked_out_at'] = now();
        }
        
        if ($validated['payment_status'] == 'paid' && $booking->payment_status != 'paid') {
            $validated['payment_date'] = now();
        }
        
        $booking->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully!',
            'booking' => $booking
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Booking update failed: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to update booking: ' . $e->getMessage()
        ], 500);
    }
}

private function convertCurrency($amount, $fromCurrency, $toCurrency)
{
    $exchangeRates = [
        'USD' => 1.0,
        'EUR' => 0.85,
        'GBP' => 0.75,
        'INR' => 75.0
    ];
    
    return $amount * ($exchangeRates[$toCurrency] / $exchangeRates[$fromCurrency]);
}

public function delete($id)
{
    try {
        $booking = Booking::findOrFail($id);
        
        $user = auth()->user();
        if ($user->role != 1 && $booking->user_id != $user->id && $booking->guest_email != $user->email) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to delete this booking.'
            ], 403);
        }
        
        if ($booking->room_id && $booking->status === 'checked_in') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete booking. Guest is currently checked in. Please check out first.'
            ], 422);
        }
        
        if ($booking->status === 'confirmed' && $booking->check_in_date <= now()->addDays(2)) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete booking. Check-in is within 2 days. Please cancel instead.'
            ], 422);
        }
        
        if ($booking->payment_status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete booking with paid status. Please refund first.'
            ], 422);
        }
        
        $bookingInfo = [
            'id' => $booking->id,
            'transaction_id' => $booking->transaction_id,
            'guest_name' => $booking->guest_first_name . ' ' . $booking->guest_last_name,
            'room_id' => $booking->room_id,
            'check_in_date' => $booking->check_in_date,
            'check_out_date' => $booking->check_out_date
        ];
        
   
        $booking->delete();
       
        \Log::info('Booking deleted', [
            'deleted_by' => $user->id,
            'booking_info' => $bookingInfo,
            'deleted_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Booking deleted successfully!',
            'redirect' => route('booking.room')
        ]);
        
    } catch (QueryException $e) {
  
        if (strpos($e->getMessage(), 'foreign key constraint') !== false) {
            \Log::error('Booking deletion failed due to foreign key constraint: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete booking. It is connected to other records in the system.'
            ], 422);
        }
        
        \Log::error('Booking deletion failed: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Database error occurred while deleting booking.'
        ], 500);
        
    } catch (\Exception $e) {
        \Log::error('Booking deletion failed: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'An unexpected error occurred while deleting booking.'
        ], 500);
    }
}
}
