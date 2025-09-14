import React from 'react';
import { Link } from '@inertiajs/react';

const RoomCard = ({ room }) => {
    const mainImage = room.images && room.images.length > 0 ? room.images[0] : '/images/room-placeholder.jpg';

    const getRoomTypeDisplay = (roomType) => {
        const typeMap = {
            'single': 'Single Room',
            'double': 'Double Room',
            'twin': 'Twin Room',
            'suite': 'Luxury Suite',
            'deluxe': 'Deluxe Room',
            'presidential': 'Presidential Suite'
        };
        return typeMap[roomType] || roomType;
    };

    return (
        <div className="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
            <div className="relative h-48 overflow-hidden">
                <img
                    src={mainImage}
                    alt={getRoomTypeDisplay(room.room_type)}
                    className="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                    onError={(e) => {
                        e.target.src = '/images/room-placeholder.jpg';
                    }}
                />
                <div className="absolute top-4 right-4 bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    ${room.price}/night
                </div>
                <div className="absolute bottom-4 left-4 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-sm">
                    Room #{room.room_number}
                </div>
            </div>
            
            <div className="p-6">
                <h3 className="text-xl font-bold text-gray-800 mb-2">{getRoomTypeDisplay(room.room_type)}</h3>
                
                <div className="grid grid-cols-2 gap-4 mb-4">
                    <div className="flex items-center text-sm">
                        <span className="text-gray-600 mr-2">👥</span>
                        <span>{room.capacity} Guest{room.capacity > 1 ? 's' : ''}</span>
                    </div>
                    <div className="flex items-center text-sm">
                        <span className="text-gray-600 mr-2">🛏️</span>
                        <span className="capitalize">{room.bed_type}</span>
                    </div>
                    <div className="flex items-center text-sm">
                        <span className="text-gray-600 mr-2">📏</span>
                        <span>{room.size} sq ft</span>
                    </div>
                </div>
                
                {room.amenities && room.amenities.length > 0 && (
                    <div className="mb-4">
                        <h4 className="font-semibold text-gray-700 mb-2 text-sm">Key Amenities:</h4>
                        <div className="flex flex-wrap gap-1">
                            {room.amenities.slice(0, 3).map((amenity, index) => (
                                <span key={index} className="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">
                                    {amenity}
                                </span>
                            ))}
                            {room.amenities.length > 3 && (
                                <span className="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">
                                    +{room.amenities.length - 3} more
                                </span>
                            )}
                        </div>
                    </div>
                )}
                
                <div className="flex justify-between items-center mt-4">
                    <Link
                        href={route('rooms.show', room.id)}
                        className="text-indigo-600 hover:text-indigo-800 font-semibold text-sm"
                    >
                        View Details →
                    </Link>
                    <Link
                        href={route('booking.create', room.id)}
                        className="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300 text-sm font-semibold"
                    >
                        Book Now
                    </Link>
                </div>
            </div>
        </div>
    );
};

export default RoomCard;