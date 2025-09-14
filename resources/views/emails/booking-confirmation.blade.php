<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4f46e5; color: white; padding: 20px; text-align: center; }
        .content { background: #f9fafb; padding: 20px; }
        .footer { background: #e5e7eb; padding: 20px; text-align: center; font-size: 12px; }
        .booking-details { background: white; padding: 20px; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Hotel Paradise</h1>
            <h2>Booking Confirmation</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $booking->guest_first_name }} {{ $booking->guest_last_name }},</p>
            <p>Thank you for choosing Hotel Paradise! Your booking has been confirmed.</p>
            
            <div class="booking-details">
                <h3>Booking Details</h3>
                <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
                <p><strong>Room:</strong> {{ $booking->room->room_type }} Room #{{ $booking->room->room_number }}</p>
                <p><strong>Check-in:</strong> {{ $booking->check_in_date }}</p>
                <p><strong>Check-out:</strong> {{ $booking->check_out_date }}</p>
                <p><strong>Guests:</strong> {{ $booking->number_of_guests }}</p>
                <p><strong>Nights:</strong> {{ $booking->number_of_nights }}</p>
                <p><strong>Total Amount:</strong> {{ $booking->total_amount }} {{ $booking->currency }}</p>
                <p><strong>Status:</strong> Confirmed</p>
            </div>
            
            <p>We look forward to welcoming you to Hotel Paradise!</p>
            
            <p>Best regards,<br>Hotel Paradise Team</p>
        </div>
        
        <div class="footer">
            <p>© 2024 Hotel Paradise. All rights reserved.</p>
            <p>If you have any questions, please contact us at info@hotelparadise.com</p>
        </div>
    </div>
</body>
</html>