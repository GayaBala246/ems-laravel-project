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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emp_id')->constrained('employees')->cascadeOnDelete();
            $table->text('title');
            $table->string('shift_date');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('checked_in')->nullable();// Nullable because attendance happens later
            $table->string('checked_out')->nullable(); // Nullable because attendance happens later
            $table->decimal('hours_worked', 5, 2)->nullable(); // Auto-calculated after check-out every shift
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
        Schema::dropIfExists('shifts');
    }
};
