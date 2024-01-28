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
        Schema::create('book_reader', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reader_id')->constrained('readers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade')->onUpdate('cascade');
            $table->date('borrow_date')->nullable(false);
            $table->date('return_date')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_reader');
    }
};
