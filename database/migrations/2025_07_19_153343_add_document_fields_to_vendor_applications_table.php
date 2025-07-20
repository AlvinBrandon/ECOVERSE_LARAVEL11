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
        Schema::table('vendor_applications', function (Blueprint $table) {
            $table->string('registration_certificate')->nullable()->after('status');
            $table->string('ursb_document')->nullable()->after('registration_certificate');
            $table->string('trading_license')->nullable()->after('ursb_document');
            $table->string('tin')->nullable()->after('trading_license');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_applications', function (Blueprint $table) {
            $table->dropColumn(['registration_certificate', 'ursb_document', 'trading_license', 'tin']);
        });
    }
};
