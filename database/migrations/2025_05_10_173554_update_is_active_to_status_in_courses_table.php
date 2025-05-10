<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            // Change 'is_active' to 'status'
            $table->dropColumn('is_active');  // Drop the old column
            $table->string('status')->default('available')->after('description');  // Add the new 'status' column
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            // Revert the changes if the migration is rolled back
            $table->boolean('is_active')->default(true);
            $table->dropColumn('status');
        });
    }

};
