<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Devices table indexes
        Schema::table('devices', function (Blueprint $table) {
            $table->index(['manufacturer_id', 'device_type_id'], 'devices_manufacturer_type_idx');
            $table->index('recall_period', 'devices_recall_period_idx');
            $table->index('name', 'devices_name_idx');
        });

        // Doctor devices table indexes
        Schema::table('doctor_devices', function (Blueprint $table) {
            $table->index(['device_id', 'room_id'], 'doctor_devices_device_room_idx');
            $table->index('last_certification_date', 'doctor_devices_cert_date_idx');
            $table->index('serial_number', 'doctor_devices_serial_idx');
        });

        // Locations table indexes
        Schema::table('locations', function (Blueprint $table) {
            $table->index('user_id', 'locations_user_idx');
            $table->index(['city', 'postal_code'], 'locations_city_postal_idx');
        });

        // Rooms table indexes
        Schema::table('rooms', function (Blueprint $table) {
            $table->index('location_id', 'rooms_location_idx');
        });

        // Attachments table indexes
        Schema::table('attachments', function (Blueprint $table) {
            $table->index('doctor_device_id', 'attachments_doctor_device_idx');
        });

        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            $table->index('user_id', 'users_employer_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropIndex('devices_manufacturer_type_idx');
            $table->dropIndex('devices_recall_period_idx');
            $table->dropIndex('devices_name_idx');
        });

        Schema::table('doctor_devices', function (Blueprint $table) {
            $table->dropIndex('doctor_devices_device_room_idx');
            $table->dropIndex('doctor_devices_cert_date_idx');
            $table->dropIndex('doctor_devices_serial_idx');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropIndex('locations_user_idx');
            $table->dropIndex('locations_city_postal_idx');
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropIndex('rooms_location_idx');
        });

        Schema::table('attachments', function (Blueprint $table) {
            $table->dropIndex('attachments_doctor_device_idx');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_employer_idx');
        });
    }
};
