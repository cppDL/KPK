<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->string('status')->default('available')->after('description');  // Add the new 'status' column
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
            $table->dropColumn('status');
        });
    }

};
