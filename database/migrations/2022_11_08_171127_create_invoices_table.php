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
        Schema::create('invoices', function (Blueprint $table) {

            $table->id();
            $table->string('invoice_number', 50)->unique();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('product', 50);
            $table->foreignId('section_id')->constrained('sections', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('Amount_Collection', 8, 2)->nullable();
            $table->decimal('Amount_Commission', 8, 2);
            $table->decimal('Discount', 8, 2);
            $table->decimal('Value_Vat', 8, 2);
            $table->string('Rate_Vat');
            $table->decimal('Total', 8, 2);
            $table->string('Status');
            $table->integer('Value_Status');
            $table->text('note')->nullable();
            $table->date('Payment_Date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
};