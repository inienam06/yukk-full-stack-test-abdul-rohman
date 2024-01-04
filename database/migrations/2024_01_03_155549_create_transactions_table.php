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
        Schema::create('t_transaction', function (Blueprint $table) {
            $table->increments('transaction_id');
            $table->unsignedInteger('user_id');
            $table->string('transaction_code', 50)->unique();
            $table->enum('type', ['topup', 'transaction']);
            $table->bigInteger('amount');
            $table->string('description', 200);
            $table->string('transfer_receipt', 200)->nullable();
            $table->timestamps();

            $table->foreign('user_id')
            ->references('user_id')
            ->on('tbl_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_transaction');
    }
};
