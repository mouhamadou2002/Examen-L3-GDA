<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('total', 10, 2);
            $table->enum('status', ['en_attente', 'expediee', 'livree', 'annulee'])->default('en_attente');
            $table->enum('payment_status', ['non_paye', 'paye'])->default('non_paye');
            $table->enum('payment_mode', ['en_ligne', 'a_la_livraison'])->default('a_la_livraison');
            $table->string('delivery_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
