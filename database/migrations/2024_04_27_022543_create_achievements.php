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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->date('current_date');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->time('total_time')->nullable();
            $table->string('event_name')->nullable();
            $table->boolean('status')->default(false);
            
            $table->timestamps();
     /**
     * $table->unsignedBigInteger('user_id');
     * $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
     * 
     */ 
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('achievements');
    }
};
