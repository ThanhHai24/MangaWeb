<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('manga_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->comment('Đánh giá từ 1-5 sao');
            $table->timestamps();
            
            $table->unique(['user_id', 'manga_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
};
