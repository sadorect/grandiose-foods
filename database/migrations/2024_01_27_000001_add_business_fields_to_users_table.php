<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_name')->nullable();
            //$table->string('phone')->nullable();
            $table->string('business_registration')->nullable();
            $table->string('tax_id')->nullable();
            $table->boolean('is_business_verified')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                
                'business_registration',
                'tax_id',
                'is_business_verified'
            ]);
        });
    }
};
