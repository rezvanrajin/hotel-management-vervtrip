<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomController extends Controller
{
//    public function index(Request $request)
//     {
//         $query = Room::where('status', 'available');
        
      
//         if ($request->has('check_in') && $request->has('check_out') && $request->check_in && $request->check_out) {
         
//         }
        
//         if ($request->has('room_type') && $request->room_type) {
//             $query->where('room_type', $request->room_type);
//         }
        
//         if ($request->has('guests') && $request->guests) {
//             $query->where('capacity', '>=', $request->guests);
//         }

//         $rooms = $query->get()->map(function ($room) {
//             return [
//                 'id' => $room->id,
//                 'room_number' => $room->room_number,
//                 'room_type' => $room->room_type,
//                 'price' => $room->price,
//                 'capacity' => $room->capacity,
//                 'bed_type' => $room->bed_type,
//                 'size' => $room->size,
//                 'description' => $room->description,
//                 'images' => $room->images ? json_decode($room->images) : [],
//                 'amenities' => $room->amenities ? json_decode($room->amenities) : [],
//             ];
//         });

//         return Inertia::render('Frontend/RoomListing', [
//             'rooms' => $rooms,
//             'filters' => $request->all(), 
//         ]);
//     }

   
// public function index(Request $request)
// {
//     $query = Room::where('status', 'available');
    
//     $appliedFilters = [];
    
//     // Apply search filters
//     if ($request->has('check_in') && $request->check_in && $request->has('check_out') && $request->check_out) {
//         $appliedFilters['check_in'] = $request->check_in;
//         $appliedFilters['check_out'] = $request->check_out;
        
//         // Basic availability check (you'll need to implement this based on your booking system)
//         // $query->whereDoesntHave('bookings', function($q) use ($request) {
//         //     $q->where(function($q) use ($request) {
//         //         $q->whereBetween('check_in_date', [$request->check_in, $request->check_out])
//         //           ->orWhereBetween('check_out_date', [$request->check_in, $request->check_out])
//         //           ->orWhere(function($q) use ($request) {
//         //               $q->where('check_in_date', '<=', $request->check_in)
//         //                 ->where('check_out_date', '>=', $request->check_out);
//         //           });
//         //     })->whereIn('status', ['confirmed', 'checked_in']);
//         // });
//     }
    
//     if ($request->has('room_type') && $request->room_type) {
//         $query->where('room_type', $request->room_type);
//         $appliedFilters['room_type'] = $request->room_type;
//     }
    
//     if ($request->has('guests') && $request->guests) {
//         $query->where('capacity', '>=', $request->guests);
//         $appliedFilters['guests'] = (int)$request->guests;
//     }

//     $rooms = $query->get()->map(function ($room) {
//         return [
//             'id' => $room->id,
//             'room_number' => $room->room_number,
//             'room_type' => $room->room_type,
//             'price' => $room->price,
//             'capacity' => $room->capacity,
//             'bed_type' => $room->bed_type,
//             'size' => $room->size,
//             'description' => $room->description,
//             'images' => $room->images ? json_decode($room->images) : [],
//             'amenities' => $room->amenities ? json_decode($room->amenities) : [],
//         ];
//     });

//     return Inertia::render('Frontend/RoomListing', [
//         'rooms' => $rooms,
//         'filters' => array_merge([
//             'check_in' => $request->check_in ?? '',
//             'check_out' => $request->check_out ?? '',
//             'guests' => $request->guests ?? 1,
//             'room_type' => $request->room_type ?? '',
//         ], $appliedFilters),
//     ]);
// }

public function index(Request $request)
{
    $query = Room::where('status', 'available');
    
    // Initialize filter values array to pass to frontend
    $appliedFilters = [];
    
    // Apply search filters
    if ($request->has('check_in') && $request->check_in) {
        $appliedFilters['check_in'] = $request->check_in;
        // Here you would add availability checking logic later
    }
    
    if ($request->has('check_out') && $request->check_out) {
        $appliedFilters['check_out'] = $request->check_out;
        // Here you would add availability checking logic later
    }
    
    if ($request->has('room_type') && $request->room_type) {
        $query->where('room_type', $request->room_type);
        $appliedFilters['room_type'] = $request->room_type;
    }
    
    if ($request->has('guests') && $request->guests) {
        $query->where('capacity', '>=', $request->guests);
        $appliedFilters['guests'] = $request->guests;
    }

    $rooms = $query->get()->map(function ($room) {
        return [
            'id' => $room->id,
            'room_number' => $room->room_number,
            'room_type' => $room->room_type,
            'price' => $room->price,
            'capacity' => $room->capacity,
            'bed_type' => $room->bed_type,
            'size' => $room->size,
            'description' => $room->description,
            'images' => $room->images ? json_decode($room->images) : [],
            'amenities' => $room->amenities ? json_decode($room->amenities) : [],
        ];
    });

    return Inertia::render('Frontend/RoomListing', [
        'rooms' => $rooms,
        'filters' => $appliedFilters, // Pass only the applied filters
    ]);
}

// public function show($id)
// {
//     try {
//         $room = Room::findOrFail($id);
        
//         // Fix image paths - ensure they're absolute URLs
//         $images = [];
//         if ($room->images) {
//             $decodedImages = json_decode($room->images, true);
//             if (is_array($decodedImages)) {
//                 foreach ($decodedImages as $image) {
//                     // Ensure the image path is correct
//                     if (strpos($image, 'http') === 0) {
//                         $images[] = $image; // Already a full URL
//                     } else {
//                         $images[] = asset($image); // Convert to full URL
//                     }
//                 }
//             }
//         }
        
//         $roomData = [
//             'id' => $room->id,
//             'room_number' => $room->room_number ?? '',
//             'room_type' => $room->room_type ?? '',
//             'price' => $room->price ?? 0,
//             'capacity' => $room->capacity ?? 1,
//             'bed_type' => $room->bed_type ?? '',
//             'size' => $room->size ?? 0,
//             'description' => $room->description ?? '',
//             'images' => $images,
//             'amenities' => $room->amenities ? json_decode($room->amenities, true) : [],
//         ];

//         return Inertia::render('Frontend/RoomDetail', [
//             'room' => $roomData,
//         ]);
        
//     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
//         return Inertia::render('Frontend/RoomDetail', [
//             'room' => null,
//         ]);
//     }
// }

public function show($id)
{
    try {
        $room = Room::findOrFail($id);
        
        // Ensure all data is properly formatted
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
            'amenities' => [],
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

        // Safely decode amenities
        if ($room->amenities) {
            $decodedAmenities = json_decode($room->amenities, true);
            if (is_array($decodedAmenities)) {
                $roomData['amenities'] = $decodedAmenities;
            }
        }

        return Inertia::render('Frontend/RoomDetail', [
            'room' => $roomData,
        ]);
        
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return Inertia::render('Frontend/RoomDetail', [
            'room' => null,
        ]);
    }
}


}