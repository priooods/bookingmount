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
        Schema::create('t_climbers_tabs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->string('realname');
            $table->string('nik');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->tinyInteger('gender')->comment('0 = wanita, 1 = pria');
            $table->integer('age');
            $table->dateTime('start_climb');
            $table->dateTime('end_climb');
            $table->string('file_ktp');
            $table->string('emergency_name');
            $table->string('emergency_phone');
            $table->unsignedInteger('m_status_tabs');
            $table->string('file_payment');
            $table->integer('count_friend');
            $table->text('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_climbers_tabs');
    }
};
