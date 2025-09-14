import React, { useState, useEffect } from 'react';
import FrontendLayout from '../../Layouts/FrontendLayout';
import { Head, useForm, usePage } from '@inertiajs/react';
import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';

const Booking = () => {
    const { room, user, currencies, errors: pageErrors } = usePage().props;
    
    // Handle missing data gracefully
    if (!room || typeof room !== 'object') {
        return (
            <FrontendLayout>
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div className="text-center py-12">
                        <div className="text-6xl mb-4">❌</div>
                        <h2 className="text-2xl font-bold text-gray-800 mb-4">Room Not Found</h2>
                        <p className="text-gray-600 mb-6">The room you're trying to book doesn't exist.</p>
                        <a
                            href="/rooms"
                            className="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700"
                        >
                            Browse Rooms
                        </a>
                    </div>
                </div>
            </FrontendLayout>
        );
    }

    const { data, setData, post, processing, errors } = useForm({
        room_id: room.id,
        check_in_date: '',
        check_out_date: '',
        number_of_guests: 1,
        number_of_rooms: 1,
        
        // Guest information
        guest_first_name: user?.first_name || '',
        guest_last_name: user?.last_name || '',
        guest_email: user?.email || '',
        guest_phone: user?.phone || '',
        guest_address: '',
        guest_country: '',
        guest_city: '',
        guest_zip_code: '',
        
        // Payment
        payment_method: 'credit_card',
        currency: 'USD',
        
        special_requests: '',
    });

    const [checkInDate, setCheckInDate] = useState(null);
    const [checkOutDate, setCheckOutDate] = useState(null);
    const [numberOfNights, setNumberOfNights] = useState(0);
    const [convertedPrice, setConvertedPrice] = useState(room.price || 0);
    const [allErrors, setAllErrors] = useState({});

    // Combine errors from useForm and page props
    useEffect(() => {
        setAllErrors({...errors, ...pageErrors});
    }, [errors, pageErrors]);

    useEffect(() => {
        if (checkInDate && checkOutDate) {
            const nights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
            setNumberOfNights(nights);
            calculatePrice(nights, data.currency);
        }
    }, [checkInDate, checkOutDate, data.currency, data.number_of_rooms]);

    const calculatePrice = (nights, currency) => {
        const exchangeRates = {
            USD: 1.0,
            EUR: 0.85,
            GBP: 0.75,
            INR: 75.0
        };
        
        const converted = (room.price || 0) * (exchangeRates[currency] || 1);
        setConvertedPrice(converted);
    };

    const handleCurrencyChange = (currency) => {
        setData('currency', currency);
        calculatePrice(numberOfNights, currency);
    };

    const submit = (e) => {
        e.preventDefault();
        
        // Format dates properly before submission
        const formattedData = {
            ...data,
            check_in_date: checkInDate ? checkInDate.toISOString().split('T')[0] : '',
            check_out_date: checkOutDate ? checkOutDate.toISOString().split('T')[0] : '',
        };
        
        post(route('booking.store'), {
            data: formattedData,
            onError: (errors) => {
                console.log('Form errors:', errors);
                setAllErrors(errors);
            },
            onSuccess: () => {
                console.log('Booking created successfully');
            }
        });
    };

    const totalAmount = convertedPrice * numberOfNights * data.number_of_rooms;
    const taxAmount = totalAmount * 0.1;
    const grandTotal = totalAmount + taxAmount;

    const roomImages = Array.isArray(room.images) ? room.images : [];
    const mainImage = roomImages.length > 0 ? roomImages[0] : '/images/room-placeholder.jpg';

    return (
        <FrontendLayout>
            <Head>
                <title>{`Book ${room.room_type || 'Room'} - Hotel Paradise`}</title>
                <meta name="description" content={`Book ${room.room_type || 'Room'} at Hotel Paradise. ${room.description || 'Luxurious accommodations with modern amenities.'}`} />
            </Head>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {/* Display all errors at the top */}
                {Object.keys(allErrors).length > 0 && (
                    <div className="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <h3 className="text-red-800 font-semibold mb-2">Please fix the following errors:</h3>
                        <ul className="list-disc list-inside text-red-600">
                            {Object.keys(allErrors).map((key) => (
                                <li key={key}>{allErrors[key]}</li>
                            ))}
                        </ul>
                    </div>
                )}

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {/* Booking Form */}
                    <div className="lg:col-span-2">
                        <div className="bg-white rounded-2xl shadow-xl p-6 mb-8">
                            <h1 className="text-3xl font-bold text-gray-800 mb-6">Complete Your Booking</h1>
                            
                            <form onSubmit={submit} className="space-y-6">
                                {/* Personal Information */}
                                <div>
                                    <h2 className="text-xl font-semibold mb-4">Personal Information</h2>
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                First Name *
                                            </label>
                                            <input
                                                type="text"
                                                value={data.guest_first_name}
                                                onChange={e => setData('guest_first_name', e.target.value)}
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                required
                                            />
                                            {allErrors.guest_first_name && <p className="text-red-500 text-sm mt-1">{allErrors.guest_first_name}</p>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Last Name *
                                            </label>
                                            <input
                                                type="text"
                                                value={data.guest_last_name}
                                                onChange={e => setData('guest_last_name', e.target.value)}
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                required
                                            />
                                            {allErrors.guest_last_name && <p className="text-red-500 text-sm mt-1">{allErrors.guest_last_name}</p>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Email *
                                            </label>
                                            <input
                                                type="email"
                                                value={data.guest_email}
                                                onChange={e => setData('guest_email', e.target.value)}
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                required
                                            />
                                            {allErrors.guest_email && <p className="text-red-500 text-sm mt-1">{allErrors.guest_email}</p>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Phone
                                            </label>
                                            <input
                                                type="tel"
                                                value={data.guest_phone}
                                                onChange={e => setData('guest_phone', e.target.value)}
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            />
                                            {allErrors.guest_phone && <p className="text-red-500 text-sm mt-1">{allErrors.guest_phone}</p>}
                                        </div>
                                    </div>
                                </div>

                                {/* Booking Details */}
                                <div>
                                    <h2 className="text-xl font-semibold mb-4">Booking Details</h2>
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Check-in Date *
                                            </label>
                                            <DatePicker
                                                selected={checkInDate}
                                                onChange={(date) => {
                                                    setCheckInDate(date);
                                                    setData('check_in_date', date ? date.toISOString().split('T')[0] : '');
                                                }}
                                                minDate={new Date()}
                                                placeholderText="Select date"
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                required
                                            />
                                            {allErrors.check_in_date && <p className="text-red-500 text-sm mt-1">{allErrors.check_in_date}</p>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Check-out Date *
                                            </label>
                                            <DatePicker
                                                selected={checkOutDate}
                                                onChange={(date) => {
                                                    setCheckOutDate(date);
                                                    setData('check_out_date', date ? date.toISOString().split('T')[0] : '');
                                                }}
                                                minDate={checkInDate || new Date()}
                                                placeholderText="Select date"
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                required
                                            />
                                            {allErrors.check_out_date && <p className="text-red-500 text-sm mt-1">{allErrors.check_out_date}</p>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Number of Guests *
                                            </label>
                                            <select
                                                value={data.number_of_guests}
                                                onChange={e => setData('number_of_guests', e.target.value)}
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                            >
                                                {[...Array(room.capacity || 6)].map((_, i) => (
                                                    <option key={i + 1} value={i + 1}>{i + 1} Guest{i + 1 > 1 ? 's' : ''}</option>
                                                ))}
                                            </select>
                                            {allErrors.number_of_guests && <p className="text-red-500 text-sm mt-1">{allErrors.number_of_guests}</p>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Number of Rooms *
                                            </label>
                                            <input
                                                type="number"
                                                min="1"
                                                value={data.number_of_rooms}
                                                onChange={e => setData('number_of_rooms', e.target.value)}
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                required
                                            />
                                            {allErrors.number_of_rooms && <p className="text-red-500 text-sm mt-1">{allErrors.number_of_rooms}</p>}
                                        </div>
                                    </div>
                                </div>

                                {/* Payment Information */}
                                <div>
                                    <h2 className="text-xl font-semibold mb-4">Payment Information</h2>
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Currency *
                                            </label>
                                            <select
                                                value={data.currency}
                                                onChange={e => handleCurrencyChange(e.target.value)}
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                required
                                            >
                                                {Object.entries(currencies || {}).map(([code, currency]) => (
                                                    <option key={code} value={code}>
                                                        {currency.name} ({currency.symbol})
                                                    </option>
                                                ))}
                                            </select>
                                            {allErrors.currency && <p className="text-red-500 text-sm mt-1">{allErrors.currency}</p>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Payment Method *
                                            </label>
                                            <select
                                                value={data.payment_method}
                                                onChange={e => setData('payment_method', e.target.value)}
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                                required
                                            >
                                                <option value="credit_card">Credit Card</option>
                                                <option value="debit_card">Debit Card</option>
                                                <option value="paypal">PayPal</option>
                                                <option value="bank_transfer">Bank Transfer</option>
                                            </select>
                                            {allErrors.payment_method && <p className="text-red-500 text-sm mt-1">{allErrors.payment_method}</p>}
                                        </div>
                                    </div>
                                </div>

                                {/* Special Requests */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Special Requests
                                    </label>
                                    <textarea
                                        value={data.special_requests}
                                        onChange={e => setData('special_requests', e.target.value)}
                                        rows="4"
                                        className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                        placeholder="Any special requests or requirements..."
                                    />
                                    {allErrors.special_requests && <p className="text-red-500 text-sm mt-1">{allErrors.special_requests}</p>}
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full bg-indigo-600 text-white py-4 px-6 rounded-lg hover:bg-indigo-700 transition duration-300 font-semibold text-lg disabled:opacity-50"
                                >
                                    {processing ? 'Processing...' : 'Proceed to Payment'}
                                </button>
                            </form>
                        </div>
                    </div>

                    {/* Order Summary */}
                    <div className="lg:col-span-1">
                        <div className="bg-white rounded-2xl shadow-xl p-6 sticky top-8">
                            <h2 className="text-xl font-semibold mb-4">Order Summary</h2>
                            
                            <div className="mb-4">
                                <img
                                    src={mainImage}
                                    alt={room.room_type || 'Room'}
                                    className="w-full h-48 object-cover rounded-lg mb-4"
                                    onError={(e) => {
                                        e.target.src = '/images/room-placeholder.jpg';
                                    }}
                                />
                                <h3 className="font-semibold text-lg">{room.room_type || 'Room'} Room</h3>
                                <p className="text-gray-600">Room #{room.room_number || 'N/A'}</p>
                            </div>

                            <div className="space-y-3 border-t border-gray-200 pt-4">
                                <div className="flex justify-between">
                                    <span>{convertedPrice.toFixed(2)} {data.currency} × {numberOfNights} nights × {data.number_of_rooms} rooms</span>
                                    <span>{totalAmount.toFixed(2)} {data.currency}</span>
                                </div>
                                <div className="flex justify-between text-sm text-gray-600">
                                    <span>Tax (10%)</span>
                                    <span>{taxAmount.toFixed(2)} {data.currency}</span>
                                </div>
                                <div className="flex justify-between font-semibold text-lg border-t border-gray-200 pt-3">
                                    <span>Total</span>
                                    <span>{grandTotal.toFixed(2)} {data.currency}</span>
                                </div>
                            </div>

                            <div className="mt-6 p-4 bg-blue-50 rounded-lg">
                                <h4 className="font-semibold mb-2">Cancellation Policy</h4>
                                <p className="text-sm text-gray-600">
                                    Free cancellation up to 24 hours before check-in. No refund for cancellations made less than 24 hours before check-in.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </FrontendLayout>
    );
};

export default Booking;