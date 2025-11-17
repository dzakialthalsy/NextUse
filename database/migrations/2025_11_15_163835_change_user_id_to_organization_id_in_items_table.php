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
        Schema::table('items', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Drop foreign key constraint for organization_id
            $table->dropForeign(['organization_id']);
            // Drop organization_id column
            $table->dropColumn('organization_id');
            // Add user_id column back
            $table->foreignId('user_id')->after('id')->constrained('users')->onDelete('cascade');
        });
    }
};
