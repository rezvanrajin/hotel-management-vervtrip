<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
       $featuredRooms = Room::where('status', 'available')
    ->take(6)
    ->get()
    ->map(function ($room) {
        return [
            'id' => $room->id,
            'room_number' => $room->room_number,
            'room_type' => $room->room_type,
            'price' => $room->price,
            'capacity' => $room->capacity,
            'bed_type' => $room->bed_type,
            'size' => $room->size,
            'images' => $room->images ? json_decode($room->images) : [],
            'amenities' => $room->amenities ? json_decode($room->amenities) : [],
        ];
    });

return Inertia::render('Frontend/Home', [
    'featuredRooms' => $featuredRooms,
]);
    }
}