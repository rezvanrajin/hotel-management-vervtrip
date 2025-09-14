<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

protected $fillable = [
    'room_id',
    'user_id',
    'guest_first_name',
    'guest_last_name',
    'guest_email',
    'guest_phone',
    'guest_address', 
    'guest_country', 
    'guest_city',    
    'guest_zip_code', 
    'check_in_date',
    'check_out_date',
    'number_of_nights',
    'number_of_guests',
    'number_of_rooms',
    'room_price_per_night',
    'sub_total',
    'tax_amount',
    'discount_amount',
    'total_amount',
    'currency',
    'special_requests',
    'status',
    'payment_status',
    'payment_method',
    'transaction_id',
    'payment_date',
    'cancelled_at',
    'cancellation_reason',
    'checked_in_at',
    'checked_out_at',
    'admin_notes',
    'booking_source'
];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'room_price_per_night' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'cancelled_at' => 'datetime',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
    ];

    // Relationships
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

 public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Accessor for full guest name
     */
    public function getGuestFullNameAttribute()
    {
        if ($this->user_id && $this->user) {
            // If it's a registered user, use their name
            return $this->user->first_name . ' ' . $this->user->last_name;
        }
        
        // Otherwise use guest information
        return $this->guest_first_name . ' ' . $this->guest_last_name;
    }

    /**
     * Accessor for guest email
     */
    public function getGuestEmailAttribute($value)
    {
        if ($this->user_id && $this->user) {
            return $this->user->email;
        }
        
        return $value;
    }

    /**
     * Accessor for guest phone
     */
    public function getGuestPhoneAttribute($value)
    {
        if ($this->user_id && $this->user) {
            return $this->user->phone;
        }
        
        return $value;
    }

    public function payments(): HasMany
    {
        return $this->hasMany(BookingPayment::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCheckedIn($query)
    {
        return $query->where('status', 'checked_in');
    }

    public function scopeCheckedOut($query)
    {
        return $query->where('status', 'checked_out');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function isGuestBooking(): bool
    {
        return is_null($this->user_id);
    }

    public function getGuestFullName(): string
    {
        if ($this->isGuestBooking()) {
            return $this->guest_first_name . ' ' . $this->guest_last_name;
        }

        return $this->user->name;
    }

    public function getGuestEmail(): string
    {
        return $this->isGuestBooking() ? $this->guest_email : $this->user->email;
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']) && 
               $this->check_in_date > now();
    }
    public function canBeDeleted()
{
    // Cannot delete checked-in bookings
    if ($this->status === 'checked_in') {
        return false;
    }
    
    // Cannot delete bookings with paid payments
    if ($this->payment_status === 'paid') {
        return false;
    }
    
    // Cannot delete bookings that are too close to check-in
    if ($this->status === 'confirmed' && 
        $this->check_in_date <= now()->addDays(2)) {
        return false;
    }
    
    // Add other business rules as needed
    
    return true;
}

// Get deletion restrictions
public function getDeletionRestrictions()
{
    $restrictions = [];
    
    if ($this->status === 'checked_in') {
        $restrictions[] = 'Guest is currently checked in';
    }
    
    if ($this->payment_status === 'paid') {
        $restrictions[] = 'Booking has paid payments';
    }
    
    if ($this->status === 'confirmed' && $this->check_in_date <= now()->addDays(2)) {
        $restrictions[] = 'Check-in is within 2 days';
    }
    
    if ($this->invoices()->exists()) {
        $restrictions[] = 'Booking has associated invoices';
    }
    
    if ($this->payments()->exists()) {
        $restrictions[] = 'Booking has payment records';
    }
    
    return $restrictions;
}
}