<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('token', 64)->unique()->nullable();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete(); 
            $table->foreignId('contact_id')->nullable()->constrained('contacts')->nullOnDelete(); 
            $table->foreignId('counterparty_id')->nullable()->constrained('users')->nullOnDelete(); 
            $table->enum('type', ['hutang', 'piutang']); 
            $table->decimal('amount', 15, 2); 
            $table->decimal('remaining_amount', 15, 2); 
            $table->date('due_date')->nullable();
            $table->enum('status', ['PENDING_APPROVAL', 'ACTIVE', 'DISPUTED', 'PAID'])->default('ACTIVE');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};