import React, { useState, useEffect } from 'react';
import { useForm } from '@inertiajs/react';
import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';

const SearchForm = ({ showClearButton = false, onClearFilters = () => {} }) => {
    const [checkInDate, setCheckInDate] = useState(null);
    const [checkOutDate, setCheckOutDate] = useState(null);

    const { data, setData, get } = useForm({
        check_in: '',
        check_out: '',
        guests: 1,
        room_type: '',
    });

    useEffect(() => {
        const urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.has('check_in')) {
            const checkIn = new Date(urlParams.get('check_in'));
            setCheckInDate(checkIn);
            setData('check_in', urlParams.get('check_in'));
        }
        
        if (urlParams.has('check_out')) {
            const checkOut = new Date(urlParams.get('check_out'));
            setCheckOutDate(checkOut);
            setData('check_out', urlParams.get('check_out'));
        }
        
        if (urlParams.has('guests')) {
            setData('guests', parseInt(urlParams.get('guests')));
        }
        
        if (urlParams.has('room_type')) {
            setData('room_type', urlParams.get('room_type'));
        }
    }, []);

    const submit = (e) => {
        e.preventDefault();
        get(route('rooms.index'), {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const clearFilters = () => {
        setCheckInDate(null);
        setCheckOutDate(null);
        setData({
            check_in: '',
            check_out: '',
            guests: 1,
            room_type: '',
        });
        onClearFilters();
    };

    return (
        <div className="bg-white rounded-2xl shadow-2xl p-6 mb-8">
            <div className="flex justify-between items-center mb-6">
                <h2 className="text-2xl font-bold text-gray-800">Find Your Perfect Room</h2>
                {showClearButton && (
                    <button
                        type="button"
                        onClick={clearFilters}
                        className="text-red-600 hover:text-red-800 font-semibold text-sm"
                    >
                        Clear Filters
                    </button>
                )}
            </div>
            
            <form onSubmit={submit} className="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Check In</label>
                    <DatePicker
                        selected={checkInDate}
                        onChange={(date) => {
                            setCheckInDate(date);
                            setData('check_in', date ? date.toISOString().split('T')[0] : '');
                        }}
                        selectsStart
                        startDate={checkInDate}
                        endDate={checkOutDate}
                        minDate={new Date()}
                        placeholderText="Select date"
                        className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        required
                    />
                </div>
                
                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Check Out</label>
                    <DatePicker
                        selected={checkOutDate}
                        onChange={(date) => {
                            setCheckOutDate(date);
                            setData('check_out', date ? date.toISOString().split('T')[0] : '');
                        }}
                        selectsEnd
                        startDate={checkInDate}
                        endDate={checkOutDate}
                        minDate={checkInDate || new Date()}
                        placeholderText="Select date"
                        className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        required
                    />
                </div>
                
                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Guests</label>
                    <select
                        value={data.guests}
                        onChange={(e) => setData('guests', e.target.value)}
                        className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    >
                        {[1, 2, 3, 4, 5, 6].map(num => (
                            <option key={num} value={num}>{num} {num === 1 ? 'Guest' : 'Guests'}</option>
                        ))}
                    </select>
                </div>
                
                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Room Type</label>
                    <select
                        value={data.room_type}
                        onChange={(e) => setData('room_type', e.target.value)}
                        className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    >
                        <option value="">All Types</option>
                        <option value="single">Single</option>
                        <option value="double">Double</option>
                        <option value="twin">Twin</option>
                        <option value="suite">Suite</option>
                        <option value="deluxe">Deluxe</option>
                        <option value="presidential">Presidential</option>
                    </select>
                </div>
                
                <div className="md:col-span-4">
                    <button
                        type="submit"
                        className="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg hover:bg-indigo-700 transition duration-300 font-semibold"
                    >
                        Search Rooms
                    </button>
                </div>
            </form>
        </div>
    );
};

export default SearchForm;