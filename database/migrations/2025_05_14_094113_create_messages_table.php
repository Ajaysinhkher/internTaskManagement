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
      Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // Sender (polymorphic)
            $table->morphs('sender');  // creates sender_id and sender_type
            // Receiver (polymorphic)
            $table->morphs('receiver'); // creates receiver_id and receiver_type
            $table->text('message');
            $table->timestamp('read_at')->nullable(); // for read/unread status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
