# Hotel Booking System

A full-featured **Hotel Booking System** built with **PHP 8.1** and **Laravel 12**. This project provides both a **React + Inertia frontend** and a **Laravel Blade admin backend**, with features for users, guests, and administrators.  

---

## Features

### General
- Developed with **PHP 8.1** and **Laravel 12**
- Clean architecture using **Repository Pattern**
- **Model Accessors & Mutators** for clean and reusable model logic
- **Eloquent ORM** with model relationships
- **Seeder & Factory** for dummy data generation
- **Role-based access control**
  - Admin: full access to manage everything
  - Logged-in User: can view, edit, and manage their own bookings
  - Guest (without login): can create bookings

### Admin Backend (Laravel Blade)
- Built with **Bootstrap 5** for responsive layout
- **SweetAlert2** for interactive alerts
- **AJAX form submissions** for smooth UX
- Admin dashboard: manage users, bookings, payments, notifications
- Real-time notifications for new bookings and updates
- Email notifications on user registration and booking events

### Frontend (React + Inertia)
- Fully integrated **Laravel Inertia.js + React**
- Booking system available for logged-in users and guests
- Payment options integrated (credit card, PayPal, etc.)
- Dynamic form handling and real-time updates

### Booking & Payment
- Users and guests can create bookings with:
  - Room selection
  - Check-in / Check-out dates
  - Number of guests & rooms
  - Special requests
- Admin can manage bookings: edit, cancel, check-in/out
- Payment integration with multiple options
- Status tracking: pending, confirmed, checked-in, checked-out, cancelled, refunded

### Notifications
- Real-time notifications using Laravel broadcasting
- Email notifications for:
  - User registration
  - Booking confirmation
  - Booking status changes

---



