import React from 'react';
import FrontendLayout from '../../Layouts/FrontendLayout';
import { Head, Link } from '@inertiajs/react';

const RoomDetail = ({ room }) => {
    // Extreme null checking - handle all possible undefined scenarios
    if (!room || typeof room !== 'object' || Object.keys(room).length === 0) {
        return (
            <FrontendLayout>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div className="text-center py-12">
                        <div className="text-6xl mb-4">❌</div>
                        <h2 className="text-2xl font-bold text-gray-800 mb-4">Room Not Found</h2>
                        <p className="text-gray-600 mb-6">The room you're looking for doesn't exist.</p>
                        <Link
                            href={route('rooms.index')}
                            className="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700"
                        >
                            Back to Rooms
                        </Link>
                    </div>
                </div>
            </FrontendLayout>
        );
    }

    // Safe property access with defaults
    const roomImages = Array.isArray(room.images) ? room.images : [];
    const mainImage = roomImages.length > 0 ? roomImages[0] : '/images/room-placeholder.jpg';
    const roomAmenities = Array.isArray(room.amenities) ? room.amenities : [];

    const getRoomTypeDisplay = (roomType) => {
        if (!roomType) return 'Room';
        
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

    const roomTypeDisplay = getRoomTypeDisplay(room.room_type || '');

    return (
        <FrontendLayout>
            {/* Safe Head component usage */}
            {roomTypeDisplay && (
                <Head>
                    <title>{`${roomTypeDisplay} - Hotel Paradise`}</title>
                    <meta name="description" content={`Book ${roomTypeDisplay} at Hotel Paradise. ${room.description || 'Luxurious accommodations with modern amenities.'}`} />
                </Head>
            )}

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {/* Breadcrumb */}
                <nav className="mb-6">
                    <ol className="flex items-center space-x-2 text-sm text-gray-600">
                        <li>
                            <Link href="/" className="hover:text-indigo-600">Home</Link>
                        </li>
                        <li className="before:content-['/'] before:mx-2">
                            <Link href="/rooms" className="hover:text-indigo-600">Rooms</Link>
                        </li>
                        <li className="before:content-['/'] before:mx-2">
                            <span className="text-gray-800">{roomTypeDisplay}</span>
                        </li>
                    </ol>
                </nav>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {/* Room Images */}
                    <div>
                        <div className="rounded-2xl overflow-hidden mb-4">
                            <img
                                src={mainImage}
                                alt={roomTypeDisplay}
                                className="w-full h-96 object-cover"
                                onError={(e) => {
                                    e.target.src = '/images/room-placeholder.jpg';
                                }}
                            />
                        </div>
                        {roomImages.length > 1 && (
                            <div className="grid grid-cols-3 gap-2">
                                {roomImages.slice(1, 4).map((image, index) => (
                                    <img
                                        key={index}
                                        src={image}
                                        alt={`${roomTypeDisplay} ${index + 2}`}
                                        className="w-full h-24 object-cover rounded-lg cursor-pointer hover:opacity-80"
                                        onError={(e) => {
                                            e.target.src = '/images/room-placeholder.jpg';
                                        }}
                                    />
                                ))}
                            </div>
                        )}
                    </div>

                    {/* Room Details */}
                    <div>
                        <h1 className="text-3xl font-bold text-gray-800 mb-2">
                            {roomTypeDisplay}
                        </h1>
                        <p className="text-gray-600 mb-4">Room #{room.room_number || 'N/A'}</p>

                        <div className="bg-indigo-50 p-4 rounded-lg mb-6">
                            <div className="text-2xl font-bold text-indigo-600 mb-2">
                                ${room.price || '0'} <span className="text-sm font-normal text-gray-600">per night</span>
                            </div>
                            <Link
                                href={route('booking.create', room.id)}
                                className="block w-full bg-indigo-600 text-white text-center py-3 rounded-lg hover:bg-indigo-700 transition duration-300 font-semibold"
                            >
                                Book Now
                            </Link>
                        </div>

                        <div className="grid grid-cols-2 gap-4 mb-6">
                            <div className="flex items-center">
                                <span className="text-gray-600 mr-2">👥</span>
                                <span><strong>Capacity:</strong> {room.capacity || '1'} Guest{room.capacity > 1 ? 's' : ''}</span>
                            </div>
                            <div className="flex items-center">
                                <span className="text-gray-600 mr-2">🛏️</span>
                                <span><strong>Bed Type:</strong> {(room.bed_type || '').charAt(0).toUpperCase() + (room.bed_type || '').slice(1)}</span>
                            </div>
                            <div className="flex items-center">
                                <span className="text-gray-600 mr-2">📏</span>
                                <span><strong>Size:</strong> {room.size || '0'} sq ft</span>
                            </div>
                        </div>

               {room.description && (
    <div className="mb-6">
        <h3 className="text-xl font-semibold mb-3">Description</h3>
        <p
            className="text-gray-700 leading-relaxed"
            dangerouslySetInnerHTML={{ __html: room.description }}
        />
    </div>
)}

                        {roomAmenities.length > 0 && (
                            <div className="mb-6">
                                <h3 className="text-xl font-semibold mb-3">Amenities</h3>
                                <div className="grid grid-cols-2 gap-3">
                                    {roomAmenities.map((amenity, index) => (
                                        <div key={index} className="flex items-center">
                                            <span className="text-green-500 mr-2">✓</span>
                                            <span className="text-gray-700">{amenity}</span>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </FrontendLayout>
    );
};

export default RoomDetail;