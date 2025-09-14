import React, { useEffect } from 'react';
import FrontendLayout from '../../Layouts/FrontendLayout';
import { Head, Link } from '@inertiajs/react';

const Confirmation = ({ booking, success }) => {
    useEffect(() => {
        if (success) {
            // Show success toast notification
            console.log('Booking successful:', success);
        }
    }, [success]);

    const printConfirmation = () => {
        const printContent = `
            <div style="padding: 20px; font-family: Arial, sans-serif;">
                <h1 style="text-align: center; color: #4F46E5;">Hotel Paradise</h1>
                <h2 style="text-align: center;">Booking Confirmation</h2>
                <hr>
                <p><strong>Booking ID:</strong> #${booking.id}</p>
                <p><strong>Transaction ID:</strong> ${booking.transaction_id}</p>
                <p><strong>Guest:</strong> ${booking.guest_first_name} ${booking.guest_last_name}</p>
                <p><strong>Room:</strong> ${booking.room.room_type} #${booking.room.room_number}</p>
                <p><strong>Check-in:</strong> ${new Date(booking.check_in_date).toLocaleDateString()}</p>
                <p><strong>Check-out:</strong> ${new Date(booking.check_out_date).toLocaleDateString()}</p>
                <p><strong>Nights:</strong> ${booking.number_of_nights}</p>
                <p><strong>Guests:</strong> ${booking.number_of_guests}</p>
                <p><strong>Total Amount:</strong> ${booking.total_amount} ${booking.currency}</p>
                <p><strong>Status:</strong> ${booking.status}</p>
                <hr>
                <p style="text-align: center; margin-top: 30px;">Thank you for choosing Hotel Paradise!</p>
            </div>
        `;
        
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Booking Confirmation - ${booking.transaction_id}</title>
                    <style>
                        @media print {
                            body { margin: 0; }
                        }
                    </style>
                </head>
                <body onload="window.print();">${printContent}</body>
            </html>
        `);
        printWindow.document.close();
    };



    return (
        <FrontendLayout>
            <Head>
                <title>Booking Confirmation - Hotel Paradise</title>
            </Head>

            <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div className="bg-white rounded-2xl shadow-xl p-8 text-center">
                    {success && (
                        <div className="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {success}
                        </div>
                    )}
                    
                    <div className="mb-6">
                        <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg className="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h1 className="text-3xl font-bold text-gray-800 mb-2">Booking Confirmed!</h1>
                        <p className="text-gray-600">Your reservation has been successfully completed</p>
                    </div>

                    <div className="bg-gray-50 p-6 rounded-lg mb-6">
                        <h2 className="text-xl font-semibold mb-4">Booking Details</h2>
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                            <div>
                                <p><strong>Booking ID:</strong> #{booking.id}</p>
                                <p><strong>Room:</strong> {booking.room.room_type} #{booking.room.room_number}</p>
                                <p><strong>Check-in:</strong> {new Date(booking.check_in_date).toLocaleDateString()}</p>
                                <p><strong>Check-out:</strong> {new Date(booking.check_out_date).toLocaleDateString()}</p>
                            </div>
                            <div>
                                <p><strong>Guests:</strong> {booking.number_of_guests}</p>
                                <p><strong>Nights:</strong> {booking.number_of_nights}</p>
                                <p><strong>Total Amount:</strong> {booking.total_amount} {booking.currency}</p>
                                <p><strong>Status:</strong> <span className="text-green-600 font-semibold">{booking.status}</span></p>
                            </div>
                        </div>
                    </div>

                    <div className="bg-blue-50 p-6 rounded-lg mb-6">
                        <h2 className="text-lg font-semibold mb-2">What's Next?</h2>
                        <p className="text-gray-700 mb-4">
                            A confirmation email has been sent to your email address. 
                            Please present your ID at check-in.
                        </p>
                        <p className="text-sm text-gray-600">
                            Booking reference: {booking.transaction_id}
                        </p>
                    </div>

                    <div className="flex flex-col sm:flex-row gap-4 justify-center">
                        <Link
                            href="/"
                            className="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300"
                        >
                            Back to Home
                        </Link>
                        <Link
                            href="/rooms"
                            className="border border-indigo-600 text-indigo-600 px-6 py-3 rounded-lg hover:bg-indigo-50 transition duration-300"
                        >
                            Book Another Room
                        </Link>
                        <button
                                                      onClick={printConfirmation}
                            className="flex items-center justify-center gap-2 bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition duration-300"
                        >
                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m4 4h6a2 2 0 002-2v-4a2 2 0 00-2-2h-6a2 2 0 00-2 2v4a2 2 0 002 2z"></path>
                            </svg>
                            Print Confirmation

                        </button>
                    </div>
                </div>
            </div>
        </FrontendLayout>
    );
};

export default Confirmation;