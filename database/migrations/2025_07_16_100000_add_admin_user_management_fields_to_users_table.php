<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('active')->default(true)->after('role_as'); // For suspend/activate
            $table->boolean('verified')->default(false)->after('active'); // For manual verification
            $table->string('profile_photo')->nullable()->after('verified'); // For profile photo
            $table->string('business_info')->nullable()->after('profile_photo'); // For business info
            $table->string('vendor_id')->nullable()->after('business_info'); // For vendor/customer ID
            $table->timestamp('last_login_at')->nullable()->after('vendor_id'); // For last login
            $table->string('last_login_ip')->nullable()->after('last_login_at'); // For audit log
            $table->json('audit_log')->nullable()->after('last_login_ip'); // For activity log
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'active',
                'verified',
                'profile_photo',
                'business_info',
                'vendor_id',
                'last_login_at',
                'last_login_ip',
                'audit_log',
            ]);
        });
    }
};
