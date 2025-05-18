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
        Schema::create('category_manga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manga_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['manga_id', 'category_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_manga');
    }
};
