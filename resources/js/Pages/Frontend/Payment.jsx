import React, { useState } from 'react';
import FrontendLayout from '../../Layouts/FrontendLayout';
import { Head, useForm, usePage } from '@inertiajs/react';

const Payment = ({ booking }) => {
    const { post, processing } = useForm();

    const [cardDetails, setCardDetails] = useState({
        cardNumber: '',
        expiryDate: '',
        cvv: '',
        cardHolder: ''
    });

    const processPayment = () => {
        post(route('booking.process-payment', booking.id));
    };

    return (
        <FrontendLayout>
            <Head>
                <title>Payment - Hotel Paradise</title>
            </Head>

            <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div className="bg-white rounded-2xl shadow-xl p-8">
                    <div className="text-center mb-8">
                        <h1 className="text-3xl font-bold text-gray-800 mb-2">Payment Details</h1>
                        <p className="text-gray-600">Complete your booking by providing payment information</p>
                    </div>

                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        {/* Payment Form */}
                        <div>
                            <div className="bg-gray-50 p-6 rounded-lg mb-6">
                                <h2 className="text-lg font-semibold mb-4">Booking Summary</h2>
                                <div className="space-y-2">
                                    <p><strong>Room:</strong> {booking.room.room_type} #{booking.room.room_number}</p>
                                    <p><strong>Check-in:</strong> {booking.check_in_date}</p>
                                    <p><strong>Check-out:</strong> {booking.check_out_date}</p>
                                    <p><strong>Guests:</strong> {booking.number_of_guests}</p>
                                    <p><strong>Total:</strong> {booking.total_amount} {booking.currency}</p>
                                </div>
                            </div>

                            <div className="bg-yellow-50 border border-yellow-200 p-4 rounded-lg mb-6">
                                <h3 className="font-semibold text-yellow-800 mb-2">⚠️ Simulation Only</h3>
                                <p className="text-yellow-700 text-sm">
                                    This is a simulated payment system. No real payment will be processed.
                                    Click "Pay Now" to complete the booking simulation.
                                </p>
                            </div>

                            <div className="bg-white p-6 rounded-lg border border-gray-200">
                                <h2 className="text-xl font-semibold mb-4">Payment Method: {booking.payment_method}</h2>
                                
                                {booking.payment_method.includes('card') && (
                                    <div className="space-y-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Card Number
                                            </label>
                                            <input
                                                type="text"
                                                placeholder="4242 4242 4242 4242"
                                                value={cardDetails.cardNumber}
                                                onChange={e => setCardDetails({...cardDetails, cardNumber: e.target.value})}
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                            />
                                        </div>
                                        <div className="grid grid-cols-2 gap-4">
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                                    Expiry Date
                                                </label>
                                                <input
                                                    type="text"
                                                    placeholder="MM/YY"
                                                    value={cardDetails.expiryDate}
                                                    onChange={e => setCardDetails({...cardDetails, expiryDate: e.target.value})}
                                                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                                />
                                            </div>
                                            <div>
                                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                                    CVV
                                                </label>
                                                <input
                                                    type="text"
                                                    placeholder="123"
                                                    value={cardDetails.cvv}
                                                    onChange={e => setCardDetails({...cardDetails, cvv: e.target.value})}
                                                    className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                                />
                                            </div>
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                                Card Holder Name
                                            </label>
                                            <input
                                                type="text"
                                                placeholder="John Doe"
                                                value={cardDetails.cardHolder}
                                                onChange={e => setCardDetails({...cardDetails, cardHolder: e.target.value})}
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                            />
                                        </div>
                                    </div>
                                )}

                                <button
                                    onClick={processPayment}
                                    disabled={processing}
                                    className="w-full bg-indigo-600 text-white py-4 px-6 rounded-lg hover:bg-indigo-700 transition duration-300 font-semibold text-lg disabled:opacity-50 mt-6"
                                >
                                    {processing ? 'Processing...' : 'Pay Now'}
                                </button>
                            </div>
                        </div>

                        {/* Order Summary */}
                        <div>
                            <div className="bg-gray-50 p-6 rounded-lg sticky top-8">
                                <h2 className="text-xl font-semibold mb-4">Order Summary</h2>
                                
                                <div className="space-y-3">
                                    <div className="flex justify-between">
                                        <span>Room Price</span>
                                        <span>{booking.room_price_per_night} {booking.currency} × {booking.number_of_nights} nights</span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span>Number of Rooms</span>
                                        <span>{booking.number_of_rooms}</span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span>Subtotal</span>
                                        <span>{booking.sub_total} {booking.currency}</span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span>Tax (10%)</span>
                                        <span>{booking.tax_amount} {booking.currency}</span>
                                    </div>
                                    <div className="flex justify-between font-semibold text-lg border-t border-gray-200 pt-3">
                                        <span>Total Amount</span>
                                        <span>{booking.total_amount} {booking.currency}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </FrontendLayout>
    );
};

export default Payment;