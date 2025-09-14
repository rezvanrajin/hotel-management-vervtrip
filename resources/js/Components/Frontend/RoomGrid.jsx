import React from 'react';
import RoomCard from './RoomCard';

const RoomGrid = ({ rooms }) => {
    if (!rooms || rooms.length === 0) {
        return (
            <div className="text-center py-12">
                <div className="bg-gray-100 rounded-lg p-8">
                    <div className="text-6xl mb-4">🏨</div>
                    <h3 className="text-xl font-semibold text-gray-700 mb-2">No Rooms Available</h3>
                    <p className="text-gray-500">Please try different search criteria.</p>
                </div>
            </div>
        );
    }

    return (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {rooms.map((room) => (
                <RoomCard key={room.id} room={room} />
            ))}
        </div>
    );
};

export default RoomGrid;