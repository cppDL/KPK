<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lesson_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->integer('page_number');
            $table->text('content'); // Could be text, HTML, Markdown, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_pages');
    }
};
