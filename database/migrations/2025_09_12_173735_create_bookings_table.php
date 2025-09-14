<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_id')->constrained()->onDelete('cascade');

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('guest_first_name')->nullable();
            $table->string('guest_last_name')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('guest_phone')->nullable();
            $table->text('guest_address')->nullable();
            $table->string('guest_country')->nullable();
            $table->string('guest_city')->nullable();
            $table->string('guest_zip_code')->nullable();

            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('number_of_nights');
            $table->integer('number_of_guests');
            $table->integer('number_of_rooms')->default(1);

            $table->decimal('room_price_per_night', 10, 2);
            $table->decimal('sub_total', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('currency', 3)->default('USD');

            $table->text('special_requests')->nullable();

            $table->enum('status', [
                'pending',
                'confirmed',
                'checked_in',
                'checked_out',
                'cancelled',
                'no_show',
                'refunded'
            ])->default('pending');

            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamp('payment_date')->nullable();
            
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();

            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();

            $table->text('admin_notes')->nullable();

            $table->enum('booking_source', [
                'website',
                'walk_in',
                'phone',
                'email',
                'travel_agent',
                'booking_platform'
            ])->default('website');

            $table->timestamps();

            $table->index(['status', 'check_in_date']);
            $table->index(['user_id', 'status']);
            $table->index(['guest_email', 'status']);
            $table->index('payment_status');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};