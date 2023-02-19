<?php
date_default_timezone_set("Africa/Cairo");
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
        Schema::create('invoices_detailes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_Invoice')->constrained('invoices', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('Invoice_number', 50);
            $table->string('product', 50);
            $table->string('section', 50);
            $table->string('status', 50);
            $table->integer('value_status');
            $table->date('PaymentDate')->nullable();
            $table->text('note')->nullable();
            $table->string('user', 300);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices_detailes');
    }
};