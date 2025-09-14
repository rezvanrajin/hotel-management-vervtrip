import React from 'react';
import FrontendLayout from '../../Layouts/FrontendLayout';
import RoomGrid from '../../Components/Frontend/RoomGrid';
import SearchForm from '../../Components/Frontend/SearchForm';
import { Head, Link } from '@inertiajs/react';

const RoomListing = ({ rooms, filters }) => {
    const hasActiveFilters = filters.check_in || filters.room_type || filters.guests;

    const handleClearFilters = () => {
        // This will be called when the clear button in SearchForm is clicked
        window.location.href = route('rooms.index');
    };

    return (
        <FrontendLayout>
            <Head>
                <title>Available Rooms - Hotel Paradise</title>
            </Head>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {/* Search Form at the top */}
                <SearchForm 
                    showClearButton={hasActiveFilters} 
                    onClearFilters={handleClearFilters}
                />

                {/* Results header */}
                <div className="mb-8">
                    <div className="flex justify-between items-center mb-4">
                        <h1 className="text-3xl font-bold text-gray-800">Available Rooms</h1>
                        {hasActiveFilters && (
                            <Link
                                href={route('rooms.index')}
                                className="text-red-600 hover:text-red-800 font-semibold"
                            >
                                Clear All Filters
                            </Link>
                        )}
                    </div>
                    
                    {hasActiveFilters && (
                        <div className="bg-gray-50 p-4 rounded-lg">
                            <h3 className="font-semibold text-gray-700 mb-2">Active Filters:</h3>
                            <div className="flex flex-wrap gap-2">
                                {filters.check_in && filters.check_out && (
                                    <span className="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm">
                                        📅 {filters.check_in} to {filters.check_out}
                                    </span>
                                )}
                                {filters.guests && (
                                    <span className="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                        👥 {filters.guests} Guest{filters.guests > 1 ? 's' : ''}
                                    </span>
                                )}
                                {filters.room_type && (
                                    <span className="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">
                                        🏨 {filters.room_type.charAt(0).toUpperCase() + filters.room_type.slice(1)} Room
                                    </span>
                                )}
                            </div>
                        </div>
                    )}
                </div>

                {/* Results count */}
                <div className="mb-6">
                    <p className="text-gray-600">
                        Found {rooms.length} room{rooms.length !== 1 ? 's' : ''} matching your criteria
                    </p>
                </div>

                <RoomGrid rooms={rooms} />
                
                {rooms.length === 0 && (
                    <div className="text-center py-12">
                        <div className="bg-gray-100 rounded-lg p-8">
                            <div className="text-6xl mb-4">🔍</div>
                            <h3 className="text-xl font-semibold text-gray-700 mb-2">No rooms found</h3>
                            <p className="text-gray-500 mb-4">Try adjusting your search criteria</p>
                            <Link
                                href={route('rooms.index')}
                                className="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700"
                            >
                                Clear Filters
                            </Link>
                        </div>
                    </div>
                )}
            </div>
        </FrontendLayout>
    );
};

export default RoomListing;