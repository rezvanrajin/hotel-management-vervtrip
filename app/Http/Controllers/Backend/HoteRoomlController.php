<?php

namespace App\Http\Controllers\Backend;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HoteRoomlController extends Controller
{
    public function index()
    {
        return view('backend.pages.hotel_room.index');
    }

       public function getList(Request $request)
    {
         $data = Room::query()->orderBy('created_at', 'desc');
        
        if ($request->room_number) {
            $data->where(function($query) use ($request){
                $query->where('room_number','like', "%" .$request->room_number ."%" );
            });
        }

        if ($request->room_type) {
            $data->where(function($query) use ($request){
                $query->where('room_type','like', "%" .$request->room_type ."%" );
            });
        }

        if ($request->bed_type) {
            $data->where(function($query) use ($request){
                $query->where('bed_type','like', "%" .$request->bed_type ."%" );
            });
        }
        
        if ($request->status) {
            $data->where(function($query) use ($request){
                $query->where('status', $request->status);
            });
        }

        return DataTables::of($data)
            ->editColumn('room_type', function ($row) {
                return ucfirst($row->room_type);
            })
            
            ->editColumn('price', function ($row) {
                return '$' . number_format($row->price, 2);
            })
            
            ->editColumn('bed_type', function ($row) {
                return ucfirst($row->bed_type);
            })
            
            ->editColumn('status', function ($row) {
                if ($row->status == 'available') {
                    return '<span class="badge bg-success-200 text-success-700 rounded-pill w-80">Available</span>';
                } else if ($row->status == 'occupied') {
                    return '<span class="badge bg-primary-200 text-primary-700 rounded-pill w-80">Occupied</span>';
                } else if ($row->status == 'maintenance') {
                    return '<span class="badge bg-warning-200 text-warning-700 rounded-pill w-80">Maintenance</span>';
                } else if ($row->status == 'cleaning') {
                    return '<span class="badge bg-info-200 text-info-700 rounded-pill w-80">Cleaning</span>';
                } else {
                    return '<span class="badge bg-gray-200 text-gray-600 rounded-pill w-80">Unknown</span>';
                }
            })
            
            ->addColumn('action', function ($row) {
                $btn = '';
                      // if (Helper::hasRight('room.delete')) {
                      $btn .= '<a href="'.route('hotel.room.view', $row->id).'" class="view_btn btn btn-sm btn-info text-white-900" title="View Details"><i class="fa-solid fa-eye"></i></a>';
                // }
                // if (Helper::hasRight('room.edit')) {
                    $btn = $btn . '<a href="'.route('hotel.room.edit', $row->id).'" class="edit_btn btn btn-sm text-gray-900"><i class="fa-solid fa-pencil"></i></a>';
                // }
                // if (Helper::hasRight('room.delete')) {
                     $btn .= '<a class="delete_btn btn btn-sm btn-danger mx-1" data-id="'.$row->id.'" data-room-number="'.$row->room_number.'" href="#" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                // }
                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('backend.pages.hotel_room.create');

    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'room_number' => 'required|unique:rooms,room_number',
            'room_type' => 'required|in:single,double,twin,suite,deluxe,presidential',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1|max:10',
            'size' => 'nullable|numeric|min:0',
            'bed_type' => 'required|in:king,queen,double,twin,single',
            'status' => 'required|in:available,occupied,maintenance,cleaning',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create room record
            $room = Room::create([
                'room_number' => $request->room_number,
                'room_type' => $request->room_type,
                'price' => $request->price,
                'capacity' => $request->capacity,
                'size' => $request->size,
                'bed_type' => $request->bed_type,
                'status' => $request->status,
                'amenities' => $request->amenities ? json_encode($request->amenities) : null,
                'description' => $request->description,
            ]);

        if ($request->hasFile('images')) {
            $imagePaths = [];
            
            foreach ($request->file('images') as $image) {
                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Create directory if it doesn't exist
                $uploadPath = public_path('uploads/hotel_room');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Move uploaded file
                $image->move($uploadPath, $filename);
                
                // Store relative path for database
                $imagePaths[] = 'uploads/hotel_room/' . $filename;
            }
            
            // Save image paths to room
            $room->images = json_encode($imagePaths);
            $room->save();
        }


            return response()->json([
                'success' => true,
                'message' => 'Room created successfully!',
                'data' => $room
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create room',
                'error' => $e->getMessage()
            ], 500);
        }
    }
        public function edit($id){
            $room = Room::find($id);
            return view('backend.pages.hotel_room.edit', compact('room'));
      
    }
    public function update(Request $request, $id){
         $validator = Validator::make($request->all(), [
        'room_number' => 'required|unique:rooms,room_number,' . $id,
        'room_type' => 'required|in:single,double,twin,suite,deluxe,presidential',
        'price' => 'required|numeric|min:0',
        'capacity' => 'required|integer|min:1|max:10',
        'size' => 'nullable|numeric|min:0',
        'bed_type' => 'required|in:king,queen,double,twin,single',
        'status' => 'required|in:available,occupied,maintenance,cleaning',
        'amenities' => 'nullable|array',
        'amenities.*' => 'string',
        'description' => 'nullable|string',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'removed_images' => 'nullable|array'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $room = Room::findOrFail($id);

        $room->update([
            'room_number' => $request->room_number,
            'room_type' => $request->room_type,
            'price' => $request->price,
            'capacity' => $request->capacity,
            'size' => $request->size,
            'bed_type' => $request->bed_type,
            'status' => $request->status,
            'amenities' => $request->amenities ? json_encode($request->amenities) : null,
            'description' => $request->description,
        ]);

       $currentImages = $room->images ? json_decode($room->images, true) : [];
if ($request->removed_images) {
    foreach ($request->removed_images as $removedImage) {
        // Remove from public/uploads/hotel_room folder
        $imagePath = public_path('uploads/hotel_room/' . basename($removedImage));
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        // Remove from array
        $currentImages = array_diff($currentImages, [$removedImage]);
    }
}

if ($request->hasFile('images')) {
    $newImagePaths = [];
    
    foreach ($request->file('images') as $image) {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        
        // Create directory if it doesn't exist
        $uploadPath = public_path('uploads/hotel_room');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Move uploaded file
        $image->move($uploadPath, $filename);
        
        // Store relative path for database
        $newImagePaths[] = 'uploads/hotel_room/' . $filename;
    }
    
    $allImages = array_merge($currentImages, $newImagePaths);
    $room->images = json_encode($allImages);
    $room->save();
} else {
    $room->images = json_encode(array_values($currentImages));
    $room->save();
}
        return response()->json([
            'success' => true,
            'message' => 'Room updated successfully!',
            'data' => $room
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to update room',
            'error' => $e->getMessage()
        ], 500);
    }
    }
    public function view($id)
{
    $room = Room::findOrFail($id);
    
    // Decode JSON fields
    $room->amenities = $room->amenities ? json_decode($room->amenities, true) : [];
    $room->images = $room->images ? json_decode($room->images, true) : [];
    
    return view('backend.pages.hotel_room.view', compact('room'));
}
public function delete($id){

    try {
        $room = Room::findOrFail($id);
        
        // Check if room has any bookings
        $hasBookings = Booking::where('room_id', $id)->exists();
        
        if ($hasBookings) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete room. This room has existing bookings.'
            ], 422);
        }
        
     
        if ($room->images) {
            $images = json_decode($room->images, true);
            foreach ($images as $image) {
                $imagePath = public_path($image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }
        
        // Delete the room
        $room->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Room deleted successfully'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error deleting room: ' . $e->getMessage()
        ], 500);
    }
}
}
